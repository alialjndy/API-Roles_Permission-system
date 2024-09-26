<?php
namespace App\Service\Role;

use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Log;

class RoleService{
    /**
     * Summary of createRole
     * @param array $data
     * @throws \Exception
     * @return
     */
    public function createRole(array $data){
        try{
            $role = Role::create($data);
            return $role;
        }catch(Exception $e){
            Log::error('Error When Create role '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
    /**
     * Summary of showRoleByID
     * @param string $id
     * @throws \Exception
     * @return Role|\Illuminate\Database\Eloquent\Collection
     */
    public function showRoleByID(string $id){
        try{
            $role = Role::select('id','name','description')->with(['permissions'=>function($query){
                $query->select('permissions.id','permissions.name','permissions.description');
            }])->findOrFail($id);
        return $role;
        }catch(Exception $e){
            Log::error('Error When show Role '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
    /**
     * Summary of updateRole
     * @param array $data
     * @param string $id
     * @throws \Exception
     * @return void
     */
    public function updateRole(array $data , string $id){
        try{
            $role = Role::findOrFail($id);
            $role->update($data);
        }catch(Exception $e){
            Log::error('Error When Update Role '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
    /**
     * Summary of deleteRole
     * @param string $id
     * @throws \Exception
     * @return void
     */
    public function deleteRole(string $id){
        try{
            $role = Role::findOrFail($id);
            $role->delete();
        }catch(Exception $e){
            Log::error('Error When delete Role '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
    /**
     * Summary of AssignPermissionsToRole
     * @param array $data
     * @param string $role_id
     * @throws \Exception
     * @return void
     */
    public function AssignPermissionsToRole(array $data,string $role_id){
        try{
            $role = Role::findOrFail($role_id);
            $role->permissions()->syncWithoutDetaching($data['permission_id']);
        }catch(Exception $e){
            Log::error('Error When Assign Permissions To Role '.$e->getMessage());
            throw new Exception('There is an error in server '.$e->getMessage());
        }
    }
}
