<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// Toma cosas
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    // User
    public function user(Request $request)
   {
       $user = User::where('email', $request->user()->email)->first();
      
       return response()->json([
           "success" => true,
           "user"    => $request->user(),
           "roles"   => [$user->role->name],
       ]);
   }
   // El login
   public function login(Request $request)
   {
       $credentials = $request->validate([
           'email'     => 'required|email',
           'password'  => 'required',
       ]);
       if (Auth::attempt($credentials)) {
           // Get user
           $user = User::where([
               ["email", "=", $credentials["email"]]
           ])->firstOrFail();
           // Revoke all old tokens
           $user->tokens()->delete();
           // Generate new token
           $token = $user->createToken("authToken")->plainTextToken;
           // Token response
           return response()->json([
               "success"   => true,
               "authToken" => $token,
               "tokenType" => "Bearer"
           ], 200);
       } else {
           return response()->json([
               "success" => false,
               "message" => "Invalid login credentials"
           ], 401);
       }
   }

   // Logout
   public function logout(Request $request)
    {
        // Revoke the current token
        $request->user()->currentAccessToken()->delete();
        if ($request) { // Funka el logout
            return response()->json([
                "success" => true,
                "message" => "Token revoked"
            ], 200);
        }   else {      // NO FUnka el logout
            return response()->json([
                "success" => false,
                "message" => "Invalid login credentials"
            ], 401);
        }

    }


   // Register
   public function register(Request $request) {

    $request->validate([
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', Rules\Password::defaults()],
    ]);
  
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        // 'role_id'  => Role::ADMIN
    ]);
  
    $token = $user->createToken('auth_token')->plainTextToken;

        // Token response
        return response()->json([   //Register FunkA
            "success"   => true,
            "authToken" => $token,
            "tokenType" => "Bearer"
        ], 200);
  }

}
