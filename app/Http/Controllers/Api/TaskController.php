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

    public function index()
    {
        return response()->json([
            'tasks' => Task::where('user_id',Auth::user()->id)->get(),
        ], 200);
    }

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
        $project = Project::where('project_url',$request->project_url)->first();

        $tasks = Task::where('project_id',$project->id)->orderBy('id', 'desc')->first();

        $order = 0;

        if($tasks == null)
        {
            $order = 0;
        }

        else if($tasks != null)
        {
            $order = $tasks->order += 1;
        }

        Task::create([
            'user_id' => Auth::user()->id,
            'project_id' => $project->id,
            'order' => $order,
            'status' => 0,
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'start' => $request->start_date,
            'end' => $request->end_date
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'task' => Task::find($id),
        ], 200);
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

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'start' => $request->start_date,
            'end' => $request->end_date
        ]);
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
        $task = Task::find($id);
        $task->delete();
    }
}
