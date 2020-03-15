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
use Carbon\Carbon;

class FriendController extends Controller
{
    use ApiResponseTrait;
// accept add 
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
        $NewRequest->user_1=$request->from_id;
        $NewRequest->user_2=$request->to_id;
        $NewRequest->status=1;
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

    public function list_accepted (Request $request)
    {
        $validator = Validator::make($request->all(),[
            
            'id'=>'required|integer',
           ]);
           if ($validator->fails()) 
           {      
               return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
           }
                 $data= DB::table('users')
                ->join('friends', 'users.id', '=', 'friends.user_2')->where('user_1',$request->id)
                ->select('friends.user_2','users.img','friends.created_at','users.username')->get();
                 Friend::where('user_1',$request->id)->update(['status'=> 0]);
         
                foreach ($data as $user)
                {
                    $user->img=asset("storage/$user->img");                   
                    $datas[]=new ListAcceptedResource($user);
                } 
                 return $this->apiResponse($datas);
    }

    public function count_accept(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'id'=>'required|integer',
           ]);
           if ($validator->fails()) 
           {      
               return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
           }
         $data['count']= Friend::where([['user_1', $request->id],['status',1]])->count('status');
        return   $this->apiResponse($data);
    }


}
