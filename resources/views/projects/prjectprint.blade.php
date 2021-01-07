@extends('layouts.proman')

@section ('content')

    <div id="printableArea">
        <h3>Print timetable</h3>

    @foreach($projects as $project)
                <table class="table table-responsive table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{$project->title}}</th>
                    </tr>
                    </thead>
                </table>
                 <table class="table table-responsive table-bordered table-striped">
                         <thead>
                             <tr>
                                 <th style="width: 20px;">Priority</th>
                                 <th style="width: 300px;">Title</th>
                                 {{--<th style="width: 100px;">Created</th>--}}
                                 <th style="width: 55px;" >Finishing Date</th>
                                 <th style="width: 55px;" >Responsible</th>
                                 <th style="width: 100px;" >Notes</th>
                             </tr>
                         </thead>
                @foreach($project->checkpoints->sortBy('priority') as $checkpoint)
                         <tbody>
                            <tr>
                                <td>{{$checkpoint->priority}}</td>
                                <td>{{$checkpoint->title}}</td>
{{--                                <td>{{$checkpoint->start_date}}</td>--}}
                                <td>{{ \Carbon\Carbon::createFromTimestamp($checkpoint->finish_date)->toDateString()}}</td>
                                <td>
                                    {{$checkpoint->resource->lastname }} {{$checkpoint->resource->name }}
                                </td>
                                <td></td>
                            </tr>
                         </tbody>
                     @endforeach
                  </table>
    @endforeach
    </div>
    <input type="button" onclick="printDiv('printableArea')" value="Print!" />
@endsection
