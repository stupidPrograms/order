<?php

namespace App\Http\Middleware;

use App\Api\Helpers\Api\ApiResponse;
use App\Tars\cservant\BB\OperationCenter\Operation\OperationServant;
use Closure;
use Tars\client\CommunicatorConfig;
use App\Tars\impl\TarsHelper;

//总管理后台中间件
class AdminAccessMiddleware
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        var_dump('aaasssppp');
        $token = $request->header("x-api-key");
        if ($token) {
            /** @var OperationServant $s */
            $msg="";
            try {
                $s = TarsHelper::servantFactory(OperationServant::class);
                $params = $request->all();
                $params['ip']=$request->getClientIp();
                $request_json = json_encode($params, true);
                $valid = $s->CheckAdminPermission($token, $request->path(), $request->method(),  $request_json, $msg);
                if ($valid) {
                    return $next($request);
                }
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }
        return response()->json(["error"=>"Forbidden"])->setStatusCode(403);
    }
}
