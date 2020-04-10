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
    use ApiResponseTrait;
    ///send request ////
    public function request(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'to_id' => 'required|integer',
           ]);  
           $token=$request->header('token');
           $user=User::where('token',$token)->first();
           if ($validator->fails()||empty($token)) 
           {
            return $this->apiResponse(null,404);    
           }
           if($user&&!empty(User::where('id',$request->to_id)->first())&&$user->id!=$request->to_id){
            $NewRequest = new Addrequest();
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
        $token=$request->header('token');
        $user=User::where('token',$token)->first();
           if (empty($token)) 
           {      
            return $this->apiResponse(null,404);    
           }
           if($user)
           {
         $data['count']= Addrequest::where([['reciever', $user->id],['status',1]])->count('status');
        return   $this->apiResponse($data);
           }
           return $this->apiResponse(null,404);    

    }


    //// list Requets ////////////

    public function list(Request $request)
    {
        $token=$request->header('token');
        $user=User::where('token',$token)->first();
        if (empty($token)) 
        {
         return $this->apiResponse(null,404);    
        }
        if($user){
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
