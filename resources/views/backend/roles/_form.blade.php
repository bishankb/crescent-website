<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix">
            {!! Form::label('display_name', 'Display Name', ['class' => 'control-label']) !!}

            {!! Form::text('display_name', null, ['class' => 'form-control' ]) !!}

            @if ($errors->has('display_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('display_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix">
            {!! Form::label('name', 'Identifier (Used Internally)', ['class' => 'control-label']) !!}

            @isset($role->name)
                {!! Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
            @else
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            @endisset

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} clearfix">
            {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}

            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => "3" ]) !!}

            @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
