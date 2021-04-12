<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\Task;
use Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all(Request $request)
    {
        $project = Project::where('project_url',$request->project_url)->first();

        $todo = Task::orderBy('id', 'DESC')->
            where('user_id',Auth::user()->id)->
            where('project_id',$project->id)->
            where('status',0)->get();

        $doing = Task::orderBy('id', 'DESC')->
            where('user_id',Auth::user()->id)->
            where('project_id',$project->id)->
            where('status',1)->get();

        $done = Task::orderBy('id', 'DESC')->
            where('user_id',Auth::user()->id)->
            where('project_id',$project->id)->
            where('status',2)->get();
        
        return response()->json([
            'todo' => $todo,
            'doing' => $doing,
            'done' => $done
        ], 200);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_task(Request $request, $id)
    {

        $task = Task::find($id);
        $task->status = $request->status;
        $task->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
