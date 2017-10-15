@extends('layouts.proman')

@section('content')


    <div class="container-fluid">
        <div class="box">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Num.</th>
                    <th>Title</th>
                    <th>Duration</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Start</th>
                    <th>Finish</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{$project->id}}</td>
                    <td>{{$project->title}}</td>
                    <td>{{$project->duration}}</td>
                    <td>{{$project->type}}</td>
                    <td>{{$project->description}}</td>
                    <td>{{$project->starts_at}}</td>
                    <td>{{$project->updated_at}}</td>

                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @endsection