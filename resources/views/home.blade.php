@extends('layouts.proman')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if (Auth::check())
                        <h4 class="text-center text-aqua"><a href="/profile">Привет {{ Auth::user()->profile->name}}. !!!</a></h4>
                    @else
                     <h4 class="text-center">Вы не вошли!</h4>
                      <h1 class="text-center">  <a href="/login">Войдите со своей учетной записью</a></h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::check())
    <div class="form-group has-error">
        <div class="container-fluid well">
            <div class="row">
                <div class="col-md-12">
                    <div class="container">
                        <div class="col-md-6 ">
                            <h3 class="text-aqua text-center">Проекты нашей компании</h3>
                            <ul class="well">
                                <div  class="form-group ">
                                    <a  href="/project/index/0">
                                        <li class="btn btn-default" style="width: 200px;">
                                            Все проекты
                                        </li>
                                    </a>
                                    <strong class="pull-right">{{$all}}</strong>
                                </div>
                                <div class="form-group">
                                    <a href="/project/listall/1">
                                        <li class="btn btn-default" style="width: 200px;">
                                             Активные
                                        </li>
                                    </a>
                                    <strong class="pull-right">{{$active}}</strong>
                                </div>
                                <div class="form-group">
                                    <a href="/project/listall/2">
                                        <li class="btn btn-default" style="width: 200px;">
                                            Задержаны
                                        </li>
                                    </a>
                                    <strong class="pull-right">{{$on_hold}}</strong>
                                </div>
                                <div class="form-group">
                                    <a  href="/project/listall/3">
                                    <li class="btn btn-default"  style="width: 200px;">
                                            Оконченные
                                        </li>
                                    </a>
                                    <strong class="pull-right">{{$done}}</strong>
                                </div>
                            </ul>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-aqua text-center"><a href="/resource/index">Наша команда</a></h3>
                        <ol class="messages-menu">
                            @foreach($resources as $resource)

                            <li>
                                <a href="resource/{id}">{{$resource->name}} {{$resource->middlename}} {{$resource->lastname}} </a>
                            </li>

                                @endforeach
                        </ol>
                    </div>
                    {{--<div class="col-md-4">--}}
                        {{--<h3 class="text-aqua text-center"><a href="calendar/list">Today is</h3>--}}
                        {{--<ul>--}}
{{--<li>--}}
    {{--day and date--}}
{{--</li>--}}
                        {{--<li>--}}
                {{--full date--}}
                        {{--</li>--}}
{{--closest critical tasks to check--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
