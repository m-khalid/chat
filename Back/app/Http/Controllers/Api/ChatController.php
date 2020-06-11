<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ListMessagesRecource;
use Illuminate\Support\Facades\Validator;
use App\User;
use DB;
use App\Chat;

class ChatController extends Controller
{
    public function __construct()
    {
        $request =  Request();
        $user_data=User::where('token',$request->token)->first();
        return $user_data;
    }

    use ApiResponseTrait;
    public function send_msg(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'to_id' => 'required|integer',
            'message' => 'required|min:1',
            'token'=>'required',
           ]);
           $user=$this->__construct();

           $friend=User::where('id',$request->to_id)->first();
           if ($validator->fails()||empty($user)||empty($friend))
           {
            return $this->apiResponse(null,404);
           }
           $token=$user->token;
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
        public function messages(Request $request)
        {
            $validator = Validator::make($request->all(),[
                'to_id' => 'required|integer',
                'token'=>'required',
               ]);
               $user=$this->__construct();
               $friend=User::where('id',$request->to_id)->first();
               if ($validator->fails()||empty($user)||empty($friend))
               {
                return $this->apiResponse(null,404);
               }
               $token=$user->token;
               $messages=Chat::where([
                   ['sender',$user->id],['reciever',$friend->id]
                   ])->orwhere([['reciever',$user->id],['sender',$friend->id]])->orderBy('created_at','desc')->get();

                   foreach($messages as $message)
                   {

                        if($message->sender==$user->id)
                            {
                                $message->me=$message->message;
                            }
                            else
                            {
                                $message->friend=$message->message;
                            }
                            $data[] = new ListMessagesRecource($message);
                   }
                   if(!empty($data)){
                     return $this->apiResponse($data);
                   }
                return $this->apiResponse(null,404);

        }

}
