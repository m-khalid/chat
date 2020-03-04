<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
class FriendsController extends Controller
{
    use ApiResponseTrait;

    public function request(Request $request)
    {
        $validator = Validator::make($request->all(),[
            
            'id'=>'required|integer',
            'username' => 'required|integer',
           ]);
           if ($validator->fails()) 
           {      
               return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
           }
            $user2_id=User::where('username',$request->username)->first();
            if($user2_id)
            {
                DB::table('friends')->insert(
                    ['user1_id' => $request->id, 'user2_id' => $user2_id->id ,'request'=>true,'add'=>false,'block'=>false]
                );
              return $this->apiResponse();
            }
            return $this->apiResponse(null,404);
    }

    public function block(Request $request)
    {
        
    }
}
