<?php

namespace App\Http\Controllers\UserManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
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
    	return view('permissions.index');
    }

    public function list()
    {
    	return Permission::all();
    }

    public function insert(Request $request)
    {
    	Permission::create(['name' => $request->name]);

    	return ezReturnSuccessMessage('Permission inserted successfully!');
    }

    public function update(Request $request)
    {
    	$permission = Permission::findOrFail($request->id);
    	$permission->name = $request->name;

    	$permission->save();
    	return ezReturnSuccessMessage('Permission updated successfully!');
    }

    public function destroy(Request $request)
    {
    	$permission = Permission::findOrFail($request->id);
    	$permission->delete();
    	return ezReturnSuccessMessage('Permission deleted successfully!');
    }

    //
    // Roles associated with permission
    //
    //
    // Permission related actions
    //


    public function showRoles(Request $request)
    {
        return view('permissions.permission_roles')->with('permission_id', $request->permission_id);
    }

    public function listPermissionRoles(Request $request)
    {
        $permission = Permission::findOrFail($request->permission_id);
        $permissionOldRoles = collect($permission->roles()->pluck('name')->all());

        if($permissionOldRoles->isNotEmpty()) {
            return Role::all()->map(function ($role, $key) use ($permissionOldRoles) {
                    $role->status = $permissionOldRoles->contains($role->name);
                    return $role;
                });
        }

        return Role::all();

    }

    public function setRole(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);

        ($role->hasPermissionTo($permission->name)) ? $role->revokePermissionTo($permission) : $role->givePermissionTo($permission->name);

        return ezReturnSuccessMessage('Role successfully changed for the permission!');

    }
}
