<div class="form-group required {{ $errors->has('title') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}

    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required' ]) !!}

    @if ($errors->has('title'))
        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('status') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
    <div>
        <label class="switch">
            @if(isset($category->status))
                <input type="checkbox" name="status" @if($category->status == 1) checked @endif>
            @else
                <input type="checkbox" name="status" checked>
            @endif
            <span class="slider round"></span>
        </label>
    </div>
    
    @if ($errors->has('status'))
        <span class="help-block">
            <strong>{{ $errors->first('status') }}</strong>
        </span>
    @endif
</div>
