@extends('layouts.backend')

@section('title')
  BulkSms
@endsection

@section('backend-style')
  <style>
    .add-button {
      margin-bottom: 0;
      margin-left: 20px;
      margin-right: 10px;
    }
    .button-group {
      margin-bottom: 15px;
    }
    #delete-success-alert, #sms-success-alert,  #phone-save-alert{
      display: none;
    }
    #message-error {
      color: #dd4b39;
    }
  </style>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="alert alert-success" id="phone-save-alert">
    </div>
    <div class="alert alert-success" id="sms-success-alert">
    </div>
    <div class="alert alert-danger" id="delete-success-alert">
    </div>
    <div class="row">
      <div class="col-md-11">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Send BulkSms</h3>
          </div>
          <form id="smsForm">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                      {!! Form::label('message', 'Message', ['class' => 'control-label']) !!}

                      <label class="control-label" for="message">Message</label>
                      <textarea class="form-control" name="message" placeholder="Messege" minlength="5" value="{{ old('message') }}" rows="3"></textarea>
                      <span class="help-block">
                          <strong id="messageError"></strong>
                      </span>
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <b class="panel-title">
                    Phone Numbers
                  </b>
                  <span class="button-group">
                    <a title="Add Numbers" class="btn btn-success add-button" href="{{route('bulksms.create')}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    <button title="Delete Numbers" class="btn btn-danger action-button" id="delete-phone"><i class="fa fa-trash"></i></button> 
                  </span>
                </div>
                <div class="panel-body">
                  @forelse($phones as $phone)
                    <div class="col-md-3">
                      <div class="checkbox text-capitalize">
                        <label>
                          <input type="checkbox" name="phone[]" class="phone" value="{{$phone->phone}}">
                          {{ $phone->phone }}
                        </label>
                      </div>
                    </div>
                  @empty
                    <h5>No Numbers Added Yet</h5>
                  @endforelse
                </div>
              </div>
              <span class="help-block">
                    <strong id="phoneError"></strong>
                </span>
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-primary" id="send-sms">Send</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @foreach($phones as $phone)
      <form action="{{ route('bulksms.destroy', $phone->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        {{method_field('DELETE')}}
        <div class="modal fade" id="delete-modal" role="dialog">
          @include('backend.partials.delete-modal')
        </div>
      </form>
    @endforeach
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $("#smsForm").validate();

    function validate (phones, message) {
      if(phones.length == 0) {
        $('#phoneError').append('Please Select atleast one number');
        $("#phoneError").show();
        setTimeout(function(){
           $("#phoneError").delay(4000).empty();
        }, 3500);
      }
      if(message == '') {
          $('#messageError').append('The message field is required');
          $("#messageError").show();
          setTimeout(function(){
             $("#messageError").delay(4000).empty();
          }, 3500);
      }
    }

    $(document).ready(function(){
      if(localStorage.getItem("phone_save"))
      {
        $('#phone-save-alert').show();
        $('#phone-save-alert').append(localStorage.getItem("phone_save"));
        localStorage.clear();
      }

      if(localStorage.getItem("sms_success"))
      {
        $('#sms-success-alert').show();
        $('#sms-success-alert').append(localStorage.getItem("sms_success"));
        localStorage.clear();
      }

      if(localStorage.getItem("delete_success"))
      {
        $('#delete-success-alert').show();
        $('#delete-success-alert').append(localStorage.getItem("delete_success"));
        localStorage.clear();
      }
      @foreach($phones as $phone)
        $('.selectPhone'+'{{$phone->id}}').click(function () {
          var phoneId = {{$phone->id}};
          var val = $(this).prop('checked') == false ? 0 : 1;
        });
      @endforeach

      $('#send-sms').click(function() {
        var phones = [];
        $('.phone:checked').each(function(){
          phones.push($(this).val());
        });
        var message = $('textarea[name=message]').val();
        validate(phones, message);
        if (phones.length > 0 && message) {
          var formData = {
            message      : message,
            phoneNumbers : phones
          }
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : "{{route('bulksms.massSendMessage')}}",
            data     : formData,
            success: function(data){
              if (data.success) {
                localStorage.setItem("sms_success", "Message sent successfully")
                window.location.reload(); 
              }
            },
            error: function(data){
              if (data.error) {
                alert(data.error);
              }
            },
          });
        }
      });

      $('#delete-phone').click(function()  {
        if (confirm('Are you sure you want to delete this data')) {
          var phones = [];
          $('.phone:checked').each(function(){
            phones.push($(this).val());
          });
          if (phones.length > 0) {
            $.ajax({
              type     : "POST",
              headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              url      : "{{route('bulksms.massDestroy')}}",
              data     : {phones: phones},
              success: function(data){
                if (data.success) {
                  localStorage.setItem("delete_success", data.success)
                  window.location.reload(); 
                }
              },
              error: function(data){
                if (data.error) {
                  alert(data.error);
                }
              },
            });
          }
        } else {
          event.preventDefault();
        }
      });
    });
  </script>
@endsection