<div class="form-group required {{ $errors->has('title') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}

    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required' ]) !!}

    @if ($errors->has('title'))
        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('feature_icon') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('feature_icon', 'Liner Icon', ['class' => 'control-label']) !!}
    <b>
        (View this link to pick the icon <a href="https://linearicons.com/free" target="__blank">Link</a> and copy it.)
    </b>
    {!! Form::text('feature_icon', null, ['class' => 'form-control', 'required' => 'required' ]) !!}

    @if ($errors->has('feature_icon'))
        <span class="help-block">
            <strong>{{ $errors->first('feature_icon') }}</strong>
        </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('description') ? ' has-error' : '' }} clearfix">
    {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}

    {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}

    @if ($errors->has('description'))
        <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
</div>
