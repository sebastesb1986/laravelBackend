<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh', 'userProfile']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request){

    	$validator = $request->validated();

        /*if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }*/

        if (! $token = auth()->attempt($validator)) {
            return response()->json(['error' => 'Usuario NO registrado o Información incorrecta'], 401);
        }


        return $this->respondWithToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request) {
        
        $validator = $request->validated();

        /*if($validator->fails()){
            // return response()->json($validator->errors()->toJson(), 400);
            return response()->json($validator->errors(), 400);
        }*/

        $user = User::create(array_merge(
                    $validator,
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
        
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {

        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {

        $logged = auth()->user();
 
        if($logged){

            $data = [  
                        "id" => $logged->id, 
                        "username" => $logged->name,
                        "email" => $logged->email, 
                    ];

            return response()->json(["logged_in" => $data]);

        }
        else{

            return response()->json(["message" => "Debes iniciar sesión."]);

        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
