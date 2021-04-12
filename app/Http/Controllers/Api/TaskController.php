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

        $todo = Task::orderBy('order', 'DESC')->
            where('user_id',Auth::user()->id)->
            where('project_id',$project->id)->
            where('status',0)->get();

        $doing = Task::orderBy('order', 'DESC')->
            where('user_id',Auth::user()->id)->
            where('project_id',$project->id)->
            where('status',1)->get();

        $done = Task::orderBy('order', 'DESC')->
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
        $task_single = Task::find($id);
        $task_single->status = $request->status;
        $task_single->save();
    }

    public function update_postion(Request $request)
    {
        $project = Project::where('project_url',$request->project_url)->first();

        $tasks = Task::where('user_id',Auth::user()->id)->
            where('project_id',$project->id)->
            where('status',$request->status)->get();

        $old_task = $tasks[$request->old];
        $new_task = $tasks[$request->new];

        $old_task_update = Task::find($old_task->id)->update([
            'order' => $new_task->order,
        ]);
        $new_task_update = Task::find($new_task->id)->update([
            'order' => $old_task->order,
        ]);

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
