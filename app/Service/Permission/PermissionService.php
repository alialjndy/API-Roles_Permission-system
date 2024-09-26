<?php
namespace App\Service\Permission;

use App\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Log;

class PermissionService{
    /**
     * Summary of createPermission
     * @param array $data
     * @throws \Exception
     * @return
     */
    public function createPermission(array $data){
        try{
            $role = Permission::create($data);
            return $role;
        }catch(Exception $e){
            Log::error('Error When Create permission '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
    /**
     * Summary of showPermissionByID
     * @param string $id
     * @throws \Exception
     * @return Permission|\Illuminate\Database\Eloquent\Collection
     */
    public function showPermissionByID(string $id){
        try{
            $permission = Permission::select('id','name','description')->with(['roles'=>function($query){
                $query->select('roles.id','roles.name','roles.description');
            }])->findOrFail($id);
        return $permission;
        }catch(Exception $e){
            Log::error('Error When show permission '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
    /**
     * Summary of updatePermission
     * @param array $data
     * @param string $id
     * @throws \Exception
     * @return void
     */
    public function updatePermission(array $data , string $id){
        try{
            $permission = Permission::findOrFail($id);
            $permission->update($data);
        }catch(Exception $e){
            Log::error('Error When Update permission '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
    /**
     * Summary of deletePermission
     * @param string $id
     * @throws \Exception
     * @return void
     */
    public function deletePermission(string $id){
        try{
            $permission = Permission::findOrFail($id);
            $permission->delete();
        }catch(Exception $e){
            Log::error('Error When delete permission '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
}
