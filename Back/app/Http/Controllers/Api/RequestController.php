<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ListRequetsRecource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Addrequest;
use DB;
use App\User;
class RequestController extends Controller
{
    public function __construct()
        {
            $request =  Request();
            $user_data=User::where('token',$request->token)->first();
            return $user_data;
        }
    use ApiResponseTrait;
    ///send request ////
    public function request(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'to_id' => 'required|integer',
            'token'=>'required',
           ]);  
      
           if ($validator->fails()) 
           {
            return $this->apiResponse(null,'404',$validator->messages()->first());    
   
           }
           $user=$this->__construct();
          
           if($user&&!empty(User::where('id',$request->to_id)->first())&&$user->id!=$request->to_id){
            $NewRequest = new Addrequest();
            $token=$user->token;
            $NewRequest->reciever=$request->to_id;
            $NewRequest->sender=$user->id;
            $NewRequest->status=1;
            if($NewRequest->save())
            {
                return $this->apiResponse();
            }
        }
            return $this->apiResponse(null,404);
    }

    ////////////////////////////////// count of Requests /////////////
    public function count_requet(Request $request)
    {
        $validator = Validator::make($request->all(),[
          
            'token'=>'required',
           ]);
           if ($validator->fails()) 
           {      
            return $this->apiResponse(null,'404',$validator->messages()->first());    
           }
           $user=$this->__construct();
           
           if($user)
           {
               $token=$user->token;
            $data['count']= Addrequest::where([['reciever', $user->id],['status',1]])->count('status');
           return   $this->apiResponse($data);
           }
           return $this->apiResponse(null,404);    

    }


    //// list Requets ////////////

    public function list(Request $request)
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
            ->join('addrequests', 'users.id', '=', 'addrequests.sender')->where('reciever',$user->id)
            ->select('addrequests.sender','users.img','addrequests.created_at','users.username')->get();
             Addrequest::where('reciever',$user->id)->update(['status'=> 0]);
           if($data->count() >0){
            foreach ($data as $user)
                {
                    $user->img=asset("storage/$user->img");                   
                    $users[]= new ListRequetsRecource($user);
                } 
          return $this->apiResponse($users);
            }
        }
            return $this->apiResponse(null,404);   
    }
}
