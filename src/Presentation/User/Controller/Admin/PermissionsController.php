<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use WeProDev\LaraPanel\Core\Shared\Enum\AlertTypeEnum;
use WeProDev\LaraPanel\Core\User\Dto\PermissionDto;
use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;
use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\Shared\Provider\SharedServiceProvider;
use WeProDev\LaraPanel\Presentation\User\Requests\Admin\StorePermissionRequest;
use WeProDev\LaraPanel\Presentation\User\Requests\Admin\UpdatePermissionRequest;

class PermissionsController
{
    private ?FormRequest $storePermissionRequestClass = null;

    private ?FormRequest $updatePermissionRequestClass = null;

    private array $guards = [];

    private array $modules = [];

    protected string $baseViewPath;

    private PermissionRepositoryInterface $permissionRepository;

    public function __construct()
    {
        $this->permissionRepository = resolve(PermissionRepositoryInterface::class);
        $this->baseViewPath = SharedServiceProvider::$LPanel_Path.'.User.permission.';
        $this->guards = GuardTypeEnum::all();
        $this->modules = config('larapanel.permission.module.list', []);
    }

    public function index(): View
    {
        $permissions = $this->permissionRepository->paginate(config('larapanel.pagination'));

        return view($this->baseViewPath.'index', compact('permissions'));
    }

    public function create(): View
    {
        return view($this->baseViewPath.'create')->with([
            'guards' => $this->guards,
            'defaultGuard' => GuardTypeEnum::default()->value,
            'modules' => $this->modules,
            'defaultModule' => config('larapanel.permission.module.default', end($this->modules)),
        ]);
    }

    public function edit(int $permissionId): View|RedirectResponse
    {
        if ($permission = $this->permissionRepository->findBy(['id' => $permissionId])) {

            return view($this->baseViewPath.'edit')->with([
                'guards' => $this->guards,
                'permission' => $permission,
                'modules' => $this->modules,
            ]);
        }

        return redirect()->route('lp.admin.permission.index')->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The permission does not exist!'),
        ]);
    }

    protected function setStoreRequestClass(string $storeRequestClass): void
    {
        if (is_subclass_of($storeRequestClass, FormRequest::class)) {
            $this->storePermissionRequestClass = app($storeRequestClass);
        }
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $this->storePermissionRequestClass ??= app(StorePermissionRequest::class);
        $request->validate($this->storePermissionRequestClass->rules());

        $permDto = PermissionDto::make(
            $request->name,
            $request->title ?? $request->name,
            $request->module,
            $request->description,
            $request->guard_name ? GuardTypeEnum::getGuardType($request->guard_name ?? GuardTypeEnum::default()) : null,
        );
        $this->permissionRepository->create($permDto);

        return redirect()->route('lp.admin.permission.index')->with('message', [
            'type' => AlertTypeEnum::SUCCESS->value,
            'text' => __('The permission :permission created successfully!', ['permission' => $request->name]),
        ]);
    }

    protected function setUpdateRequestClass(string $updateRequestClass): void
    {
        if (is_subclass_of($updateRequestClass, FormRequest::class)) {
            $this->updatePermissionRequestClass = app($updateRequestClass);
        }
    }

    public function update(int $permissionId, FormRequest $request): RedirectResponse
    {
        $this->updatePermissionRequestClass ??= app(UpdatePermissionRequest::class);
        $request->validate($this->updatePermissionRequestClass->rules());

        if ($permission = $this->permissionRepository->findBy(['id' => $permissionId])) {
            $permDto = PermissionDto::make(
                $permission->getName(),
                $request->title ?? $permission->getName(),
                $request->module,
                $request->description,
                $request->guard_name ? GuardTypeEnum::getGuardType($request->guard_name ?? GuardTypeEnum::default()) : null,
            );
            $this->permissionRepository->update($permission, $permDto);

            return redirect()->route('lp.admin.permission.index')->with('message', [
                'type' => AlertTypeEnum::SUCCESS->value,
                'text' => __('The permission :permission has been successfully updated!', ['permission' => $permission->getName()]),
            ]);
        }

        return redirect()->route('lp.admin.permission.index')->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The permission does not exist!'),
        ]);
    }

    public function delete(int $permissionId): RedirectResponse
    {
        if ($permission = $this->permissionRepository->findBy(['id' => $permissionId])) {
            $name = $permission->getName();
            $this->permissionRepository->delete($permissionId);

            return redirect()->route('lp.admin.permission.index')->with('message', [
                'type' => AlertTypeEnum::WARNING->value,
                'text' => __('The permission :permission has been successfully deleted!', ['permission' => $name]),
            ]);
        }

        return redirect()->route('lp.admin.permission.index')->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The permission does not exist!'),
        ]);
    }
}
