<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Traits\BaseTrait;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Post as PostResource;


class PostController extends Controller
{
    use BaseTrait;

    /**use App\Http\Resources\Product as ProductResource;

     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();
        return $this->sendResponse(PostResource::collection($posts),'Posts retrieved successfully');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all;
        $validator = Validator::make($input,[
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails){
            return $this->sendError('Validate Error',$validator->errors());
        }
        $post = Post::create($input);
        return $this->sendResponse($success, 'post created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        if($post = null){
            return $this->sendError('Post not found!');
        }
        return $this->sendResponse(new PostResource($post), 'Post retireved successfully');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->all;
        $validator = Validator::make($input,[
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails){
            return $this->sendError('Validate Error',$validator->errors());
        }
        $post->title = $input->title;
        $post->description = $input->description;
        $post->save();
        return $this->sendResponse(new PostResourse($post), 'post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return $this->sendResponse(new PostResourse($post),'Post deleted successfully');
    }
}
