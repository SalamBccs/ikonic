<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Comment;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index(Request $request)
    {
        $q = $request->search_query;
        $feedbacks = Feedback::with('comments')->orderBy('id', 'ASC')
            ->when($q, function ($qry) use ($q) {
                $qry->where('title', 'like', '%' . $q . '%');
                $qry->orWhere('description', 'like', '%' . $q . '%');
                $qry->orWhere('category', 'like', '%' . $q . '%');
            })->paginate($request->pageSize);

        return response()->json([
            'success' => true,
            'message' => 'Record list.',
            'record' => $feedbacks
        ]);
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
     * @param  \App\Http\Requests\StoreFeedbackRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(),[
            'title' => 'required|unique:feedback',
            'description'     => 'required|string',
            'category' => 'required', 'string',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors()->first(),
            ]);
        }
        $user = Auth::user();
        

        $inputs = $request->all();
        $inputs['username'] = $user->username;
        $Feedback = Feedback::create($inputs);
        return response()->json([
            'success' => true,
            'message' => 'Feedback Store Successfully.',
            'user' => $Feedback,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFeedbackRequest  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
