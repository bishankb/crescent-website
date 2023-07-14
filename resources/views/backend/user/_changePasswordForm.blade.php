<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('password', 'New Password', ['class' => 'control-label']) !!}

            {!! Form::password('password', ['class' => 'form-control', 'required' => 'required' ]) !!}

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('password_confirmation') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'control-label']) !!}

            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required' ]) !!}

            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
 <div class="box-footer">
    {!! Form::submit('Change', ['class' => 'btn btn-success save']) !!}
</div>