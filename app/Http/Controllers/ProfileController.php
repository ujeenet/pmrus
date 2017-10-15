<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.profile');
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
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|string|max:150',
            'middlename'=>'required|string|max:150',
            'lastname'=>'required|string|max:150',
            'title'=>'required|string|max:150',

        ]);

        $user=Auth::user();
        $profile=$user->profile;

        if ($user->save()){

            $profile->name = $request->name;
            $profile->user_id = $request->id;
            $profile->middlename = $request->middlename;
            $profile->lastname = $request->lastname;
            $profile->title = $request->title;
            $profile->profile_picture = $request->photo;
            $user->save();
        }

        echo "<pre>";
        print_r($profile);
        echo "</pre>";

        if($profile->save()){
            \Session::flash('success','Profile data updated');
            return redirect('/home');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
