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
                        <h3 class="box-title">Edit Blog</h3>
                        <div class="pull-right">
                            <a href="{{ route('blogs.index') }}" class="btn btn-success">Back to Listing</a>
                        </div>
                    </div>
                    {!! Form::model($blog, ['method' => 'patch', 'route' => ['blogs.update', $blog->id], 'files' => 'true']) !!}
                        <div class="box-body">
                        
                            @include('backend.blog-section.blog._form')
                            
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

@section('backend-script')
    <script type="text/javascript">
        $(document).ready(function() {
            window.savedImage = $('.selected-img').attr('src');
        });

        function deleteImage(blogId)
        {
            this.selectedImage = $('.selected-img').attr('src');
            if (confirm('Are you sure you want to delete the image?')) {
                if(window.savedImage == this.selectedImage) {
                    $.ajax({
                        type     : "POST",
                        headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url      : "{{route('blogs.destroyImage', '')}}/"+blogId,
                        success: function(response){
                            if (response.success) {
                                $('.show-image').hide();
                            }
                        },
                        error: function(data){
                            alert("There was some internal error while updating the status.");
                        },
                    });
                } else {
                    $('#input_image').val('');
                    $('.show-image').hide();
                }
            }
        }
    </script>
@endsection
