<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
   
    public $comment;
    public function __construct(Comment $comment){
        $this->comment = $comment;
    }
    public function store(Request $request)
    {
        $this->comment->saveComment($request);
        return response()->json([
            'success' => true,
            'message' => 'Comment Added Successfully'
        ], 200);
    }

    
    public function index()
    {
        $data= Comment::orderBY('created_at','desc')->get();
        return response()->json([
            'data'=> $data,
        ]);
    }    
    
    public function update(Request $request,$id)
    {
        $this->comment->updateComment($request, $id);
       
       $data = $this->comment->where('id',$id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Post with id ' .$id. ' Successfully',
             'data' => $data

        ], 200);
         
    }

    
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        if(! $comment){
            return response()->json([
                'success'=>false,
                'message'=>'Comment with id ' .$id. ' not found '
        ]);
        }
        if($comment->destroy($id)){
            return response()->json([
                'success'=>true,
                'message'=>'Comment with id ' .$id. ' successfully deleted'
        ]);
        }
    }
}
