@extends ('layouts.proman')

@section('content')
                                                  {{--Project details--}}
    <div class="container-fluid">
        <h3>Номер проекта: {{$project->id}} Название проекта: {{$project->title}}</h3>
        <h3>Описание: {{$project->description}} </h3>
        <div>
             Создан: {{$project->created_at}}
             Обновлен: {{$project->updated_at}}
             Начат: {{$project->starts_at}}
        </div>
    </div>

                                                {{--Actrive Checkpoints List--}}

    <checkpoints-list :pid="{{$project->id}}" inline-template>
        <div class="container-fluid">
            <div class="box">
                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Приоритет</th>
                                <th>Название</th>
                                <th style="width: 50px;">Длительность</th>
                                <th style="width: 200px;">Начало</th>
                                <th style="width: 200px;">Окончание</th>
                                <th style="width: 120px;">Статус</th>
                                <th style="width: 200px;">Ответственный</th>
                                <th style="width: 150px">Опции</th>
                            </tr>
                        </thead>
                    <form>
                            <tr v-for="(form, index) in forms">
                                <td class="text-center">@{{ form.priority }}</td>
                                <td>
                                    <input class="form-control"  v-model="form.title" name="title" id="title">
                                </td>
                                <td>
                                    <input class="form-control"  v-model="form.estimated_duration" name="estimated_duration" id="estimated_duration">
                                </td>
                                <td >
                                    @{{ convertTime(form.start_date) }}
                                </td>

                                <td>
                                    @{{ convertTime(form.finish_date) }}
                                </td>

                                <td>
                                    <select class="form-control" v-model="form.status">
                                        <option value="in_process">В процессе</option>
                                        <option value="additional">Внеплановое</option>
                                        <option value="on_hold">Задержан</option>
                                        <option value="done">Закончен</option>
                                    </select>
                                </td>
                                <td >
                                    <select class="form-control" v-model="form.resource_id">
                                        <option v-for="resource in resources" v-bind:value="resource.id">@{{ resource.name }}</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="button-group">
                                        <a class="btn btn-success btn-xs"  href="#" @click.prevent="dragUp(index ,form)">
                                            <i class="fa fa-arrow-up"></i></a>
                                        <a class="btn btn-success btn-xs"  href="#" @click.prevent="dragDown(index, form)">
                                            <i class="fa fa-arrow-down"></i></a>
                                    {{--<a class="btn btn-primary btn-xs"  href="#" @click.prevent="checkpointUpdate(index, form, form.id)">--}}
                                        {{--<i class="fa fa-refresh"></i></a>--}}
                                    <a class="btn btn-danger btn-xs"  href="#" @click.prevent="checkpointDelete(index, form, form.id)">
                                        <i class="fa fa-close"></i></a>
                                    </div>
                            </tr>
                                <td colspan="8"><a href="#" class="btn btn-success btn-lg" href="#" @click.prevent="sendForms()">
                                        <i class="fa fa-refresh"></i>Обновить контрольные точки</a></td>
                            </tr>
                            <tr>

                                <td colspan="2">
                                    <div class="form-group">
                                        <label>Название</label>
                                        <input class="form-control" type="text" v-model="checkpoint.title">
                                    </div>
                                </td>
                                <td>
                                    <div  class="from-group">
                                        <label>Длительность</label>
                                        <input  class="form-control" type="text" v-model="checkpoint.estimated_duration">
                                    </div>
                                </td>
                                <td c colspan="2">
                                    <div class="form-group">
                                        <label>Статус</label>
                                        <select class="text-center form-control text-sm" v-model="checkpoint.status">
                                            <option value="in_process">В процессе</option>
                                            <option value="additional">Внеплановое</option>
                                            <option value="on_hold">Задержан</option>
                                            <option value="done">Окончен</option>
                                        </select>
                                    </div>
                                </td>
                                <td  colspan="3" >
                                    <div class="form-group">
                                        <label>Ответственный</label>
                                    <select class="text-center form-control" v-model="checkpoint.resource_id">
                                        <option v-for="resource in resources" v-bind:value="resource.id">@{{ resource.name }}</option>
                                    </select>
                                    </div>
                                </td>
                                <tr v-if="checkpoint.status == 'additional'">
                                    <td colspan="4" >
                                        <div class="form-group">
                                            <label>Время начала</label>
                                            <input class="form-control" type="date" v-model="checkpoint.start_date" required>
                                        </div>
                                    </td>

                                    <td colspan="4" >
                                        <div class="form-group">
                                            <label>Время окончания</label>
                                            <input class="form-control" type="date" v-model="checkpoint.finish_date" required>
                                        </div>
                                    </td>
                                </tr>
                                <td colspan="8">
                                    <a href="#" class="btn btn-lg btn-success text-sm" @click.prevent="addCheckpoint()">
                                        Добавить <br> контрольную точку</a>
                                </td>
                            </tr>
                    </form>
                </table>

                                                        {{--Checkpoints On hold List--}}

            </div>
                <div class="container-fluid>">
                    <div class="box box-primary collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Задержанные </h3>
                            <div class="box-tools pull-right">
                                <a class="btn btn-primary btn-sm" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table trable-striped table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 700px;">Название</th>
                                    <th style="width: 50px;">Длительность</th>
                                    <th style="width: 150px;">Статус</th>
                                    <th>Начат</th>
                                    <th>Окончен</th>
                                    <th style="width: 200px;">Ответственный</th>
                                    <th style="width: 150px">Опции</th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr v-for="(form, index) in formsOnhold">
                                    <td>@{{ form.title }}</td>
                                    <td>@{{ form.estimated_duration }}</td>
                                    <th>
                                        <select class="form-control" v-model="form.status">
                                            <option value="on_hold">Задержан</option>
                                            <option value="additional">Внеплпновое</option>
                                            <option value="in_process">В процессе</option>
                                            <option value="done">Окончен</option>
                                        </select>
                                    </th>
                                    <th>@{{ convertTime(form.start_date) }}</th>
                                    <td>@{{ convertTime(form.finish_date) }}</td>
                                    <td>@{{ form.resource_id }}</td>
                                    <td>
                                        <a class="btn btn-danger btn-xs"  href="#" @click.prevent="checkpointDelete(index, form, form.id)">
                                            <i class="fa fa-close"></i></a>
                                        <a class="btn btn-primary btn-xs"  href="#" @click.prevent="checkpointRefresh(index, form, form.id)">
                                            <i class="fa fa-refresh"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                                            {{--Checkpoints DoneList--}}

            <div class="container-fluid>">
                <div class="box box-primary collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Оконченные контрольные точки</h3>
                        <div class="box-tools pull-right">
                            <a class="btn btn-primary btn-sm" data-widget="collapse">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table trable-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 700px;">Название</th>
                                <th style="width: 50px;">Длительность</th>
                                <th style="width: 150px;">Статус</th>
                                <th>Начат</th>
                                <th>Окончен</th>
                                <th style="width: 200px;">Ответственный</th>
                                <th style="width: 150px">Опции</th>
                            </tr>

                            </thead>
                            <tbody>
                            <tr v-for="(form, index) in formsDone">
                                <td>@{{ form.title }}</td>
                                <td>@{{ form.estimated_duration }}</td>
                                <th>
                                    <select class="form-control" v-model="form.status">
                                        <option value="on_hold">Задержан</option>
                                        <option value="additional">Внеплпновое</option>
                                        <option value="in_process">В процессе</option>
                                        <option value="done">Окончен</option>
                                    </select>
                                </th>
                                <th>@{{ convertTime(form.start_date) }}</th>
                                <td>@{{ convertTime(form.finish_date) }}</td>
                                <td>@{{ form.resource_id }}</td>
                                <td>
                                    <a class="btn btn-danger btn-xs"  href="#" @click.prevent="checkpointDelete(index, form, form.id)">
                                        <i class="fa fa-close"></i></a>
                                    <a class="btn btn-primary btn-xs"  href="#" @click.prevent="checkpointRefresh(index, form, form.id)">
                                        <i class="fa fa-refresh"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </checkpoints-list>
@endsection