@extends('layouts.backend')

@section('title')
    Blogs
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create Blog</h3>
                        <div class="pull-right">
                            <a href="{{ route('blogs.index') }}" class="btn btn-success">Back to Listing</a>
                        </div>
                    </div>
                    {!! Form::model(null, ['method' => 'post', 'route' => ['blogs.store'], 'files' => 'true']) !!}
                        <div class="box-body">
                        
                            @include('backend.blog-section.blog._form')
                            
                        </div>
                        <div class="box-footer">
                            {!! Form::submit('Save', ['class' => 'btn btn-success save']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
