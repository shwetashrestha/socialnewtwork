<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Friend;

class UserController extends Controller
{
    public $successStatus = 200;
    public $user;
    public $friend;
    public function __construct(User $user,Friend $friend){
        $this->user = $user;
        $this->friend = $friend;
    }
   
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user();
            $data = [
                'token' => $user->createToken('MyApp')->accessToken,
                'user' => $user
            ]; 
            // $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => true, 'data' => $data], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required',  
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus); 
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    // public function details() 
    // { 
        
    //         $user = User::get();
    //         $data = [
    //             //'token' => $user->createToken('MyApp')->accessToken,
    //             'user' => $user
    //         ]; 
       
    //     return response()->json(['success' => $user], $this-> successStatus); 
    // }
    public function details($userId) 
    { 
        $user = User::find($userId);
        if($user)
        {
            return response()
                ->json(
                    [
                        'success' => true, 
                        'data' => $user, 
                        'message' => 'user Retrieved Successfully'
                    ], 
                    $this-> successStatus);
        }
        return response()
                ->json(
                    [
                        'success' => false, 
                        'message' => 'user does not exist'
                    ], 
                404);
    } 
    public function index(){
        $data= User::orderBY('created_at','desc')->get();
        return response()->json([
            'data'=> $data,
        ]);
    }
    public function destroy($id)
    {
      
        $user = User::findOrFail($id);
        // $user->delete();
        // dd('done');
        // // return response()->json(,204);
        if(! $user){
            return response()->json([
                'success'=>false,
                'message'=>'User with id ' .$id. ' not found '
        ]);
        }
        if($user->destroy($id)){
            return response()->json([
                'success'=>true,
                'message'=>'User with id ' .$id. ' successfully deleted'
        ]);
        }

    }
    public function sendFriendrequest(Request  $request){
        
        
        $this->friend->saveFriendrequest($request);
        return response()->json([
            'success' => true,
            'message' => 'Friend Added Successfully'
        ], 200);
        
    }
    public function viewFriendrequest($id){
        $data= Friend::orderBY('created_at','desc')->get();
        return response()->json([
        'data'=> $data,
    ]);
    }
    
    public function acceptFriendrequest(){
        $this->friend->acceptFriend($request);
        return response()->json([
            'success' => true,
            'message' => 'Accept Friend Request  Successfully'
        ], 200);
    }
    public function rejectedFriendrequest($id){

    
        $friend = Friend::find($id);
        if(! $friend){
            return response()->json([
                'success'=>false,
                'message'=>'Friend with User id ' .$id. ' not found '
        ]);
        }
        if($user->destroy($id)){
            return response()->json([
                'success'=>true,
                'message'=>'Friend with User id ' .$id. ' successfully deleted'
        ]);
        }

    }

}

