@extends('layouts.backend')

@section('title')
    Contact Us
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Contact Us Detail</h3>
                    </div>
                    @isset($contact_us)
                        {!! Form::model($contact_us, ['method' => 'post', 'route' => 'contact-us.update']) !!}
                    @else
                        {!! Form::model(null, ['method' => 'post', 'route' => 'contact-us.update']) !!}
                    @endisset
                        <div class="box-body">
                        
                            @include('backend.contact-us._form')
                            
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
