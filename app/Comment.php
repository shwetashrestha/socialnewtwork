<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table ="comments";
    protected $primaryKey ="id";
    protected $foreignKey ="postId";
    protected $fillable = ['postId','comment'];

    public function saveComment($request){
        $data = [
            'postId' => $request->get('postId'),
            'comment' => $request->get('comment')        
                
        ];   
        //  dd($data);            
     return self::create($data);
     
    }
    public function updateComment($request,$id){
    
        $comment = self::find($id);
        //dd($student); 
        $data = [
            'postId' => $request->get('postId'),
            'comment' => $request->get('comment')
                      
        ];	
        // dd($data);
        return $comment->update($data);
    }
}
