<?php
namespace App\Service\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class UserService{
    /**
     * Summary of createUser
     * @param array $data
     * @throws \Exception
     * @return
     */
    public function createUser(array $data){
        try{
            $user = User::create($data);
            $user->roles()->syncWithoutDetaching($data['roles']);
            return $user;
        }catch(Exception $e){
            Log::error('Error : Error when creating user '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
    /**
     * Summary of showUserByID
     * @param string $id
     * @throws \Exception
     * @return User|\Illuminate\Database\Eloquent\Collection
     */
    public function showUserByID(string $id){
        try{
            $user = User::select('users.id','users.name','users.email')->with(['roles' => function ($query){
                $query->select('roles.id','roles.name');
            }])->findOrFail($id);
            return $user;
        }catch(Exception $e){
            Log::error('Error : Error when show user '.$e->getMessage());
            throw new Exception('There is an error in server ' .$e->getMessage());
        }
    }
    /**
     * Summary of updateUser
     * @param array $data
     * @param string $id
     * @throws \Exception
     * @return void
     */
    public function updateUser(array $data ,string $id){
        try{
            $user = User::findOrFail($id);
            $user->roles()->syncWithoutDetaching($data['roles']);
        }catch(Exception $e){
            Log::error('Error : Error when update user '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
    /**
     * Summary of delete
     * @param string $id
     * @throws \Exception
     * @return void
     */
    public function delete(string $id){
        try{
            $user = User::findOrFail($id);
            $user->delete();
        }catch(Exception $e){
            Log::error('Error : Error when delete user '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
    /**
     * Summary of assignRoleToUser
     * @param array $data
     * @param string $id
     * @throws \Exception
     * @return void
     */
    public function assignRoleToUser(array $data , string $id){
        try{
            $user = User::findOrFail($id);
            $user->roles()->syncWithoutDetaching($data);
        }catch(Exception $e){
            Log::error('Error When Assign Role To user '.$e->getMessage());
            throw new Exception('There is an error in server');
        }
    }
}
