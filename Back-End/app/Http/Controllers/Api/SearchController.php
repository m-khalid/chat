<?php
use Illuminate\Support\Facades\Storage;
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SearchResource;
use App\User;
use DB; 
class SearchController extends Controller
{
    
    use ApiResponseTrait;
    public function search(Request $request)
    {
    $validator = Validator::make($request->all(),[
        'username' => 'required',
       ]);
       if ($validator->fails()) 
       {      
           return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
       }
       $users = User::
        where('username', 'like', "%{$request->username}%")
       ->get();
       
       if(!$users->isEmpty())
       {
           foreach($users as $user){
           $user->img=asset("storage/$user->img");
           $data[]=new SearchResource($user);
           }
           return $this->apiResponse($data);
    
       }     
       return $this->apiResponse(null,404);
    }

    public function img(Request $request)
    {
       /* $validation = $request->validate([
            'file'  =>  'required|file|image|mimes:jpeg,png,gif,jpg|max:2048'
        ]);*/
     //   $path = $request->file('img')->store('public','1.jpeg');
   //  $path=$request()->file('img')->store('public');
    //$path=asset('public/avata1r.jpg');
    $fileName="img.jpeg";
    $path = request()->file('img')->storeAs('public', "img.jpg");
dd($path);
        return $path;

    }
}
