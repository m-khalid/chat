<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ListRequetsRecource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Addrequest;
use DB;
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
            $NewRequest->status=1;
            if($NewRequest->save())
            {
                return $this->apiResponse();
            }
            return $this->apiResponse(null,404);
    }
    ////////////////////////////////// count of Requests /////////////
    public function count_requet(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|integer',
           ]);
           if ($validator->fails()) 
           {      
               return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
           }
         $data['count']= Addrequest::where([['to_user', $request->id],['status',1]])->count('status');
        return   $this->apiResponse($data);
    }
    //// list Requets ////////////

    public function list(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>'required|integer',
           ]);
           if ($validator->fails()) 
           {      
               return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
           }
            $data= DB::table('users')
            ->join('addrequests', 'users.id', '=', 'addrequests.from_user')->where('to_user',$request->id)
            ->select('addrequests.from_user','users.img','addrequests.created_at','users.username')->get();
             Addrequest::where('to_user',$request->id)->update(['status'=> 0]);
           $users=null;
            foreach ($data as $user)
                {
                    $user->img=asset("storage/$user->img");                   
                    $users[]= new ListRequetsRecource($user);
                } 
          return $this->apiResponse($users);
    }
}
