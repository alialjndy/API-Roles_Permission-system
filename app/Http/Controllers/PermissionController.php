<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use App\Service\Permission\PermissionService;
use Illuminate\Support\Facades\Response;

class PermissionController extends Controller
{
    protected $permissionService;
    public function __construct(PermissionService $permissionService){
        $this->permissionService = $permissionService ;
    }
    /**
     * Summary of index
     * @return mixed
     */
    public function index()
    {
        $allPermissions = Permission::select('id','name','description')->with(['roles'=>function ($query){
            $query->select('roles.id','roles.name');
        }])->get();
        return Response::api('success','all permissions',$allPermissions,200);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Permission\CreatePermissionRequest $request
     * @return mixed
     */
    public function store(CreatePermissionRequest $request)
    {
        $validatedData = $request->validated();
        $permission = $this->permissionService->createPermission($validatedData);
        return Response::api('success','permission created successfully',$permission,201);
    }

    /**
     * Summary of show
     * @param string $permission_id
     * @return mixed
     */
    public function show(string $permission_id)
    {
        $permission = $this->permissionService->showPermissionByID($permission_id);
        return Response::api('success','permission Info',$permission,200);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Permission\UpdatePermissionRequest $request
     * @param string $permission_id
     * @return mixed
     */
    public function update(UpdatePermissionRequest $request, string $permission_id)
    {
        $validatedData = $request->validated();
        $this->permissionService->updatePermission($validatedData , $permission_id);
        return Response::api('success','permission updated successfully',[true],200);
    }

    /**
     * Summary of destroy
     * @param string $permission_id
     * @return mixed
     */
    public function destroy(string $permission_id)
    {
        $this->permissionService->deletePermission($permission_id);
        return Response::api('success','permission deleted successfully',[null],200);
    }
}
