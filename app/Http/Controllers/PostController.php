<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $post;
    public function __construct(Post $post){
        $this->post = $post;
    }
    public function store(Request $request)
    {
        $this->post->savePost($request);
        return response()->json([
            'success' => true,
            'message' => 'Post Added Successfully'
        ], 200);
    }
    public function index()
    {
        $data= Post::orderBY('created_at','desc')->get();
        return response()->json([
            'data'=> $data,
        ]);
    }
    public function update(Request $request,$id)
    {
        $this->post->updatePost($request, $id);
       
       $data = $this->post->where('id',$id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Post with id' .$id. 'Successfully',
             'data' => $data

        ], 200);
         
    }  
    

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        if(! $post){
            return response()->json([
                'success'=>false,
                'message'=>'Post with id ' .$id. ' not found '
        ]);
        }
        if($post->destroy($id)){
            return response()->json([
                'success'=>true,
                'message'=>'Post with id ' .$id. ' successfully deleted'
        ]);
        }
    }
}
