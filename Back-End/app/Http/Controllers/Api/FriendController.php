<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Friend;
use App\Addrequest;
class FriendController extends Controller
{
    use ApiResponseTrait;

    public function added(Request $request)
    {
    $validator = Validator::make($request->all(),[
            
        'from_id'=>'required|integer',
        'to_id' => 'required|integer',
       ]);
       if ($validator->fails()) 
       {      
           return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
       }
        $NewRequest = new Friend();
        $NewRequest->user_1=$request->to_id;
        $NewRequest->user_2=$request->from_id;
        if($NewRequest->save())
        {
            Addrequest::where([
                ['from_user' , $request->from_id],
                ['to_user' , $request->to_id],
            ])->delete();
            return $this->apiResponse();
        }
        return $this->apiResponse(null,404);
    }
}
