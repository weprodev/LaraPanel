<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use Illuminate\Routing\Controller;
use WeProDev\LaraPanel\Core\User\Repository\TeamRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;

class TeamsController extends Controller
{
    protected string $baseViewPath;

    private TeamRepositoryInterface $teamRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct()
    {
        $this->teamRepository = resolve(TeamRepositoryInterface::class);
        $this->userRepository = resolve(UserRepositoryInterface::class);
        $this->baseViewPath = UserServiceProvider::$LPanel_Path.'.User.team.';
    }

    public function index()
    {
        $team = $this->departmentRepository->all();

        return view($this->baseViewPath.'index', compact('team'));
    }

    public function create()
    {
        $team = $this->teamRepository->all();

        return view($this->baseViewPath.'create', compact('team'));
    }

    public function edit(int $ID)
    {
        if ($team = $this->teamRepository->find($ID)) {
            $team = $this->teamRepository->all();

            return view($this->baseViewPath.'edit', compact('team'));
        }

        return redirect()->route('admin.user_management.department.index')->with('message', [
            'type' => 'danger',
            'text' => 'Department does not exist!',
        ]);
    }

    public function store(StoreDepartment $request)
    {
        $parent = null;
        if ($request->parent_id && $findDepartment = $this->departmentRepository->find($request->parent_id)) {
            $parent = $findDepartment->id;
        }

        $this->departmentRepository->store([
            'title' => $request->title,
            'parent_id' => $parent,
        ]);

        return redirect()->route('admin.user_management.department.index')->with('message', [
            'type' => 'success',
            'text' => "This department << {$request->title} >> created successfully.",
        ]);
    }

    public function update(int $ID, UpdateDepartment $request)
    {
        if ($department = $this->departmentRepository->find($ID)) {
            $parent = null;
            if ($request->parent_id && $findDepartment = $this->departmentRepository->find($request->parent_id)) {
                $parent = $findDepartment->id;
            }

            $this->departmentRepository->update($ID, [
                'title' => $request->title,
                'parent_id' => $parent,
            ]);

            return redirect()->route('admin.user_management.department.index')->with('message', [
                'type' => 'success',
                'text' => "This department << {$request->title} >> updated successfully.",
            ]);
        }

        return redirect()->route('admin.user_management.department.index')->with('message', [
            'type' => 'danger',
            'text' => 'Department does not exist!',
        ]);
    }

    public function delete(int $ID)
    {
        if ($this->teamRepository->find($ID)) {
            $this->teamRepository->delete($ID);

            return redirect()->route('admin.user_management.department.index')->with('message', [
                'type' => 'warning',
                'text' => 'Department deleted successfully!',
            ]);
        }

        return redirect()->route('admin.user_management.department.index')->with('message', [
            'type' => 'danger',
            'text' => 'Department does not exist!',
        ]);
    }
}
