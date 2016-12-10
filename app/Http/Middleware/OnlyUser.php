<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use NvwaCommon\Uic\RemoteUser;
use NvwaCommon\Uic\RemoteUserMiddleware;
use NvwaCommon\Uic\ServerSide;

class OnlyUser extends RemoteUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$remoteUserNames='')
    {
        //如果开启了假用户模式,直接返回了
        if (env("REMOTE_USER_FAKE_MODE")) {
            return $next($request);
        }
        $uicToken = $request->input(ServerSide::$tokenArgumentName);
        if ($uicToken) {
            $request->session()->set(self::$sessionName, $uicToken);
        } else {
            $uicToken = $request->session()->get(self::$sessionName);
        }
        if ($uicToken) {
            try {
                $this->buildRemoteUser($uicToken);
            } catch (\Exception $e) {
                return $this->redirectToServerSide($request);
            }
        }
        if (!RemoteUser::getCurrentUser()) {
            return $this->redirectToServerSide($request);
        }
        $user = RemoteUser::getCurrentUser();
        if ($user->email != 'xurenlu@glz8.com' ) {
            return new Response("forbidden");
        }
        return $next($request);
    }
}
