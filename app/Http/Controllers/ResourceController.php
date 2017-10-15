<?php

namespace App\Http\Controllers;

use App\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('resource.index');

    }

    public function create(Request $request)
    {
        $auth=Auth::id();

        $data = $request->input();

        $rules = [
             'name'=>'required|string',

        ];

    $validator = Validator::make($request->input()['form'],$rules);

        if($validator->fails()){
            return Response::json([
                'errors'=>$validator->getMessageBag()->toArray()
            ]);
        }
        $resource = Resource::create([
                'company_name'=>Auth::user()->company,
                'name'=>$data['form']['name'],
                'middlename'=>$data['form']['middlename'],
                'lastname'=>$data['form']['lastname'],
                'phone'=>$data['form']['phone'],
                'email'=>$data['form']['email'],
                'title'=>$data['form']['title'],
                'birthdate'=>$data['form']['birthdate'],
            ]);

        return $resource;

    }

    public function listall ($parameter = null)
    {
        $resources= Resource::where('company_name',Auth::user()->company)->orderBy('id', 'DESC')->get();

        return $resources;

    }
    public function getname ($id)
    {
        $resource= Resource::where('id',$id)->first();

        return $resource->name;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


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
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return Resource::destroy($id);
    }
}
