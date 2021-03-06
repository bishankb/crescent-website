@extends('layouts.backend')

@section('title')
    Features
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Feature</h3>
                        <div class="pull-right">
                            <a href="{{ route('features.index') }}" class="btn btn-success">Back to Listing</a>
                        </div>
                    </div>
                    {!! Form::model($feature, ['method' => 'patch', 'route' => ['features.update', $feature->id], 'files' => 'true']) !!}
                        <div class="box-body">
                        
                            @include('backend.feature._form')
                            
                        </div>
                        <div class="box-footer">
                            {!! Form::submit('Update', ['class' => 'btn btn-success save']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
