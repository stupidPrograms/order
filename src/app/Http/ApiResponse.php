<?php


namespace App\Http\Controllers;


use Illuminate\Http\Response;

trait ApiResponse
{
    protected function success($data = null) {
        $code = Response::HTTP_OK;
        return $this->response(null,null,$data);
    }

    protected function badRequest($msg = null) {
        $code = Response::HTTP_BAD_REQUEST;
        return $this->response($code,$msg,null);
    }

    protected function failed($msg = null) {
        $code = Response::HTTP_BAD_REQUEST;
        return $this->response($code,$msg,null);
    }

    protected function internalError($msg = null) {
        $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        return $this->response($code,$msg,null);
    }

    protected function response($code = null, $msg = null, $data = null) {
        $code = $code ?? Response::HTTP_OK;
        $msg = $msg ?? Response::$statusTexts[$code];
        $ret = [
            'code' => $code,
            'message' => $msg,
            'data' => $data,
        ];//return $ret;
        return response()->json($ret)->setStatusCode($code);
    }

}
