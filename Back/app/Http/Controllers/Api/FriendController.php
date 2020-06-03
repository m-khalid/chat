<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\ListAcceptedResource;
use Illuminate\Http\Request;
use App\Friend;
use App\Addrequest;
use DB;
use App\User;
use Carbon\Carbon;

class FriendController extends Controller
{
    public function __construct()
        {
            $request =  Request();
            $user_data=User::where('token',$request->token)->first();
            return $user_data;
        }
    use ApiResponseTrait;
            ////// accept add ////////////
    public function added(Request $request)
    {
    $validator = Validator::make($request->all(),[  
        'to_id' => 'required|integer',
        'token'=>'required',
       ]);
       $user=$this->__construct();
     
       if ($validator->fails()||empty($user)) 
       {      
        return $this->apiResponse(null,404); 
       }
       $token=$user->token;
       if(!empty(Addrequest::where([
           ['sender',$request->to_id],
           ['reciever',$user->id]
       ])->first()))
       {
        $NewRequest = new Friend();
        $NewRequest->user_id=$user->id;
        $NewRequest->friend_id=$request->to_id;
        $NewRequest->status=1;
        if($NewRequest->save())
        {
            Addrequest::where([
                ['sender',$request->to_id],
                ['reciever',$user->id],
            ])->delete();
            return $this->apiResponse();
        }
    }
        return $this->apiResponse(null,404);
    }

///////////////////////////////////////////////////////////////
    public function list_accepted (Request $request)
    {
        $validator = Validator::make($request->all(),[
            'token'=>'required',
           ]);
           if ($validator->fails()) 
           {      
            return $this->apiResponse(null,'404',$validator->messages()->first());    
           }

           $user=$this->__construct();
           if($user){
            $token=$user->token;
                 $data= DB::table('users')
                ->join('friends', 'users.id', '=', 'friends.user_id')->where('friend_id',$user->id)
                ->select('friends.user_id','users.img','friends.created_at','users.username')->get();
                 Friend::where('friend_id',$user->id)->update(['status'=> 0]);
                $users=null;
                foreach ($data as $user)
                {
                    $user->img=asset("storage/$user->img");                   
                    $users[]=new ListAcceptedResource($user);
                } 
                if(!empty($users)){
                 return $this->apiResponse($users);
                }
            }
            return $this->apiResponse(null,404);   

    }

    ////// count of accepted request//////////
    public function count_accept(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'token'=>'required',
           ]);
           if ($validator->fails()) 
           {      
            return $this->apiResponse(null,'404',$validator->messages()->first());    
           }
        $user=$this->__construct();
        if($user){
            $token=$user->token;
         $data['count']= Friend::where([['friend_id', $user->id],['status',1]])->count('status');
        return   $this->apiResponse($data);
        }
        return $this->apiResponse(null,404);
    }

    ///////////////////////////list friends/////////////////////
    public function list_friends(Request $request)
    {
       
        $validator = Validator::make($request->all(),[
            'token'=>'required',
           ]);
           if ($validator->fails()) 
           {      
            return $this->apiResponse(null,'404',$validator->messages()->first());    
           }
           $user=$this->__construct();
           if (!$user)
           {
           return $this->apiResponse(null,404);
    
           }
           $token=$user->token;
        $data=Friend::where('user_id',$user->id)
        ->orwhere('friend_id',$user->id)
        ->get();
        if(count($data)>0){
        foreach($data as $user_data)
        {
            if($user_data->user_id==$user->id)
            {
                unset($user_data->user_id);
                $user_data->user_id=$user_data->friend_id;
            }
            elseif($user_data->friend_id==$user->id)
            {
                unset($user_data->friend_id);
              //  $user_data->user_id=$user_data->user_id;

            }
        }
        foreach($data as $users){
            $friend=User::where('id',$users->user_id)->first();
            $friend->user_id=$friend->id;
           $friend->img=asset("storage/$friend->img");
            $friends[]=new ListAcceptedResource($friend);
        }
       return $this->apiResponse($friends);
        }
        return $this->apiResponse(null,404);

    }

}
