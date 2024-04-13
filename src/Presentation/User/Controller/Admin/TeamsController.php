<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use Illuminate\Routing\Controller;
use WeProDev\LaraPanel\Core\User\Repository\TeamRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;

class TeamsController extends Controller
{
    protected $departmentRepository;

    protected $userRepository;

    public function __construct(
        TeamRepositoryInterface $department,
        UserRepositoryInterface $user
    ) {
        $this->departmentRepository = $department;
        $this->userRepository = $user;
    }

    public function index()
    {
        $departments = $this->departmentRepository->all();

        return view('user-management.department.index', compact('departments'));
    }

    public function create()
    {
        $departments = $this->departmentRepository->all();

        return view('user-management.department.create', compact('departments'));
    }

    public function edit(int $ID)
    {
        if ($department = $this->departmentRepository->find($ID)) {
            $departments = $this->departmentRepository->all();

            return view('user-management.department.edit', compact('department', 'departments'));
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
        if ($department = $this->departmentRepository->find($ID)) {
            $this->departmentRepository->delete($ID);

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
