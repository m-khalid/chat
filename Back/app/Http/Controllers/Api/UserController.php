<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
class UserController extends Controller
{
    use ApiResponseTrait;

    ///// select user by token  /////
    public function __construct()
    {
        $request =  Request();
        $user_data=User::where('token',$request->token)->first();
        return $user_data;
    }

            ////////////// register////////////////////
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|min:4|max:20|unique:users',
            'email' => 'required|max:80|email|unique:users',
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6',
            'age' => 'required|integer',
            'bio'=>'required|min:5|max:30',
           ]);
           $token=Str::random(30);
           unset($request['password_confirmation']); 
           $password=$request->password;
           $request['password']=md5($request['password']);
           $user = new User;
           $user->username=$request->username;
           $user->email=$request->email;
           $user->password=$request->password;
           $user->age=$request->age;
           $user->bio=$request->bio;
           $user->token=$token;
           if ($validator->fails()) 
            {      
                return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
            }
         
            else if($user->save())
            {  
              $user_data=$this->Account($request->username,$password);
            if($user_data)
            {
            $user_data->img= asset("storage/$user_data->img");
                $data=new UserResource($user_data);
                return $this->apiResponse($data);
            }
        }
             return $this->apiResponse(null,'404');
    }

            //////// login /////////////
    public function get(Request $request)
    {
        $user_data= $this->Account($request->useraccount,$request->password);
        if($user_data)
        {
            $user_data->img= asset("storage/$user_data->img");
            $data=new UserResource($user_data);
            return $this->apiResponse($data);
        }
       return $this->apiResponse(null,'404');
    }

    private function Account($useraccount,$password)
    {
        $data=User::where([
            ['password',md5($password)],
            ['username',$useraccount]
            ])->orWhere([
            ['password',md5($password)],
            ['email',$useraccount]
            ])->first();
            return $data;
    }


    //////////////edit profile /////////////
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'min:4|max:20|unique:users',
            'email' => 'max:80|email|unique:users',
            'age' => 'integer',
            'token'=>'required',
           ]);
            if($request->password)
            {
                 return $this->apiResponse(null,'404');
            }
           if ($validator->fails()) 
            { 
                return $this->apiResponse(null,'404',$validator->messages()->first());
            }
        $user_data=$this->__construct();
        if($user_data){
        DB::table('users')->where('token',$user_data->token)->update($request->all());
        $user_data=$this->__construct();
            $data=new UserResource($user_data);
            return $this->apiResponse($data);
    }
         return $this->apiResponse(null,'404');
    }

    //////////////////change password ////////////////////
    public function changepassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'oldpassword' => 'required|min:6',
            'newpassword' => 'required|min:6',
            'token'=>'required',
           ]); 
         if ($validator->fails()) 
         {      
            return $this->apiResponse(null,'404',$validator->messages()->first());    
         }
         $request['oldpassword']=md5($request['oldpassword']);
         $request['newpassword']=md5($request['newpassword']);
         $user_data=$this->__construct();
         if($user_data){
         $user_password = User::select('password')->where('token',$user_data->token)->first();
         if($user_password->password==$request->oldpassword)
         {
            DB::table('users')->where('token',$user_data->token)->update(['password'=>$request->newpassword]);
                $data=new UserResource($user_data);
                return $this->apiResponse($data);       
         }
        }
         return $this->apiResponse(null,'404');
        
    }

    //view profile/////////////
    public function display(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'token'=>'required',
           ]); 
         if ($validator->fails()) 
         {      
            return $this->apiResponse(null,'404',$validator->messages()->first());    
         }
        $user_data=$this->__construct();
        if($user_data)
            {
                $user_data->img= asset("storage/$user_data->img");
                $data=new UserResource($user_data);
                return $this->apiResponse($data);
            }
         return $this->apiResponse(null,'404');       

    }

    ////set img/////////
    public function setimg(Request $request)
    {
 
     $validator = Validator::make($request->all(),[
        'img'  =>  'required|file|image|mimes:jpeg,png,gif,jpg|max:2048',
        'token'=>'required',
     ]);
     if ($validator->fails()) 
     {      
        return $this->apiResponse(null,'404',$validator->messages()->first());     
     }
     $user=$this->__construct();
     if($user)
     {
          request()->file('img')->storeAs('public', "$user->id.jpg");
         DB::table('users')->where('id',$user->id)->update(['img'=>"$user->id.jpg"]);
         $user_data=User::find($user->id);
         $user_data->img= asset("storage/$user_data->img");
         $data=new UserResource($user_data);
         return $this->apiResponse($data);
     }
     return $this->apiResponse(null,'404');         
    }

}
