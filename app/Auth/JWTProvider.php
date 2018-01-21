<?php
/**
 * Created by PhpStorm.
 * User: rafae
 * Date: 14/01/2018
 * Time: 17:46
 */

namespace CodeFlix\Auth;


use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWT;
use Illuminate\Auth\AuthenticationException;

class JWTProvider extends Authorization
{
    private $jwt;

    public function __construct(JWT $jwt){
        $this->jwt = $jwt;
    }

    /**
     * Get the providers authorization method.
     *
     * @return string
     */
    public function getAuthorizationMethod()
    {
        return 'bearer';
    }

    /**
     * Authenticate the request and return the authenticated user instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Dingo\Api\Routing\Route $route
     *
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        try 
        {
            return \Auth::guard('api')->authenticate();
        } catch (AuthenticationException $exception){
            $this->refreshToken();
            return \Auth::guard('api')->user();
        }
    }

    protected function refreshToken(){
        $token = $this->jwt->parseToken()->refresh();
        $this->jwt->setToken($token);
    }
}