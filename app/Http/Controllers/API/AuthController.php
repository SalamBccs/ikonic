<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Operator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Twilio\Rest\Client;
use \Spatie\Permission\Models\Role;
use App\Http\Controllers\API\Response;

class AuthController extends Controller
{

    public function signup(Request $request)
    {
        $inputs = $request->all();
        $v = Validator::make($inputs, [
            'username' => 'required|string|alpha_dash|min:3|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => ($request->is('api/*')) ? $v->errors()->first() : $v->errors(),
                'user' => (object) []
            ]);
        }
        
        $user = User::create([
            'username' => $inputs['username'],
            'email' => $inputs['email'],
            'password' => Hash::make($inputs['password']),
        ]);

        $role = Role::find(1);
        $user->assignRole($role->name);

        Auth::login($user);

        $token = $user->createToken($user->email)->plainTextToken;

        $user->update([
            'activity_at' => Carbon::now(),
            'new_token' => $token,
            'isLogin' => 1,
        ]);

        $u = User::find($user->id)->only(['id', 'username', 'email']);
        $u['token'] = $token;
        $u['role'] = $user->roles()->first()->name;

        return response()->json([
            'success' => true,
            'message' => 'User registered Successfully.',
            'user' => $u,
        ]);
    }

   
    public function login(Request $request)
    {
        $inputs = $request->all();
        $v = Validator::make($inputs, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => ($request->is('api/*')) ? $v->errors()->first() : $v->errors(),
                'user' => (object) [],
            ]);
        }
      
            $credentials = $request->only(['email', 'password']);
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                if($request->is('api/*') && $user->roles()->first() && $user->roles()->first()->name != 'student')
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid Email / Password.',
                        'user' => (object) [],
                    ]);
                }

                $user->tokens()->delete();
                DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();

                $token = $user->createToken($user->email)->plainTextToken;

                if (!is_null($user->new_token)) {
                    $oldToken = $user->new_token;
                    $user->update([
                        'activity_at' => Carbon::now(),
                        'old_token' => $oldToken,
                        'new_token' => $token,
                        'isLogin' => 1,
                    ]);
                } else {
                    $user->update([
                        'activity_at' => Carbon::now(),
                        'new_token' => $token,
                        'isLogin' => 1,
                    ]);
                }

                $user1 = User::find($user->id)->only(['username', 'email', 'phone','id']);
                $user1['token'] = $token;
                $user1['role'] = $user->roles()->first()->name;

                return response()->json([
                    'success' => true,
                    'message' => 'User Login Successfully.',
                    'user' => $user1,
                ]);
            }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Email / Password',
            'user' => (object) [],
        ]);
    }


    public function save_fcm_token(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'fcm_token' => $request->fcm_token
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FCM token saved successfully.',
        ]);
    }

   
    public function save_device_token(Request $request)
    {
        $user = Auth::user();
        if ($request->device_token == '') {
            return response()->json([
                'success' => false,
                'message' => "Device token field is required.",
            ]);
        }
        $user->update([
            'device_token' => $request->device_token
        ]);
        return response()->json([
            'success' => true,
            'message' => "Device token saved successfully",
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'isLogin' => false,
        ]);

        if ($user) {

            $user->tokens()->delete();

            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();


            return response()->json([
                'success' => true,
                'message' => "Logout Successfully",
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "user must be login first",
            ]);
        }
    }

    // public function get_roles()
    // {
    //     $roles =  Role::with('permissions')->where('id', '!=', 3)->get();
    //     return response()->json([
    //         'success' => true,
    //         'message' => "get all records successfully",
    //         'roles' => $roles
    //     ]);
    // }

    // public function edit_roles(Request $request)
    // {
    //     $role =  Role::find($request->roleId);
    //     $permissions = $role->permissions()->pluck('id')->toArray();
    //     return response()->json([
    //         'success' => true,
    //         'message' => "get all records successfully",
    //         'role' => $role,
    //         'permissions' => $permissions,
    //     ]);
    // }
    // public function get_permissions(Request $request)
    // {
    //     $all_perm = Permission::all();
    //     return PermissionResource::collection($all_perm);
    // }

    // public function assign_permission_role(Request $request)
    // {
    //     $role = Role::find($request->roleId);
    //     $data = [];
    //     foreach ($request->permissions as $key => $permission) {
    //         $data[] = Permission::find($permission);
    //     }
    //     $role->syncPermissions($data);
    //     return response()->json([
    //         'success' => true,
    //         'message' => "Assign Permissions successfully",
    //     ]);
    // }
    
}
