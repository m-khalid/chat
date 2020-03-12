<?php
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\User;
class ImgController extends Controller
{
    use ApiResponseTrait;
    
   public function setimg(Request $request)
   {

    $validator = Validator::make($request->all(),[
       'img'  =>  'required|file|image|mimes:jpeg,png,gif,jpg|max:2048',
        'id' => 'required|integer',
    ]);
    if ($validator->fails()) 
    {      
        return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
    }
  
    $user_data=User::find($request->id);
    if($user_data)
    {
         request()->file('img')->storeAs('public', "$user_data->id.jpg");
        DB::table('users')->where('id',$request->id)->update(['img'=>"$user_data->id.jpg"]);
        $user_data=User::find($request->id);
        $user_data->img= asset("storage/$user_data->img");
        $data=new UserResource($user_data);
        return $this->apiResponse($data);

    }

   }
}
