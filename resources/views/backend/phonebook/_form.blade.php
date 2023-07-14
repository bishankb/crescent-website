<div class="form-group required {{ $errors->has('title') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}

    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required' ]) !!}

    @if ($errors->has('title'))
        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('description') ? ' has-error' : '' }} clearfix">
    {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}

    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}

    @if ($errors->has('description'))
        <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('phonebook_file') ? ' has-error' : '' }} clearfix">
    {!! Form::label('phonebook_file', 'File', ['class' => 'control-label']) !!}

    {!! Form::file('phonebook_file', ['class' => 'form-control', 'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, text/plain, .pdf, .docx, .doc']) !!}

    @if ($errors->has('phonebook_file'))
        <span class="help-block">
        <strong>{{ $errors->first('phonebook_file') }}</strong>
    </span>
    @endif
</div>