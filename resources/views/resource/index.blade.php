@extends('layouts.proman')

@section('content')


<resource-list inline-template>
    <div class="box">
    <div class="container-fluid">
        <table class=" table table-striped table-responsive table-bordered table-inverse">
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Отчество</th>
                    <th>Фамилия</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>Должность</th>
                    <th>День рождения</th>
                    @if (Auth::user()->is_admin == 'admin')
                    <th>Опции</th>
                        @endif
                </tr>
            </thead>
            <tbody>
            <tr v-for="resource in resources">
                <td>@{{resource.name}}</td>
                <td>@{{resource.middlename}}</td>
                <td>@{{resource.lastname}}</td>
                <td>@{{resource.phone}}</td>
                <td>@{{resource.email}}</td>
                <td>@{{resource.title}}</td>
                <td>@{{resource.birthdate}}</td>
                @if (Auth::user()->is_admin == 'admin')
                <td>
                    <a class="bnt btn-success btn-xs" v-bind:href="/resourceedit/+(resource.id)"> <i class="fa fa-edit"></i></a>
                    <a href="#" class="bnt btn-danger btn-xs" @click.prevent="deleteResource(resource,resource.id)"> <i class="fa fa-close"></i></a>
                </td>
                @endif
                {{ csrf_field() }}
            </tr>
            </tbody>
        </table>
    </div>
    </div>
</resource-list>
@if (Auth::user()->is_admin == 'admin')
    <div class="container-fluid">
        <div class="row">
                <add-resource  inline-template>
                    <div class="box box-success collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{__('Добавить в команду')}}</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool btn-primary" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <form method="post" action="#" @submit.prevent="sendForm()">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div :class="(errors.name)?'has-error form-group':'form-group'">
                                            <label for="name">{{__('Name ')}}</label>
                                            <input type="text" v-model="form.name" class="form-control" name="name" id="name">
                                            <span class="text-danger" v-if="errors.name">
                                            @{{ errors.name[0] }}
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div :class="(errors.middlename)?'has-error form-group':'form-group'">
                                            <label for="middlename">{{__('Middlename')}}</label>
                                            <input type="text" v-model="form.middlename" class="form-control" name="middlename" id="middlename">
                                            <span class="text-danger" v-if="errors.middlename">
                                            @{{ errors.middlename[0] }}
                                        </span>
                                        </div>
                                    </div>

                                <div class="col-xs-4">
                                    <div :class="(errors.lastname)?'has-error form-group':'form-group'">
                                        <label for="lastname">{{__('Lastname')}}</label>
                                        <input type="text" v-model="form.lastname" class="form-control" name="lastname" id="lastname">
                                            <span class="text-danger" v-if="errors.lastname">
                                            @{{ errors.lastname[0] }}
                                        </span>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-xs-3">
                                    <div :class="(errors.phone)?'has-error form-group':'form-group'">
                                        <label for="phone">{{__('Phone')}}</label>
                                        <input type="text" v-model="form.phone" class="form-control" name="phone" id="phone">
                                        <span class="text-danger" v-if="errors.phone">
                                            @{{ errors.phone[0] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div :class="(errors.birthdate)?'has-error form-group':'form-group'">
                                        <label for="birthdate">{{__('Birthdate')}}</label>
                                        <input type="date" v-model="form.birthdate" class="form-control" name="birthdate" id="email">
                                        <span class="text-danger" v-if="errors.birthdate">
                                            @{{ errors.birthdate[0] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div :class="(errors.title)?'has-error form-group':'form-group'">
                                        <label for="title">{{__('Position')}}</label>
                                        <input type="text" v-model="form.title" class="form-control" name="title" id="title">
                                        <span class="text-title" v-if="errors.title">
                                            @{{ errors.title[0] }}
                                        </span>
                                    </div>
                                </div>
                                    <div class="col-xs-3">
                                        <div :class="(errors.title)?'has-error form-group':'form-group'">
                                            <label for="email">{{__('E-mail')}}</label>
                                            <input type="text" v-model="form.email" class="form-control" name="email" id="email">
                                            <span class="text-email" v-if="errors.email">
                                            @{{ errors.email[0] }}
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-flat btn-success btn-lg"><i class="fa fa-plus"></i> {{__('Add Team Mate')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </add-resource>
        </div>
    </div>
@endif
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.5/sweetalert2.min.css">
@endsection
