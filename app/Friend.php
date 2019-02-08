<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table ="friends";
    protected $primaryKey ="id";
    protected $foreignKey ="userId";
    protected $fillable = ['userId','is_accepted','send_by','is_rejected'];
    
    public function saveFriendrequest($request){
        //dd(true);
    $data = [
        'userId' => $request-> get('userId'),
        'is_accepted' => $request-> get('is_accepted'),
        'send_by'=> $request-> get('send_by'),
        'is_rejected' => $request-> get('is_rejected')
        
    ];
    
    //dd($data);
    return self::create($data);
 
}
    public function acceptFriend($request){
    //dd(true);
    $data = [
    'userId' => $request-> get('userId'),
    'is_accepted' => $request-> get('is_accepted'),
    'send_by'=> $request-> get('send_by'),
    'is_rejected' => $request-> get('is_rejected')
    
    ];

dd($data);
    return self::create($data);

}
}
