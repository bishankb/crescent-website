@extends('layouts.backend')

@section('title')
    Role
@endsection

@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-md-11">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Service</h3>
                        <div class="pull-right">
                            <a href="{{ route('services.index') }}" class="btn btn-success">Back to Listing</a>
                        </div>
                    </div>
                    {!! Form::model($role, ['method' => 'PUT', 'route' => ['roles.update',  $role ]]) !!}
                        <div class="box-body">
                           
                            @include('backend.roles._form')

                            @if($role->name === 'admin')
                                @include('backend.roles._permissions', [
                                    'title' => 'Permissions',
                                    'options' => ['disabled']
                                ])
                            @else
                                @include('backend.roles._permissions', [
                                    'title' => 'Permissions',
                                    'model' => $role
                                ])
                            @endif
                        </div>

                        <div class="box-footer">
                            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection