<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use WeProDev\LaraPanel\Core\Shared\Enum\AlertTypeEnum;
use WeProDev\LaraPanel\Core\User\Dto\GroupDto;
use WeProDev\LaraPanel\Core\User\Repository\GroupRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\Shared\Provider\SharedServiceProvider;
use WeProDev\LaraPanel\Presentation\User\Requests\Admin\StoreGroupRequest;
use WeProDev\LaraPanel\Presentation\User\Requests\Admin\UpdateGroupRequest;

class GroupsController
{
    private ?FormRequest $storeGroupRequestClass = null;

    private ?FormRequest $updateGroupRequestClass = null;

    protected string $baseViewPath;

    private GroupRepositoryInterface $groupRepository;

    public function __construct()
    {
        $this->groupRepository = resolve(GroupRepositoryInterface::class);
        $this->baseViewPath = SharedServiceProvider::$LPanel_Path.'.User.group.';
    }

    public function index(): View
    {
        $groups = $this->groupRepository->paginate(config('larapanel.pagination'));

        return view($this->baseViewPath.'index', compact('groups'));
    }

    public function create(): View
    {
        $groups = $this->groupRepository->pluckAll();

        return view($this->baseViewPath.'create', compact('groups'));
    }

    public function edit(string $groupId): View|RedirectResponse
    {
        $groupId = (int) $groupId;
        if ($group = $this->groupRepository->findById($groupId)) {
            $groups = $this->groupRepository->pluckAll();

            return view($this->baseViewPath.'edit', compact('group', 'groups'));
        }

        return redirect()->route('lp.admin.group.index')->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The group does not exist!'),
        ]);
    }

    protected function setStoreRequestClass(string $storeRequestClass): void
    {
        if (is_subclass_of($storeRequestClass, FormRequest::class)) {
            $this->storeGroupRequestClass = app($storeRequestClass);
        }
    }

    public function store(FormRequest $request)
    {
        $this->storeGroupRequestClass ??= app(StoreGroupRequest::class);
        $request->validate($this->storeGroupRequestClass->rules());

        $parent = (int) $request->parent_id ? $this->groupRepository->findById((int) $request->parent_id)->getId() : null;

        $groupDto = GroupDto::make(
            $request->name,
            $request->title ?? $request->name,
            $parent,
            $request->description
        );
        $this->groupRepository->create($groupDto);

        return redirect()->route('lp.admin.group.index')->with('message', [
            'type' => AlertTypeEnum::SUCCESS->value,
            'text' => __('The group :group created successfully.', ['group' => $request->name]),
        ]);
    }

    protected function setUpdateRequestClass(string $updateRequestClass): void
    {
        if (is_subclass_of($updateRequestClass, FormRequest::class)) {
            $this->updateGroupRequestClass = app($updateRequestClass);
        }
    }

    public function update(string $groupId, FormRequest $request): RedirectResponse
    {
        $this->updateGroupRequestClass ??= app(UpdateGroupRequest::class);
        $request->validate($this->updateGroupRequestClass->rules());

        $groupId = (int) $groupId;
        if ($group = $this->groupRepository->findById($groupId)) {

            $parent = (int) $request->parent_id ? $this->groupRepository->findById((int) $request->parent_id)->getId() : null;

            $groupDto = GroupDto::make($request->name, $request->title, $parent, $request->description);
            $this->groupRepository->update($group, $groupDto);

            return redirect()->route('lp.admin.group.index')->with('message', [
                'type' => AlertTypeEnum::SUCCESS->value,
                'text' => __('This group :group has been updated successfully.', ['group' => $request->name]),
            ]);
        }

        return redirect()->route('lp.admin.group.index')->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The group does not exist!'),
        ]);
    }

    public function delete(string $groupId): RedirectResponse
    {
        $groupId = (int) $groupId;
        if ($this->groupRepository->findById($groupId)) {

            $groupId = (int) $groupId;
            $this->groupRepository->delete($groupId);

            return redirect()->route('lp.admin.group.index')->with('message', [
                'type' => AlertTypeEnum::WARNING->value,
                'text' => 'The group deleted successfully!',
            ]);
        }

        return redirect()->route('lp.admin.group.index')->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The group does not exist!'),
        ]);
    }
}
