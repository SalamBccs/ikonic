<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function getPermissions() {
        $user = Auth::user();
        $role = $user->roles()->first();

        // $role =  Role::where($request->roleId);
        return $permissions = $role->getPermissionNames();//->pluck('name')->toArray();
        return response()->json([
            'permissions' => $permissions
        ]);
    }
   
}
