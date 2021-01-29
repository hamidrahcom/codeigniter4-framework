<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Binds\User as UserBind;
use App\Services\UserService as UserService;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('cookie');
        /**
         * Get Token
         */
        $token = get_cookie(UserBind::$token_key);
        if(is_null($token))
            return redirect()->to('/auth/signin');

        /**
         * Get User By Token
         */
        $user = UserService::getUserByToken($token);
        if(!$user)
            return redirect()->to('/auth/signin');

        /**
         * Check Token Expiration
         */
        if($user->tokex <= time() || in_array($user->role,['user','fired'])){
            /**
             * if token is expired, then remove token and cookies
             */
            UserService::setToken($user->id,[
                'token_string' => null,
                'token_expire' => null
            ]);
            $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
            setcookie(UserBind::$token_key,'',-1,'/',$domain,false);
            return redirect()->to('/auth/signin');
        }

        /**
         * Bind Online User
         */
        UserBind::set($user);
        return true;
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
