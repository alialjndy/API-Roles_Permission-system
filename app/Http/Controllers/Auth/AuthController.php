<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Service\Auth\AuthService;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller implements \Illuminate\Routing\Controllers\HasMiddleware
{
    // In order to secure the controls except (register , login)
    public static function middleware() {
        return [
            new Middleware(middleware:'auth:api',except:['login','register']),
        ];
    }
    protected $authService;
    public function __construct(AuthService $authService){
        $this->middleware();
        $this->authService = $authService ;
    }
    /**
     * Summary of register
     * @param \App\Http\Requests\Auth\AuthRequest $request
     * @return mixed
     */
    public function register(AuthRequest $request){
        $validatedData = $request->validated();
        $user = $this->authService->createUser($validatedData);
        return Response::api('success','user created successfully',$user , 201);
    }
    /**
     * Summary of login
     * @param \App\Http\Requests\Auth\LoginRequest $loginRequest
     * @return mixed
     */
    public function login(LoginRequest $loginRequest){
        $validatedData = $loginRequest->validated();
        $token = $this->authService->login($validatedData);
        return Response::api('success','user logged in successfully',$token , 200);
    }
    /**
     * Summary of me
     * @return mixed
     */
    public function me(){
        $user =  $this->authService->me();
        return Response::api('success','My Info',[$user->name, $user->email] , 200);
    }
    /**
     * Summary of logout
     * @return mixed
     */
    public function logout()
    {
        $this->authService->logout();
        return Response::api('success','user logged out successfully',[],200);
    }
}
