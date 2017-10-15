<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Checkpoint;
use App\Resource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $status=null )
    {
        $view = view ('projects.index', compact('status'));

        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data=$request->project;

        $project=Project::create([
           'company_name'=> Auth::user()->company,
           'title'=>$data['title'],
           'description'=>$data['description'],
           'type'=>$data['type'],
           'status'=>$data['status'],
           'starts_at'=>$data['starts_at'],
           ]);

//       if ($project){
//           return "success";
//       }else{
//           return "go to hell bitch";
//       };
        return $project;

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
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function listall ($parameter = 0)
    {

        if ($parameter == 0)
        {


            $projectsinprocess = Project::where(['status'=>'in_process', 'company_name'=>Auth::user()->company])->orderBy('created_at', 'ASC')->paginate(10);

            $projectsonhold = Project::where(['status'=>'on_hold', 'company_name'=>Auth::user()->company])->orderBy('created_at', 'ASC')->get();

            $projectsdone = Project::where(['status'=>'done', 'company_name'=>Auth::user()->company])->orderBy('created_at', 'ASC')->get();

            $projectsdiscard = Project::where(['status'=>'discard', 'company_name'=>Auth::user()->company])->orderBy('created_at', 'ASC')->get();

            $projects=['in_process'=>$projectsinprocess, 'on_hold'=>$projectsonhold, 'done'=>$projectsdone, 'discard'=>$projectsdiscard];

            return $projects;
        }
        elseif ($parameter == 1)
        {
           $projects = Project::where(['status'=>'in_process', 'company_name'=>Auth::user()->company])->orderBy('created_at', 'ASC')->get();

           return view('projects.list', compact('projects'));
        }
        elseif ($parameter == 2)
        {
           $projects = Project::where(['status'=>'on_hold', 'company_name'=>Auth::user()->company])->orderBy('created_at', 'ASC')->get();
            return view('projects.list', compact('projects'));
        }

        elseif ($parameter == 3)
        {
           $projects = Project::where(['status'=>'done', 'company_name'=>Auth::user()->company])->orderBy('created_at', 'ASC')->get();
            return view('projects.list', compact('projects'));
        }
        elseif ($parameter == 4)
        {
           $projects = Project::where(['status'=>'discard', 'company_name'=>Auth::user()->company])->orderBy('created_at', 'ASC')->get();
            return view('projects.list', compact('projects'));
        }
        elseif ($parameter == 5){
            $projects = Project::where(['status'=>'in_process','company_name'=>Auth::user()->company, 'type'=>'schedule'])->orderBy('created_at', 'ASC')->get();

            foreach ($projects as $project){
                $project->checkpoints=Checkpoint::where('project_id',$project->id)->get();
                    foreach ($project->checkpoints as $checkpoint){
                        $checkpoint->resource = Resource::where('id',$checkpoint->resource_id)->first();
                    }
            }

            return view('projects.schedule', compact('projects'));
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update($pid, Request $request)
    {
        //dd ($request->starts_at);

       $project = Project::where('id',$pid)->first();

       if ($project->type=='schedule' && $request->status=='done')
       {

           $nextproject=$project->replicate();
           $nextproject->status = 'in_process';
           $nextproject->push();

           foreach ($project->checkpoints()->get() as $checkpoint)
           {

               if ($checkpoint->status != 'done')
               {
                  $newcheckpoint = $checkpoint->replicate();
                  $newcheckpoint->project_id=$nextproject->id;
                  $newcheckpoint->push();
               }
           }

       }

       $project->status=$request->status;
       $project->starts_at=$request->starts_at;

       $update = $project->save();

//       return $update;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function discard($id)
    {

        echo $id;
        $project=Project::where('id',$id)->first();

        $project->status='discard';

        if ($project->save()) {
            return "Project Successfully Discarded";
        }else{
            return "Project Was not Discarded";
        }

    }
}

