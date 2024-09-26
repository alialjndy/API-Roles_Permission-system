<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\AssignPermissionRequest;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Service\Role\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    protected $roleService ;
    public function __construct(RoleService $roleService){
        $this->roleService = $roleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allRoles = Role::select('id','name','description')->with(['permissions' =>function($query){
            $query->select('permissions.id','permissions.name','permissions.description');
        }])->get();
        return Response::api('success','all roles',$allRoles , 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request)
    {
        $validatedData = $request->validated();
        $role = $this->roleService->createRole($validatedData);
        return Response::api('success','role created successfully',$role , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = $this->roleService->showRoleByID($id);
        return Response::api('success','role Info',$role , 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $this->roleService->updateRole($validatedData , $id);
        return Response::api('success','role updated successfully',[true], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->roleService->deleteRole($id);
        return Response::api('success','role deleted successfully',[null], 200);
    }
    /**
     * We define this method to In associate permissions with roles
     * Summary of AssignPermissionToRole
     * @param \App\Http\Requests\Role\AssignPermissionRequest $request
     * @param string $role_id
     * @return mixed
     */
    public function AssignPermissionToRole(AssignPermissionRequest $request,string $role_id){
        $validatedData = $request->validated();
        $this->roleService->AssignPermissionsToRole($validatedData , $role_id);
        return Response::api('success','Permissions assigned successfully',[true], 200);
    }
}
