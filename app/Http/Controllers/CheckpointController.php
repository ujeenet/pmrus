<?php

namespace App\Http\Controllers;

use App\Checkpoint;
use App\Project;
use App\Resource;
use function Faker\Provider\pt_BR\check_digit;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckpointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $project = Project::where(['id' => $id])->first();
        $view = view('checkpoints.index');
        $view->with('project', $project);
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listall($pid)
    {

        $checkpoints = Checkpoint::where(['project_id' => $pid])->orderBy('id', 'DESC')->get();
        $checkpoints = $checkpoints->groupBy('status');


        if (Auth::user()->is_admin == 'user') {
            $checkpoints['discard'] = 'access restricted';
        }

        return $checkpoints;

    }

    public function create(Request $request)
    {
        $pid = $request->pid;
        $data = $request->checkpoint;

        if ($data['status'] == 'additional') {
            $data['finish_date'] = strtotime($data['finish_date']);
            $data['start_date'] = strtotime($data['start_date']);
        } else {
            $data['finish_date'] = 0;
            $data['start_date'] = 0;
        }

        $checkpoint = Checkpoint::create([
            'project_id' => $pid,
            'title' => $data['title'],
            'estimated_duration' => $data['estimated_duration'],
            'start_date' => $data['start_date'],
            'finish_date' => $data['finish_date'],
            'status' => $data['status'],
            'resource_id' => $data['resource_id'],
        ]);

        return $checkpoint;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Checkpoint $checkpoint
     * @return \Illuminate\Http\Response
     */
    public function show(Checkpoint $checkpoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checkpoint $checkpoint
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkpoint $checkpoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Checkpoint $checkpoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkpoint $checkpoint)
    {

        $forms = $request->forms;

        foreach ($forms as $checkpointdata) {

            $checkpoint = Checkpoint::where('id', $checkpointdata['id'])->first();

            $checkpoint->title = $checkpointdata['title'];
            $checkpoint->start_date = $checkpointdata['start_date'];
            $checkpoint->finish_date = $checkpointdata['finish_date'];
            $checkpoint->resource_id = $checkpointdata['resource_id'];
            $checkpoint->priority = $checkpointdata['priority'];
            $checkpoint->estimated_duration = $checkpointdata['estimated_duration'];
            $checkpoint->status = $checkpointdata['status'];

            $checkpoint->save();
        }
        return "Checkpoints list successfully updated";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Checkpoint $checkpoint
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Checkpoint::destroy($id);

        return "Checkpoint successfully destroyed";

    }

    /**
     * @param $pid
     * @return \Illuminate\Http\Response
     */
    public function estimate($pid)
    {

        $resources = Resource::whereHas('checkpoints', function ($query) use ($pid) {
            $query->where(['project_id' => $pid]);
        }
        )->get();


        $starttime = Project::find($pid)->starts_at;

        $day = 86400;



        foreach ($resources as $resource) {

            $checkpoints = $resource->checkpoints()
                ->where(['project_id'=>$pid, 'status'=>'in_process'])
                ->orWhere(function ($query) use ($pid) {
                    $query->where('project_id','=', $pid)
                         ->where('status','=','additional');
                })->orderBy('priority','ASC') ->get();

            $previous_date = strtotime($starttime);

            $additional_time = 0;

            foreach ($checkpoints as $checkpoint) {


                if ($checkpoint->status == 'additional') {

                    $additional_time = $additional_time + $checkpoint->estimated_duration;

                } elseif ($checkpoint->status == 'in_process') {

                    $checkpoint->start_date = $previous_date;

                    $estimated_duration = $checkpoint->estimated_duration + $additional_time;
                    $estimated_duration_round = round($estimated_duration, 0, PHP_ROUND_HALF_DOWN);
                    $estimated_duration_dec = $estimated_duration - $estimated_duration_round;
                    $finish_date = $previous_date + ($estimated_duration_dec * $day);

                    for ($i = 1; $i <= $estimated_duration_round; $i++) {

                        $finish_date = $finish_date + $day;
                        $check = date('N', $finish_date);
                        if ($check == 6) {
                            $finish_date = $finish_date + 2 * $day;
                        } elseif ($check == 7) {
                            $finish_date = $finish_date + $day;
                        }
                    };

                    $previous_date = $finish_date;
                    $checkpoint->finish_date = $finish_date;
                    $checkpoint->save();
                    $additional_time = 0;
                }
            }
        }
    }
}
