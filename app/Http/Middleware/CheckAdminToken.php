<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
                //throw an exception

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
              //  return response() -> json(['success' => false, 'msg' => 'INVALID _TOKEN']);
              return $this->returnError('E3001','INVALID _TOKEN');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
             // return response() -> json(['success' =>false, 'msg'=>'EXPIRED_TOKEN']);
             return $this->returnError('E3001','EXPIRED_TOKEN');
            } else{
              //  return response() -> json(['success' => false, 'msg' => 'Error']);
              return $this->returnError('E3001','TOKEN_NOT_FOUND');
            }
        } catch (Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
              //  return response() -> json(['success' => false, 'msg' => 'INVALID _TOKEN']);
              return $this->returnError('E3001','INVALID _TOKEN');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
             // return response() -> json(['success' =>false, 'msg'=>'EXPIRED_TOKEN']);
             return $this->returnError('E3001','EXPIRED_TOKEN');
            } else{
              //  return response() -> json(['success' => false, 'msg' => 'Error']);
              return $this->returnError('E3001','TOKEN_NOT_FOUND');
            }
        }
        if (!$user) {
            //return response() -> json(['success' => false, 'msg' => 'unauthenticated']);
            return $this->returnError('E3001','unauthenticated');
        }
        return $next($request);
    }
}
