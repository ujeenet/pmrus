@extends('layouts.proman')

@section('content')


    <div class="container-fluid well col-md-6 col-md-offset-3">
        <h1 class="text-center text-aqua well"> Your Profile Info

            <img @if (Auth::user()->profile->profile_picture->xsmall->url !=null)

                 src= "{{Auth::user()->profile->profile_picture->xsmall->url}}"

                 @else src="/dist/img/user2-160x160.jpg"

                 @endif

                 class="img-circle" alt="User Image"></h1>

         <form method="post" action="/profile/update/{{Auth::id()}}" enctype="multipart/form-data">

             {{ csrf_field() }}

             <img src="">
                     <div class="form-group">
                         <label for="photo">Upload your photo</label>
                         <input id="photo" name="photo" type="file" class="form-control" value="">
                     </div>
                    <div class="form-group">

                        <label for="name">Your Name</label>
                        <input id="name" name="name" type="text" class="form-control" value="{{Auth::user()->profile->name}}">

                    </div>

                    <div class="form-group">
                        <label for="middlename">Your Middlename</label>
                        <input id="middlename" name="middlename" type="text" class="form-control" value="{{Auth::user()->profile->middlename}}">
                    </div>

                    <div class="form-group">
                        <label for="lastname">Your Lastname</label>
                        <input id="lastname" name="lastname" type="text" class="form-control" value="{{Auth::user()->profile->lastname}}">
                    </div>

                    <div class="form-group">
                        <label for="title">Your Title</label>
                        <input id="title" name="title" type="text"  class="form-control" value="{{Auth::user()->profile->title}}">
                    </div>

                    <button type="submit" class="btn btn-success"> Update Profile Info </button>

            </div>
        </form>

    </div>






@endsection
