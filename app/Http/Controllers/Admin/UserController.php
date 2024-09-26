<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\AssignRoleRequest;
use App\Http\Requests\user\CreateUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Service\Admin\UserService;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    protected $userService ;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allUsers = User::select('id','name','email')->with(['roles' => function ($query){
            $query->select('roles.id','roles.name','roles.description');
        }])->get();
        return Response::api('success','All Users',$allUsers,200);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\user\CreateUserRequest $request
     * @return mixed
     */
    public function store(CreateUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->userService->createUser($validatedData);
        return Response::api('success','User Created Successfully',$user,201);
    }

    /**
     * Summary of show
     * @param string $id
     * @return mixed
     */
    public function show(string $id)
    {
        $user = $this->userService->showUserByID($id);
        return Response::api('success','User Info ',$user,200);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\user\UpdateUserRequest $request
     * @param string $id
     * @return mixed
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $valdiatedData = $request->validated();
        $this->userService->updateUser($valdiatedData , $id);
        return Response::api('success','user updated successfully',[true],200);
    }

    /**
     * Summary of destroy
     * @param string $id
     * @return mixed
     */
    public function destroy(string $id)
    {
        $this->userService->delete($id);
        return Response::api('success','user deleted successfully',[],200);
    }
    /**
     * we define this method to Assign Role to user
     * @param \App\Http\Requests\user\AssignRoleRequest $request
     * @param string $id
     * @return mixed
     */
    public function assignRoleToUser(AssignRoleRequest $request , string $user_id){
        $validatedData = $request->validated();

        $role = Role::findOrFail($validatedData['role_id']);

        $this->userService->assignRoleToUser($validatedData , $user_id);
        return Response::api('success','Role Assigned successfully',['role_Name'=>$role->name],200);
    }
}
