<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Addrequest;
class RequestController extends Controller
{
    use ApiResponseTrait;
    public function request(Request $request)
    {
        $validator = Validator::make($request->all(),[
            
            'from_id'=>'required|integer',
            'to_id' => 'required|integer',
           ]);
           if ($validator->fails()) 
           {      
               return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
           }
            $NewRequest = new Addrequest();
            $NewRequest->to_user=$request->to_id;
            $NewRequest->from_user=$request->from_id;
            if($NewRequest->save())
            {
                return $this->apiResponse();
            }
            return $this->apiResponse(null,404);
    }
}
