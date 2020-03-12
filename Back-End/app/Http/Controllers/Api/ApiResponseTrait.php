<?php
namespace App\Http\Controllers\Api;

trait ApiResponseTrait
{
    public function apiResponse($data = null , $code = 200)
    {
        $array = [
            'data' => $data,
            'status'=> $code == 200 ?200 : 404,
            'msg'=> $code ==200 ?"success":"wrong",
        ];
        return response($array , $code);
    }
}