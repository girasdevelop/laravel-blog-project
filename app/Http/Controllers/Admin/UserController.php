<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUser as UpdateUserRequest;
use App\{Role, User};
use App\Interfaces\User as UserInterface;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('id', 'asc')
            ->paginate(Config::get('app.paginate.main'));

        return view('admin.users.index', compact('users'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $allRoles = Role::orderBy('id', 'desc')->pluck('name', 'id');
        $currentRoles = old('roles') ? old('roles') : $user->roles->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'allRoles', 'currentRoles'));
    }

    /**
     * @param User $user
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $user->fill($request->all())->save();

        return redirect()->route('show_user', [
            'id' => $user->id
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(User $user)
    {
        $user->delete();

        return redirect()->route('list_users');
    }
}
