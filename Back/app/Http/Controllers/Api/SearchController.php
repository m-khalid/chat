<?php
use Illuminate\Support\Facades\Storage;
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SearchResource;
use App\User;
use App\Block;
use DB; 
class SearchController extends Controller
{
    
    use ApiResponseTrait;
    public function search(Request $request)
    {
    $validator = Validator::make($request->all(),[
        'username' => 'required',
        'id'=>'required',
       ]);
       if ($validator->fails()) 
       {      
           return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
       }

       $users = User::
        where('username', 'like', "%{$request->username}%")->orwhere('email',$request->username)
       ->get();
       
       if(!$users->isEmpty())
       {
        $user_1=$request->id; 
           foreach($users as $user){ 
               $user_2=$user->id;
               if(Block::where([['from_user',$user_1],['to_user',$user_2]])
              ->orwhere([['from_user',$user_2],['to_user',$user_1]])->first()) // check block 
               {
                continue;
               }           
           $user->img=asset("storage/$user->img");
           $data[]=new SearchResource($user);
           }
           return $this->apiResponse($data);

       }     
       return $this->apiResponse(null,404);
    }

   
}
