@extends('layouts.proman')

@section('content')

    <projects-list :listbystatus="{{$status}}" inline-template>
        <div>
        <div class="container-fluid">
            <div class="box">
                <table class="table table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Номер.</th>
                                    <th style="width: 30%;">Название</th>
                                    <th>Статус</th>
                                    <th>Длительность</th>
                                    <th>Тип</th>
                                    <th>Начат</th>
                                    <th>Обновлен</th>
                                    <th>Опции</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(form, index) in forms.data">
                                    <td>  @{{form.id}} </td>
                                    <td>
                                        <a :href="'/checkpoint/index/'+form.id" >@{{form.title}}</a>

                                    </td>
                                    <td style="width: 120px;">
                                        <select class="form-control text-sm" v-model="form.status">
                                            <option value="in_process">В процессе</option>
                                            <option value="on_hold">Задержан</option>
                                            <option value="done">Окончен</option>
                                        </select>
                                    </td>
                                    <td> @{{form.duration}} </td>
                                    <td v-if="form.type==='schedule'">
                                        План работ
                                    <td v-else-if="form.type==='experimental'">
                                        Эксперимент
                                    <td v-else-if="form.type==='new'">
                                        Новое Оборудование
                                    <td v-else-if="form.type==='fix'">
                                        Исправление
                                    <td v-else-if="form.type==='upgrade'">
                                        Доработка
                                    </td>
                                    <td> <input class="form-control" type="date" v-model="form.starts_at">  </td>
                                    <td> @{{ form.updated_at }} </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-primary btn-sm" @click.prevent="updateProject(form.id, form.status, form.starts_at)"><i class="fa fa-refresh"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm" @click.prevent="discardProject(form.id , index)"><i class="fa fa-close"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                </table>
            </div>
                </div>
                    <div class="text-center">
                            <ul class="pagination pagination-sm">
                                <li> <a href="#" @click.prevent="prevPage()">Пред</a></li>
                                <li v-for="num in forms.last_page"><a href="#" @click.prevent="getPage(num)">@{{ num }}</a></li>
                                <li> <a href="#" @click.prevent="nextPage()">След</a></li>
                            </ul>
                    </div>
            <div class="container-fluid">
                                                                {{--COLLAPSED BOX--}}
                    <div class="box box-primary collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{__('Добавить Проект')}}</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn box-tool btn-primary" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                                                                {{--COLLAPSED BOX-DATA--}}
                            <form>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="project.title">Название</label>
                                            <input class="text form-control" v-model="project.title">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="project.status">Статус</label>
                                            <select class="form-control" v-model="project.status">
                                                <option selected value="in_process">В процессе</option>
                                                <option value="on_hold">Задержан</option>
                                                <option value="done">Окончен</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="project.type">Тип</label>
                                            <select class="form-control" v-model="project.type">
                                                 <option value="schedule">План работ</option>
                                                 <option selected value="new">Новое оборудование</option>
                                                 <option value="experimental">Експеримент</option>
                                                 <option value="upgrade">Улучшение</option>
                                                 <option value="fix">Исправление</option>
                                             </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="project.starts_at">Начало</label>
                                            <input class="form-control" type="date" v-model="project.starts_at">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="container-fluid">
                                                <div class="form-group">
                                                    <label for="project.description">Описание</label>
                                                    <textarea class="text form-control" v-model="project.description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" >
                                        <div class="text-center" >
                                            <a type="button" class="btn btn-primary btn-lg "  @click.prevent="addProject()">Добавить проект</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{--COLLAPSED BOX-DATA - END--}}
                        </div>
                      </div>
                    </div>

                    <div class="container-fluid">
                            <div class="box box-primary collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Задержанные</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn box-tool btn-primary" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                        </div>
                                </div>
                                <div class="box-body">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Номер.</th>
                                            <th style="width: 30%;">Название</th>
                                            <th>Статус</th>
                                            <th>Длительность</th>
                                            <th>Тип</th>
                                            <th>Начат</th>
                                            <th>Обновлен</th>
                                            <th>Опции</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(form, index) in formsOnhold">
                                            <td>  @{{form.id}} </td>
                                            <td>
                                                <a :href="'/checkpoint/index/'+form.id" >@{{form.title}}</a>
                                            </td>
                                            <td style="width: 120px;">
                                                <select class="form-control text-sm" v-model="form.status">
                                                    <option value="in_process">В процессе</option>
                                                    <option value="on_hold">Задержан</option>
                                                    <option value="done">Окончен</option>
                                                </select>
                                            </td>
                                            <td> @{{form.duration}} </td>
                                            <td v-if="form.type==='schedule'">
                                                План работ
                                            <td v-else-if="form.type==='experimental'">
                                                Эксперимент
                                            <td v-else-if="form.type==='new'">
                                                Новое Оборудование
                                            <td v-else-if="form.type==='fix'">
                                                Исправление
                                            <td v-else-if="form.type==='upgrade'">
                                                Доработка
                                            </td>
                                            <td style="width: 100px;">
                                                <input class="form-control" type="date" v-model="form.starts_at">
                                            </td>
                                            <td> @{{ form.updated_at }} </td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-primary btn-sm" @click.prevent="updateProject(form.id, form.status, form.starts_at)"><i class="fa fa-refresh"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm" @click.prevent="deleteProject(form.id , index)"><i class="fa fa-close"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    <div class="container-fluid">
                            <div class="box box-primary collapsed-box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Законченные</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn box-tool btn-primary" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                            </div>
                                     </div>
                                    <div class="box-body">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Номер.</th>
                                                <th style="width: 30%;">Название</th>
                                                <th>Статус</th>
                                                <th>Длительность</th>
                                                <th>Тип</th>
                                                <th>Начат</th>
                                                <th>Обновлен</th>
                                                <th>Опции</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(form, index) in formsDone">
                                                <td>  @{{form.id}} </td>
                                                <td>
                                                    <a :href="'/checkpoint/index/'+form.id" >@{{form.title}}</a>
                                                </td>
                                                <td style="width: 120px;">
                                                    <select class="form-control text-sm" v-model="form.status">
                                                        <option value="in_process">В процессе</option>
                                                        <option value="on_hold">Задержан</option>
                                                        <option value="done">Окончен</option>
                                                    </select>
                                                </td>
                                                <td> @{{form.duration}} </td>
                                                <td v-if="form.type==='schedule'">
                                                    План работ
                                                <td v-else-if="form.type==='experimental'">
                                                    Эксперимент
                                                <td v-else-if="form.type==='new'">
                                                    Новое Оборудование
                                                <td v-else-if="form.type==='fix'">
                                                    Исправление
                                                <td v-else-if="form.type==='upgrade'">
                                                    Доработка
                                                </td>
                                                </td>
                                                <td style="width: 100px;">
                                                    <input class="form-control" type="date" v-model="form.starts_at">
                                                </td>
                                                <td> @{{ form.updated_at }} </td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-primary btn-sm" @click.prevent="updateProject(form.id, form.status, form.starts_at)"><i class="fa fa-refresh"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm" @click.prevent="deleteProject(form.id , index)"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                            </div>
                    </div>
            @if (Auth::user()->is_admin == 'admin')
            <div class="container-fluid">
                <div class="box box-primary collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Сброшенные проекты</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn box-tool btn-primary" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Номер.</th>
                                <th style="width: 30%;">Название</th>
                                <th>Статус</th>
                                <th>Длительность</th>
                                <th>Тип</th>
                                <th>Начат</th>
                                <th>Обновлен</th>
                                <th>Опции</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(form, index) in formsDiscard">
                                <td>  @{{form.id}} </td>
                                <td>
                                    <a :href="'/checkpoint/index/'+form.id" >@{{form.title}}</a>
                                </td>
                                <td style="width: 120px;">
                                    <select class="form-control text-sm" v-model="form.status">
                                        <option value="in_process">В процессе</option>
                                        <option value="on_hold">Задержан</option>
                                        <option value="done">Окончен</option>
                                        <option value="discard">Сброшен</option>
                                    </select>
                                </td>
                                <td> @{{form.duration}} </td>
                                <td v-if="form.type==='schedule'">
                                    План работ
                                <td v-else-if="form.type==='experimental'">
                                    Эксперимент
                                <td v-else-if="form.type==='new'">
                                    Новое Оборудование
                                <td v-else-if="form.type==='fix'">
                                    Исправление
                                <td v-else-if="form.type==='upgrade'">
                                    Доработка
                                </td>
                                <td style="width: 100px;">
                                    <input class="form-control" type="date" v-model="form.starts_at">
                                </td>
                                <td> @{{ form.finish }} </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-primary btn-sm" @click.prevent="updateProject(form.id, form.status, form.starts_at)"><i class="fa fa-refresh"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm" @click.prevent="deleteProject(form.id , index)"><i class="fa fa-close"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </projects-list>
@endsection