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
        $permissions = Permission::orderBy('id', 'desc')->pluck('name', 'id');
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * @param StoreRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $data = $request->only('name', 'description', 'permissions');
        $data['slug'] = str_slug($data['name']);
        $data['permissions'] = json_encode($data['permissions']);

        Role::create($data);

        return redirect()->route('list_roles');
    }

    /**
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * @param Role $role
     * @param UpdateRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $data = $request->only('name', 'description', 'permissions');
        $data['slug'] = str_slug($data['name']);
        $data['permissions'] = json_encode($data['permissions']);

        $role->fill($data)->save();

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
}
