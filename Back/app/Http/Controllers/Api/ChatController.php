<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use DB;
use App\Chat;

class ChatController extends Controller
{
    use ApiResponseTrait;
    public function send_msg(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'to_id' => 'required|integer',
            'message' => 'required|min:1',
           ]);  
           $token=$request->header('token');
           $user=User::where('token',$token)->first();
           $friend=User::where('id',$request->to_id)->first();
           if ($validator->fails()||empty($token)||empty($user)||empty($friend)) 
           {
               return "nnnnnnnnno";
            return $this->apiResponse(null,404);    
           }
           $chat = new Chat();
           $chat->sender=$user->id;
           $chat->reciever=$request->to_id;
           $chat->message=$request->message;
           if($chat->save())
           {
            return $this->apiResponse(null);
           }
           return $this->apiResponse(null,404);
    }
}
