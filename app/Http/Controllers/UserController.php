<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{

    public function assignRolesAndPermissions(Request $request, User $user)
    {
        $user->syncRoles($request->input('roles', []));
        $user->syncPermissions($request->input('permissions', []));

        return redirect()->route("profile.index")->with('success', 'Roles y permisos asignados con éxito!');
    }

    public function assignRolesAndPermissionsView(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::paginate(10)->withQueryString();
        

        return Inertia::render("Profile/Assign", [
            'titulo'      => 'Asignar Roles y Permisos',
            'user'    => $user,
            'user_roles' => $user->getRolesArray(),
            'user_permissions' => $user->getPermissionArray(),
            'roles'    => $roles,
            'permissions'    => $permissions,
        ]);
    }
}
