<div class="form-group required {{ $errors->has('title') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}

    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required' ]) !!}

    @if ($errors->has('title'))
        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('category') ? ' has-error' : '' }} clearfix">
    {!! Form::label('category', 'Category', ['class' => 'control-label']) !!}

    <select name = "category" class="custom-select form-control" style="width: 100%">
        <option></option>
        @foreach($categories as $category)
            @if(isset($blog->category_id))
                <option value = "{{ $category->title }}" @if($blog->category_id == $category->id) selected @endif>
                    {{$category->title}}
                </option>
            @elseif(old('category') != null)
                <option value = "{{ $category->title }}" @if($category->title == old('category')) selected @endif>
                    {{$category->title}}
                </option>
            @else
                <option value = "{{ $category->title }}">
                    {{$category->title}}
                </option>
            @endif
        @endforeach
    </select>

    @if ($errors->has('category'))
        <span class="help-block">
            <strong>{{ $errors->first('category') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('tags[]') ? ' has-error' : '' }} clearfix">
    {!! Form::label('tags[]', 'Tags', ['class' => 'control-label']) !!}

    <select name = "tags[]" class="custom-select form-control" style="width: 100%" multiple>
        @foreach($tags as $tag)
            @if(isset($blog))
                <option value = "{{ $tag->title }}" @if(in_array($tag->id,$blog->tagsIds())) selected @endif>
                    {{$tag->title}}
                </option>
            @elseif(old('tags') != null)
                <option value = "{{ $tag->title }}" @if(in_array($tag->title, old('tags'))) selected @endif>
                    {{$tag->title}}
                </option>
            @else
                <option value = "{{ $tag->title }}">
                    {{$tag->title}}
                </option>
            @endif
        @endforeach
    </select>

    @if ($errors->has('tags[]'))
        <span class="help-block">
            <strong>{{ $errors->first('tags[]') }}</strong>
        </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('description') ? ' has-error' : '' }} clearfix">
    {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}

    {!! Form::textarea('description', null, ['class' => 'form-control custom-textarea', 'required' => 'required']) !!}

    @if ($errors->has('description'))
        <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
</div>

<div class="form-group{{ $errors->has('blog_image') ? ' has-error' : '' }} clearfix">
    {!! Form::label('blog_image', 'Image', ['class' => 'control-label']) !!}
    @if(isset($blog->image))
        <div class="show-image">  
            <img class="custom-thumbnail selected-img" src="@if(isset($blog->image->filename)) /storage/media/blog/{{$blog->image->filename}} @endif" class="custom-thumbnail">

            <button type="button" class="btn btn-xs btn-delete-image" onclick="deleteImage({{ $blog->id }})">
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
    {!! Form::file('blog_image', ['class' => 'form-control', 'id' => 'input_image', 'accept' => 'image/*']) !!}

    @if ($errors->has('blog_image'))
        <span class="help-block">
        <strong>{{ $errors->first('blog_image') }}</strong>
    </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('status') ? ' has-error' : '' }} clearfix ">
    {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
    <div>
        <label class="switch">
            @if(isset($blog->status))
                <input type="checkbox" name="status" @if($blog->status == 1) checked @endif>
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


