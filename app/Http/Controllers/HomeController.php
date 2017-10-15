<?php

namespace App\Http\Controllers;

use App\Resource;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where(['company_name'=>Auth::user()->company])->orderBy('created_at', 'ASC')->get();


        $resources = Resource::where(['company_name'=>Auth::user()->company])->orderBy('name','ASC')->get();

        $all = $projects->count();
        $active = $projects->where('status','in_process')->count();
        $on_hold = $projects->where('status','on_hold')->count();
        $done= $projects->where('status','done')->count();


        $view = view('home');

        $view->with("all",$all);
        $view->with("active",$active);
        $view->with("on_hold",$on_hold);
        $view->with("done",$done);
        $view->with("resources",$resources);


        return  $view;
    }
}
