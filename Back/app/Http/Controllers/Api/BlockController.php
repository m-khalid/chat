<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ListBlockRecource;
use App\Block;
use App\User;
use DB;

class BlockController extends Controller
{
    public function __construct()
        {
            $request =  Request();
            $user_data=User::where('token',$request->token)->first();
            return $user_data;
        }
    use ApiResponseTrait;

    public function block(Request $request)
    {
        $validator = Validator::make($request->all(),[
             'to_id' => 'required|integer',
              'token'=>'required',
         ]);
         $user=$this->__construct();
       if (!$user)
       {
       return $this->apiResponse(null,404);

       }
         $friend=User::where('id',$request->to_id)->first();
         if ($validator->fails()||empty($user)||empty($friend)) 
         {      
            return $this->apiResponse(null,404);      
         }
         if(Block::insert([
            ['user_id' => $user->id,
            'friend_id' => $request->to_id]
        ]))
        {
            DB::table('friends')->where([['user_id', '=', $user->id],['friend_id','=',$request->to_id]])
            ->orwhere([['friend_id', '=', $user->id],['user_id','=',$request->to_id]])->delete(); 

            DB::table('addrequests')->where([['sender', '=', $user->id],['reciever','=',$request->to_id]])
            ->orwhere([['reciever', '=', $user->id],['sender','=',$request->to_id]])->delete();     
            return $this->apiResponse(null);
        }
        return $this->apiResponse(null,404);
    }

    ///////////////////// cancel block////////////////////
    public function cancel(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'to_id' => 'required|integer',
            'token'=>'required',
        ]);
        $user=$this->__construct();
        if (!$user)
        {
        return $this->apiResponse(null,404);
        }
        $token=$user->token;
        $friend=User::where('id',$request->to_id)->first();
        if ($validator->fails()||empty($token)||empty($user)||empty($friend)) 
        {      
           return $this->apiResponse(null,404);      
        }
         if(Block::where([
             ['user_id' , $user->id],
             ['friend_id' , $request->to_id],
         ])->delete())
        {
            return $this->apiResponse(null);
        }
        return $this->apiResponse(null,404);

    }
////////////////////////// list block /////////////////////////////////li

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
       if (!$user)
       {
       return $this->apiResponse(null,404);
       }

      $token=$user->token;
        
         $data= DB::table('users')
            ->join('blocks', 'users.id', '=', 'blocks.friend_id')->where('user_id',$user->id)
            ->select('blocks.friend_id','users.img','users.username')->get();
            $users=null;
            foreach ($data as $user)
            {
                $user->img=asset("storage/$user->img");                   
                $users[]= new ListBlockRecource($user);
            } 
            return $this->apiResponse($users);
    } 

}
