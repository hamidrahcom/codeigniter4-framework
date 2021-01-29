<?php namespace App\Repositories;

use App\Binds\Errors as Errors;
use App\Models\User as User;
use App\Entities\User as UserEntity;

class UserRepository
{
    /**
     * Get count All
     * @return mixed
     */
    public static function countAll(){
        $userModel = new User();
        return $userModel->countAllResults();
    }
    /**
     * Get All Paginate States Rows
     * @return mixed
     */
    public static function paginate($filters = [],$order = 'id',$sort = 'desc'){
        $userModel = new User();
        return [
            'list' => $userModel->orderBy($order, $sort)->paginate(option('perpage')),
            'pager' => $userModel->pager,
        ];
    }
    /**
     * Get All User Rows
     * @return mixed
     */
    public static function all(){
        $userModel = new User();
        return $userModel->findAll();
    }
    /**
     * Get User
     * @return mixed
     */
    public static function get($id){
        $userModel = new User();
        return $userModel->find($id);
    }
    /**
     * Get User By Email
     * @return mixed
     */
    public static function getByEmail($email){
        $userModel = new User();
        return $userModel->where('email',$email)->first();
    }
    /**
     * Get User By Token
     * @return mixed
     */
    public static function getByToken($token){
        $userModel = new User();
        return $userModel->where('token_string',$token)->first();
    }
    /**
     * Create User
     * @param array $data
     * @return mixed
     */
    public static function create($data = [])
    {
        $userModel = new User();
        $user = new UserEntity();

        $user->name = $data['name'];
        $user->family = @$data['family'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->role = $data['role'];

        $create = $userModel->save($user);
        if (!$create) {
            Errors::set($userModel->errors());
            throw new \Exception('خطایی در زمان ایجاد به وجود آمده است');
        }
        return $userModel->getInsertID();
    }
    /**
     * Update User
     * @param array $data
     * @return mixed
     */
    public static function update($id,$data = []){
        $userModel = new User();

        $user = $userModel->find($id);

        if(!$user){
            throw new \Exception('کاربر مورد نظر یافت نشد');
        }

        if($user->name != $data['name'])
            $user->name = $data['name'];

        if($user->family != $data['family'])
            $user->family = $data['family'];

        if($user->role != $data['role'])
            $user->role = $data['role'];


        $update = $userModel->save($user);
        if(!$update){
            Errors::set($userModel->errors());
            throw new \Exception('خطایی در زمان ویرایش به وجود آمده است');
        }

        return true;
    }
    /**
     * Update User Token
     * @param array $data
     * @return mixed
     */
    public static function setToken($id,$data = []){
        $userModel = new User();

        $user = $userModel->find($id);

        if(!$user){
            return false;
        }

        $user->token = $data['token_string'];
        $user->tokex = $data['tokex_expire'];

        return $userModel->save($user);
    }
    /**
     * Update User Token
     * @param array $data
     * @return mixed
     */
    public static function setPassword($id,$data = []){
        $userModel = new User();

        $user = $userModel->find($id);

        if(!$user){
            throw new \Exception('کاربر مورد نظر یافت نشد');
        }

        $user->password = $data['password'];

        $update = $userModel->save($user);
        if(!$update){
            Errors::set($userModel->errors());
            throw new \Exception('خطایی در زمان ویرایش به وجود آمده است');
        }

        return true;
    }
    /**
     * Delte User
     * @param integer $id
     * @return boolean
     */
    public static function delete($id){
        $userModel = new User();
        return $userModel->delete($id);
    }
}
