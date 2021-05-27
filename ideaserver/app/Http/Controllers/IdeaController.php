<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Like;
use Illuminate\Http\Request;

class IdeaController extends Controller
{

    public function showAll() {
        // $ideas = Idea::all();
        $ideas = Idea::paginate(10);
        return $ideas;
    }

    // public function getUserLikes(Request $request) {
    //     $ideas = Idea::paginate(10)->toArray();
    //     $likes = Like::where('user_id', $request->user()->id)->get()->toArray();
    //     for ($i = 0; $i < count($likes); $i++) {
    //         $likes[$i] = $likes[$i]['post_id'];
    //     }
    //     for ($i = 0; $i < count($ideas['data']); $i++) {
    //         $ideas['data'][$i]['liked'] = false;
    //         if (in_array($ideas['data'][$i]['id'], $likes)) {
    //             $ideas['data'][$i]['liked'] = true;
    //         }
    //     }
    //     return $ideas;
    // }
    
    public function random() {
        $ideas = Idea::all();
        return $ideas[array_rand(json_decode($ideas))];
    }

    public function index($id) {
        $idea = Idea::find($id);
        return $idea;
    }

    public function remove(Request $request) {
        if (!$request->user()->tokenCan('server:update')) {
            return ['status' => 'unauthenticated'];
        }
        if (empty($request->id)) {
            return ['status' => 'bad request'];
        }
        $idea = Idea::find($request->id);
        $idea->delete();
        return ['status' => 'ok'];
    }

    public function create(Request $request) {
        if (!$request->user()->tokenCan('idea:create')) {
            return ['status' => 'unauthenticated'];
        }
        $idea = new Idea;
        if (empty($request->text) || empty($request->theme)) {
            return ['status' => 'bad request'];
        }
        $idea->text = $request->text;
        $idea->theme = $request->theme;
        $idea->author = $request->user()->name;
        $idea->likes = 0;
        $idea->save();
        return $idea;
    }

    public function add_like(Request $request) {
        if (empty($request->id)) {
            return ['status' => 'bad request'];
        }
        $idea = Idea::find($request->id);

        $like = Like::where('user_id', $request->user()->id)->where('post_id', $request->id)->first();
        if (!$like) {
            $like = new Like;
            $like->user_id = $request->user()->id;
            $like->post_id = $request->id;
            $like->save();

            $idea->likes++;
        } else {
            $like->delete();

            $idea->likes--;
        }

        $idea->save();
        
        return ['status' => 'ok'];
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function show(Idea $idea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idea $idea)
    {
        //
    }
}
