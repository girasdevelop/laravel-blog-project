<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUser as UpdateUserRequest;
use App\Helpers\Helper;
use App\Role;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{
    /**
     * @var string
     */
    private $userModelClass;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userModelClass = config('rbac.userModelClass');

        Helper::checkUserInstance($this->userModelClass);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = call_user_func([
            $this->userModelClass,
            'with',
        ], 'roles')->orderBy('id', 'asc')
            ->paginate(Config::get('app.paginate.main'));

        return view('admin.users.index', compact('users'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $user = $this->findOrFail($id);

        $allRoles = Role::orderBy('id', 'desc')->pluck('name', 'id');
        $currentRoles = old('roles') ? old('roles') : $user->roles->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'allRoles', 'currentRoles'));
    }

    /**
     * @param int $id
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $id, UpdateUserRequest $request)
    {
        $this->findOrFail($id)
            ->fill($request->all())
            ->save();

        return redirect()->route('show_user', [
            'id' => $id
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = $this->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id)
    {
        $this->findOrFail($id)->delete();

        return redirect()->route('list_users');
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findOrFail(int $id)
    {
        return call_user_func([
            $this->userModelClass,
            'findOrFail',
        ], $id);
    }
}
