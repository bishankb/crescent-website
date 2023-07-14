@extends('layouts.backend')

@section('title')
  User
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-11">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit User</h3>
                        <div class="pull-right">
                            <a href="{{ route('users.index') }}" class="btn btn-success">Back to Listing</a>
                        </div>
                    </div>

                    <div class="box-body" style="padding-top: 0px;">
                    
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active" id="basic-info-li"><a data-toggle="tab" href="#basic-info">Basic Information</a></li>
                            <li id="profile-li"><a id="profile-tab" data-toggle="tab" href="#profile">Profile</a></li>
                            @if(Auth::user()->id == $user->id || Auth::user()->hasRole('admin'))
                                <li id="change-password-li"><a id="change-password-tab" data-toggle="tab" href="#change-password">Change Password</a></li>
                            @endif
                        </ul>

                        <div class="tab-content" style="margin-top: 10px;">
                            <div id="basic-info" class="tab-pane fade in active">
                                {!! Form::model($user, ['method' => 'patch', 'route' => ['users.update', $user->id]]) !!}
                                     @include('backend.user._editForm')
                               {!! Form::close() !!}
                            </div>

                            <div id="profile" class="tab-pane fade">
                                @if(isset($userProfile))
                                    {!! Form::model($userProfile, ['method' => 'post', 'route' => ['users.editProfile', $user->id], 'files' => 'true']) !!}
                                @else
                                    {!! Form::model(null, ['method' => 'post', 'route' => ['users.editProfile', $user->id], 'files' => 'true']) !!}
                                @endif
                                     @include('backend.user._editProfileForm')
                               {!! Form::close() !!}
                            </div>
                            @if(Auth::user()->id == $user->id || Auth::user()->hasRole('admin'))
                                <div id="change-password" class="tab-pane fade">
                                    {!! Form::model($user, ['method' => 'post', 'route' => ['users.changePassword', $user->id]]) !!}
                                         @include('backend.user._changePasswordForm')
                                   {!! Form::close() !!}
                                </div>
                            @endif
                        </div>
                    </div>
                    
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

        function deleteImage(userId)
        {
            this.selectedImage = $('.selected-img').attr('src');
            if (confirm('Are you sure you want to delete the image?')) {
                if(window.savedImage == this.selectedImage) {
                     $.ajax({
                        type     : "POST",
                        headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url      : "{{route('users.destroyImage', '')}}/"+userId,
                        success: function(response){
                            if (response.success) {
                                
                                $('#input_image').val('');
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
