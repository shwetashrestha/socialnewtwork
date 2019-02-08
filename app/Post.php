<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table ="posts";
    protected $primaryKey ="id";
    protected $fillable = ['title','body'];
    
    public function savePost($request){
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
                
        ];
        //dd($data);	
        
     return self::create($data);
     
    }
    public function updatePost($request,$id){
    
        $post = self::find($id);
        //dd($student); 
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body')
            
            
        ];	
        // dd($data);
        return $post->update($data);
    }
}
