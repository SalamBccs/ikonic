<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Feedback;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request, $id)
    // {
    //     dd($request->all(), $id);
    //     $comment = Comment::create($request->all());
    
    //     // Extract mentioned users and associate them with the comment
    //     $mentionedUsers = $comment->mentionedUsers();
    //     $users = User::whereIn('username', $mentionedUsers)->get();
    //     $comment->mentionedUsers()->attach($users);
    
    //     return response()->json($comment, 201);
    // }

    public function store(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'username' => 'required',
            'content' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors()->first(),
            ]);
        }
        $method = Feedback::find($id);
        if($method)
        {
            $inputs = $request->all();
            $inputs['feedback_id'] = $id;
            $paymentmethod=Comment::create($inputs);

            return response()->json([
                'status' => true,
                'message' => 'Record Store Successfully.'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Record not found.',
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
