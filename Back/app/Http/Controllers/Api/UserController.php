<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
class UserController extends Controller
{
    use ApiResponseTrait;
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|min:4|max:20|unique:users',
            'email' => 'required|max:80|email|unique:users',
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6',
            'age' => 'required|integer',
           ]);
           unset($request['password_confirmation']); 
           $password=$request->password;
           $request['password']=md5($request['password']);
           $user = new User;
           $user->username=$request->username;
           $user->email=$request->email;
           $user->password=$request->password;
           $user->age=$request->age;
           $user->bio=$request->bio;
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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'min:4|max:20|unique:users',
            'email' => 'max:80|email|unique:users',
            'age' => 'integer',
            'id'=>'required|integer'
           ]);
            if($request->password)
            {
                 return $this->apiResponse(null,'404');

            }
           if ($validator->fails()) 
            {      
                return response()->json(['status'=>404, 'msg'=>$validator->messages()->first()]);      
            }
              
        DB::table('users')->where('id',$request->id)->update($request->all());
        $user_data=User::find($request->id);
        if($user_data)
        {
            $data=new UserResource($user_data);
            return $this->apiResponse($data);
        }
         return $this->apiResponse(null,'404');
        
    }
    public function changepassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            
            'id'=>'required|integer',
            'oldpassword' => 'required|min:6',
            'newpassword' => 'required|min:6',
           ]);
       
         $request['oldpassword']=md5($request['oldpassword']);
         $request['newpassword']=md5($request['newpassword']);
         $user_password = User::select('password')->where('id',$request->id)->first();
         if($user_password->password==$request->oldpassword)
         {
            DB::table('users')->where('id',$request->id)->update(['password'=>$request->newpassword]);
            $user_data=User::find($request->id);
            if($user_data)
            {
                $data=new UserResource($user_data);
                return $this->apiResponse($data);
            }            
         }
         return $this->apiResponse(null,'404');
        
    }
    
    public function display(Request $request)
    {
        $user_data=User::find($request->id);
        if($user_data)
        {
            $user_data->img= asset("storage/$user_data->img");
            $data=new UserResource($user_data);
            return $this->apiResponse($data);
        }
         return $this->apiResponse(null,'404');       
        
    }

}
