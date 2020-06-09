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
    public function __construct()
        {
            $request =  Request();
            $user_data=User::where('token',$request->token)->first();
            return $user_data;
        }
    
    use ApiResponseTrait;

    public function search(Request $request)
    {
        
    $validator = Validator::make($request->all(),[
        'username' => 'required',
        'token'=>'required',
       ]);
       if ($validator->fails()) 
       {      
        return $this->apiResponse(null,'404',$validator->messages()->first());    
       }
       $user_data=$this->__construct();
       if (!$user_data)
       {
       return $this->apiResponse(null,404);

       }
       $token=$user_data->token;
       $users = User::
        where('username', 'like', "%{$request->username}%")->orwhere('email',$request->username)
       ->get();

       if(!$users->isEmpty())
       {
        $data=null;
        $user_1=User::where('token',$token)->first();
           foreach($users as $user){ 
               $user_2=$user->id;
               if(Block::where([['user_id',$user_1->id],['friend_id',$user_2]])
              ->orwhere([['user_id',$user_2],['friend_id',$user_1->id]])->first() || $user_1->id==$user_2) // check block 
               {
                continue;
               }           
           $user->img=asset("storage/$user->img");
           $data[]=new SearchResource($user);
           }
           if(!empty($data))
           {
           return $this->apiResponse($data);
           }
       }     
       return $this->apiResponse(null,404);
    }

   
}
