<div class="form-group required {{ $errors->has('title') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}

    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required' ]) !!}

    @if ($errors->has('title'))
        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
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

<div class="form-group{{ $errors->has('service_image') ? ' has-error' : '' }} clearfix">
    {!! Form::label('service_image', 'Image', ['class' => 'control-label']) !!}
    @if(isset($service->image))
        <div class="show-image">  
            <img class="custom-thumbnail selected-img" src="@if(isset($service->image->filename)) /storage/media/service/{{$service->image->filename}} @endif" class="custom-thumbnail">

            <button type="button" class="btn btn-xs btn-delete-image" onclick="deleteImage({{ $service->id }})">
                <i class="fa fa-times fa-2x"></i>
            </button>
        </div>
    @else
        <div class="image-margin"> 
            <img class="selected-img" src="">

            <button type="button" class="btn btn-xs btn-delete-image" onclick="removeImage()">
                <i class="fa fa-times fa-2x"></i>
            </button>
        </div>
    @endif
    {!! Form::file('service_image', ['class' => 'form-control', 'id' => 'input_image', 'accept' => 'image/*']) !!}

    @if ($errors->has('service_image'))
        <span class="help-block">
        <strong>{{ $errors->first('service_image') }}</strong>
    </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('status') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
    <div>
        <label class="switch">
            @if(isset($service->status))
                <input type="checkbox" name="status" @if($service->status == 1) checked @endif>
            @else
                <input type="checkbox" name="status">
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
