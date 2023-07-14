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

    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5', 'required' => 'required']) !!}

    @if ($errors->has('description'))
        <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('features') ? ' has-error' : '' }} clearfix">
    {!! Form::label('features', 'Feature', ['class' => 'control-label']) !!}

    {!! Form::textarea('features', null, ['class' => 'form-control custom-textarea', 'required' => 'required']) !!}

    @if ($errors->has('features'))
        <span class="help-block">
            <strong>{{ $errors->first('features') }}</strong>
        </span>
    @endif
</div>

<div class="form-group{{ $errors->has('product_image') ? ' has-error' : '' }} clearfix">
    {!! Form::label('product_image', 'Image', ['class' => 'control-label']) !!}
    @if(isset($product->image))
        <div class="show-image">  
            <img class="custom-thumbnail selected-img" src="@if(isset($product->image->filename)) /storage/media/product/{{$product->image->filename}} @endif" class="custom-thumbnail">

            <button type="button" class="btn btn-xs btn-delete-image" onclick="deleteImage({{ $product->id }})">
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
    {!! Form::file('product_image', ['class' => 'form-control', 'id' => 'input_image', 'accept' => 'image/*']) !!}

    @if ($errors->has('product_image'))
        <span class="help-block">
        <strong>{{ $errors->first('product_image') }}</strong>
    </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('status') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
    <div>
        <label class="switch">
            @if(isset($product->status))
                <input type="checkbox" name="status" @if($product->status == 1) checked @endif>
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


