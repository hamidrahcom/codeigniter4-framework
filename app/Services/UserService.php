<?php namespace App\Services;

use App\Repositories\UserRepository as UserRepository;
use App\Binds\Errors as Errors;

class UserService
{
    public static function getUsersPagination(){
        /**
         ** Call Repository
         */
        return UserRepository::paginate();
    }
    public static function getUser($id){
        /**
        ** Call Repository
        */
        return UserRepository::get($id);
    }
    public static function getUserByEmail($email){
        /**
         ** Call Repository
         */
        return UserRepository::getByEmail($email);
    }
    public static function getUserByToken($token){
        /**
         ** Call Repository
         */
        return UserRepository::getByToken($token);
    }
    public static function createUser($data){
        /**
         ** Validate Data
         */
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => ['label' => 'نام', 'rules' => 'required'],
            'family' => ['label' => 'نام خانوادگی', 'rules' => 'required'],
            'email' => ['label' => 'ایمیل', 'rules' => 'required|valid_email'],
            'password' => ['label' => 'پسورد', 'rules' => 'required|min_length[6]'],
            'role' => ['label' => 'نقش', 'rules' => 'required|in_list[user,admin,manager,fired]']
        ],
        [
            'email' => [
                'valid_email' => 'لطفا یک ایمیل معتبر وارد نمایید'
            ]
        ]);
        if(!$validation->run($data)){
            Errors::set($validation->getErrors());
            throw new \Exception('لطفا داده های ورودی را بررسی کنید');
        }

        /**
         * Check
         */
        if(UserRepository::getByEmail($data['email'])){
            throw new \Exception('ایمیل وارد شده تکراری می باشد');
        }

        /**
         ** Call Repository
         */
        return UserRepository::create($data);
    }
    public static function updateUser($id,$data){
        /**
         ** Validate Data
         */
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => ['label' => 'نام', 'rules' => 'required'],
            'family' => ['label' => 'نام خانوادگی', 'rules' => 'required'],
            'role' => ['label' => 'نقش', 'rules' => 'required|in_list[user,admin,manager,fired]']
        ]);
        if(!$validation->run($data)){
            Errors::set($validation->getErrors());
            throw new \Exception('لطفا داده های ورودی را بررسی کنید');
        }

        /**
         ** Call Repository
         */
        return UserRepository::update($id,$data);
    }
    public static function setToken($id,$data){
        /**
         ** Call Repository
         */
        return UserRepository::setToken($id,$data);
    }
    public static function setPassword($id,$data){

        /**
         ** Validate Data
         */
        $validation = \Config\Services::validation();
        $validation->setRules([
            'password' => ['label' => 'پسورد', 'rules' => 'required|min_length[6]'],
            'password_confirm' => ['label' => 'پسورد', 'rules' => 'required|min_length[6]'],
        ]);
        if(!$validation->run($data)){
            Errors::set($validation->getErrors());
            throw new \Exception('لطفا داده های ورودی را بررسی کنید');
        }

        /**
         ** Check Password with confirm
         */
        if($data['password'] != $data['password_confirm'])
            throw new \Exception('گذرواژه و تایید آن با یکدیگر برابر نیستند لطفا توجه فرمایید');

        /**
         ** Check User Exist
         */
        $user = self::getUser($id);
        if(!$user)
            throw new \Exception('کاربر یافت نشد');

        /**
         ** Call Repository
         */
        return UserRepository::setPassword($id,$data);
    }
    public static function deleteUser($id){
        /**
         ** Call Repository
         */
        return UserRepository::delete($id);
    }
}
