<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Http\Requests\{
    StorePermission as StorePermissionRequest,
    UpdatePermission as UpdatePermissionRequest
};
use Auth;
use Gate;
use App\Permission;

/**
 * Class PermissionController
 * @package App\Http\Controllers\Admin
 */
class PermissionController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $permissions = Permission::orderBy('id', 'asc')
            ->paginate(Config::get('app.paginate.main'));

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * @param StorePermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePermissionRequest $request)
    {
        $data = $request->only('name', 'description');
        $data['slug'] = str_slug($data['name']);

        Permission::create($data);

        return redirect()->route('list_permissions');
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * @param Permission $permission
     * @param UpdatePermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Permission $permission, UpdatePermissionRequest $request)
    {
        $data = $request->only('name', 'description');
        $data['slug'] = str_slug($data['name']);

        $permission->fill($data)->save();

        return redirect()->route('show_permission', [
            'id' => $permission->id
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.show', compact('permission'));
    }
}
