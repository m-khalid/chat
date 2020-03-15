<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Block;
use DB;

class BlockController extends Controller
{
    use ApiResponseTrait;

    public function block(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'from_id'  => 'required|integer',
             'to_id' => 'required|integer',
         ]);
         if ($validator->fails()) 
         {      
             return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
         }
         if(Block::insert([
            ['from_user' => $request->from_id,
            'to_user' => $request->to_id]
        ]))
        {
            DB::table('friends')->where([['user_1', '=', $request->from_id],['user_2','=',$request->to_id]])
            ->orwhere([['user_2', '=', $request->from_id],['user_1','=',$request->to_id]])->delete(); 

            DB::table('addrequests')->where([['from_user', '=', $request->from_id],['to_user','=',$request->to_id]])
            ->orwhere([['to_user', '=', $request->from_id],['from_user','=',$request->to_id]])->delete();     
            return $this->apiResponse(null);
        }
        return $this->apiResponse(null,404);
    }

    ///////////////////// cancel block////////////////////
    public function cancel(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'from_id'  => 'required|integer',
             'to_id' => 'required|integer',
         ]);
         if ($validator->fails()) 
         {      
             return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
         }

         if ($validator->fails()) 
         {      
             return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
         }
         if(Block::where([
             ['from_user' , $request->from_id],
             ['to_user' , $request->to_id],
         ])->delete())
        {
            return $this->apiResponse(null);
        }
        return $this->apiResponse(null,404);

    }
//////////////////////////check block /////////////////////////////////

    public function check_block($user_1, $user_2)
    {
    
      $check=Block::where([
            ['from_user' , $user_1],
            ['to_user' , $user_2],
        ])->get();
      
        if($check->isNotEmpty())
        {
            return "true";
        }
        else
        {
            return "false";
        }
    }
}
