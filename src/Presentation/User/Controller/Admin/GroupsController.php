<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use Illuminate\Routing\Controller;
use WeProDev\LaraPanel\Core\User\Repository\GroupRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;

class GroupsController extends Controller
{
    protected string $baseViewPath;

    private GroupRepositoryInterface $groupRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct()
    {
        $this->groupRepository = resolve(GroupRepositoryInterface::class);
        $this->userRepository = resolve(UserRepositoryInterface::class);
        $this->baseViewPath = UserServiceProvider::$LPanel_Path.'.User.group.';
    }

    public function index()
    {
        $groups = $this->groupRepository->paginate(config('larapanel.pagination'));

        return view($this->baseViewPath.'index', compact('groups'));
    }

    // public function create()
    // {
    //     $group = $this->groupRepository->all();

    //     return view($this->baseViewPath . 'create', compact('group'));
    // }

    // public function edit(int $ID)
    // {
    //     if ($group = $this->groupRepository->find($ID)) {
    //         $group = $this->groupRepository->all();

    //         return view($this->baseViewPath . 'edit', compact('group'));
    //     }

    //     return redirect()->route('admin.user_management.department.index')->with('message', [
    //         'type' => 'danger',
    //         'text' => 'Department does not exist!',
    //     ]);
    // }

    // public function store(StoreDepartment $request)
    // {
    //     $parent = null;
    //     if ($request->parent_id && $findDepartment = $this->departmentRepository->find($request->parent_id)) {
    //         $parent = $findDepartment->id;
    //     }

    //     $this->groupRepository->store([
    //         'title' => $request->title,
    //         'parent_id' => $parent,
    //     ]);

    //     return redirect()->route('admin.user_management.department.index')->with('message', [
    //         'type' => 'success',
    //         'text' => "This department << {$request->title} >> created successfully.",
    //     ]);
    // }

    // public function update(int $ID, UpdateDepartment $request)
    // {
    //     if ($department = $this->departmentRepository->find($ID)) {
    //         $parent = null;
    //         if ($request->parent_id && $findDepartment = $this->departmentRepository->find($request->parent_id)) {
    //             $parent = $findDepartment->id;
    //         }

    //         $this->departmentRepository->update($ID, [
    //             'title' => $request->title,
    //             'parent_id' => $parent,
    //         ]);

    //         return redirect()->route('admin.user_management.department.index')->with('message', [
    //             'type' => 'success',
    //             'text' => "This department << {$request->title} >> updated successfully.",
    //         ]);
    //     }

    //     return redirect()->route('admin.user_management.department.index')->with('message', [
    //         'type' => 'danger',
    //         'text' => 'Department does not exist!',
    //     ]);
    // }

    // public function delete(int $ID)
    // {
    //     if ($this->groupRepository->find($ID)) {
    //         $this->groupRepository->delete($ID);

    //         return redirect()->route('admin.user_management.department.index')->with('message', [
    //             'type' => 'warning',
    //             'text' => 'Department deleted successfully!',
    //         ]);
    //     }

    //     return redirect()->route('admin.user_management.department.index')->with('message', [
    //         'type' => 'danger',
    //         'text' => 'Department does not exist!',
    //     ]);
    // }
}
