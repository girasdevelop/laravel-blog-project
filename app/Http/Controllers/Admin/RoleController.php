<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Http\Requests\{
    StoreRole as StoreRoleRequest,
    UpdateRole as UpdateRoleRequest
};
use Auth;
use Gate;
use App\{Role, Permission};

/**
 * Class RoleController
 * @package App\Http\Controllers\Admin
 */
class RoleController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')
            ->paginate(Config::get('app.paginate.main'));

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $allPermissions = Permission::orderBy('id', 'desc')->pluck('name', 'id');

        return view('admin.roles.create', compact('allPermissions'));
    }

    /**
     * @param StoreRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoleRequest $request)
    {
        Role::create($request->all());

        return redirect()->route('list_roles');
    }

    /**
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $allPermissions = Permission::orderBy('id', 'desc')->pluck('name', 'id');
        $currentPermissions = old('permissions') ? old('permissions') : $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'allPermissions', 'currentPermissions'));
    }

    /**
     * @param Role $role
     * @param UpdateRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $role->fill($request->all())->save();

        return redirect()->route('show_role', [
            'id' => $role->id
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        return view('admin.roles.show', compact('role'));
    }

    /**
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Role $role)
    {
        $role->delete();

        return redirect()->route('list_roles');
    }
}
