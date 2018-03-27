<?php

namespace App\Http\Controllers\UserManager;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('roles.index');
    }

    public function list()
    {
    	return Role::all();
    }

    public function insert(Request $request)
    {
    	Role::create(['name' => $request->name]);

    	return ezReturnSuccessMessage('Role inserted successfully!');
    }

    public function update(Request $request)
    {
    	$role = Role::findOrFail($request->id);
    	$role->name = $request->name;

    	$role->save();
    	return ezReturnSuccessMessage('Role updated successfully!');
    }

    public function destroy(Request $request)
    {
    	$role = Role::findOrFail($request->id);
    	$role->delete();
    	return ezReturnSuccessMessage('Role deleted successfully!');
    }

    //
    // Permission related actions
    //


    public function showPermissions(Request $request)
    {
        return view('roles.role_permissions')->with('role_id', $request->role_id);
    }

    public function listRolePermissions(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $roleOldPermissions = collect($role->permissions()->pluck('name')->all());

        if($roleOldPermissions->isNotEmpty()) {
            return Permission::all()->map(function ($permission, $key) use ($roleOldPermissions) {
                    $permission->status = $roleOldPermissions->contains($permission->name);
                    return $permission;
                });
        }

        return Permission::all();

    }

    public function setPermission(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);

        ($role->hasPermissionTo($permission->name)) ? $role->revokePermissionTo($permission) : $role->givePermissionTo($permission->name);

        return ezReturnSuccessMessage('Permission successfully granted to role!');

    }

}






//
