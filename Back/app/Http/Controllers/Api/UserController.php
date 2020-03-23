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
           ]);
            if($request->password)
            {
                 return $this->apiResponse(null,'404');

            }
            $token=$request->header('token');
           if ($validator->fails()||empty($token)) 
            {      
                 return $this->apiResponse(null,'404');    
            }
        DB::table('users')->where('token',$token)->update($request->all());
        $user_data=User::where('token',$token)->first();

        if($user_data)
        {
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
           ]);
         $token=$request->header('token'); 
         if ($validator->fails()||empty($token)) 
         {      
              return $this->apiResponse(null,'404');    
         }
         $request['oldpassword']=md5($request['oldpassword']);
         $request['newpassword']=md5($request['newpassword']);
         $user_password = User::select('password')->where('token',$token)->first();
         if($user_password->password==$request->oldpassword)
         {
            DB::table('users')->where('token',$token)->update(['password'=>$request->newpassword]);
            $user_data=User::where('token',$token)->first();
            if($user_data)
            {
                $data=new UserResource($user_data);
                return $this->apiResponse($data);
            }            
         }
         return $this->apiResponse(null,'404');
        
    }

    //view profile/////////////
    public function display(Request $request)
    {

         $token=$request->header('token');
         if (empty($token)) 
         {      
            return $this->apiResponse(null,'404');      
         }
         $user_data=User::where('token',$token)->first();
        if($user_data)
         
            {
                $user_data->img= asset("storage/$user_data->img");
                $data=new UserResource($user_data);
                return $this->apiResponse($data);
            }
         return $this->apiResponse(null,'404');       
        
    }

    ////srt img/////////
    public function setimg(Request $request)
    {
 
     $validator = Validator::make($request->all(),[
        'img'  =>  'required|file|image|mimes:jpeg,png,gif,jpg|max:2048',
     ]);
     $token=$request->header('token');
     if ($validator->fails()||empty($token)) 
     {      
        return $this->apiResponse(null,'404');      
     }
     $user=User::where('token',$token)->first();
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
