<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Role\CreateRole;
use App\Actions\Role\UpdateRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleFormRequest;
use App\Models\Admin;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    use ValidatesRequests;

    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (is_null($this->user) || ! $this->user->can('role.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any role.');
        }
        try {
            $roles = Role::SimplePaginate(10);

            return view('admin.roles.index', compact('roles'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (is_null($this->user) || ! $this->user->can('role.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any role.');
        }
        try {
            $permissions = Permission::all();
            $permission_groups = Admin::getPermissionGroup();

            return view('admin.roles.create', compact('permissions', 'permission_groups'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(RoleFormRequest $request)
    {
        if (is_null($this->user) || ! $this->user->can('role.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any role.');
        }

        try {
            CreateRole::create($request);

            flashSuccess('Role Created Successfully');

            return back();
        } catch (\Throwable $th) {
            flashError($th->getMessage());

            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Role $role)
    {
        if (is_null($this->user) || ! $this->user->can('role.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any role.');
        }
        try {
            $permissions = Permission::all();
            $permission_groups = Admin::getPermissionGroup();

            return view('admin.roles.edit', compact('permissions', 'permission_groups', 'role'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(RoleFormRequest $request, Role $role)
    {
        if (is_null($this->user) || ! $this->user->can('role.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any role.');
        }

        try {
            UpdateRole::update($request, $role);

            flashSuccess('Role Updated Successfully');

            return back();
        } catch (\Throwable $th) {
            flashError($th->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(Role $role)
    {
        if (is_null($this->user) || ! $this->user->can('role.delete')) {
            abort(403, 'Unauthorized Access');
        }

        try {
            if (! is_null($role)) {
                $role->delete();
            }

            flashSuccess('Role Deleted Successfully');

            return back();
        } catch (\Throwable $th) {
            flashError($th->getMessage());

            return back();
        }
    }
}
