<?php

namespace App\Http\Middleware;

use App\Tars\cservant\BB\UserService\User\classes\UserInfo;
use App\Tars\cservant\BB\UserService\User\UserServant;
use App\Tars\impl\TarsHelper;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Http\Response;

class Authenticate
{
//    /**
//     * The authentication guard factory instance.
//     *
//     * @var \Illuminate\Contracts\Auth\Factory
//     */
    protected $app;
    protected $userServant;
//
//    /**
//     * Create a new middleware instance.
//     *
//     * @param  \Illuminate\Contracts\Auth\Factory  $auth
//     * @return void
//     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->userServant = TarsHelper::servantFactory(UserServant::class);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param null $scope guest是只允许游客登录，member是只允许会员登录，留空是都允许，当然会自动设置会员的哈哈
     * @return mixed
     */
    public function handle($request, Closure $next,$scope = null)
    {
        //检测会员是否已登录
        $token = $request->token = $request->header('X-API-Key') ?? $request->input('X-API-Key');

        $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED;

        try {
            if ($token) {
                $error = '';
                $user = new UserInfo();
                $this->userServant->getUserInfoByToken($token, $request->getPathInfo(), $user, $error);

                if ($user->uuid) {
                    if ($scope === "guest"){
                        return \response("错误，用户已登录！",Response::HTTP_BAD_REQUEST);
                    }
                    $request->setUserResolver(
                        function () use ($user) {
                            return $user;
                        }
                    );
                    return $next($request);
                }
                $statusCode = Response::HTTP_FORBIDDEN;
            }
        } catch (\Exception $e) {
            $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR;
        }
        $request->setUserResolver(function (){
            return null;
        });

        //检测是否允许游客访问,还是只限会员登录
        if ($scope == "member") {
            return response(\Symfony\Component\HttpFoundation\Response::$statusTexts[$statusCode], $statusCode);
        }

        return $next($request);
    }

}
