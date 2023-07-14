@extends('layouts.backend')

@section('title')
    PhoneBook
@endsection

@section('backend-style')
  <style>
    #sms-success-alert{
      display: none;
    }
    #message-error {
      color: #dd4b39;
    }
  </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="alert alert-success" id="sms-success-alert">
        </div>
        <div class="row">
            <div class="col-md-11">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Send Bulk Sms</h3>
                        <div class="pull-right">
                            <a href="{{ route('phonebooks.index') }}" class="btn btn-success">Back to Listing</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                          <div class="col-md-12">
                            <form id="smsForm">
                              <div class="form-group">
                                  {!! Form::label('message', 'Message', ['class' => 'control-label']) !!}

                                  <label class="control-label" for="message">Message</label>
                                  <textarea class="form-control" name="message" placeholder="Messege" minlength="5" value="{{ old('message') }}" rows="3"></textarea>
                                  <span class="help-block">
                                      <strong id="messageError"></strong>
                                  </span>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <b class="panel-title">
                              Phone Numbers
                            </b>
                          </div>
                          <div class="panel-body">
                            @forelse($phones as $phone)
                              <div class="col-md-3">
                                <div class="checkbox text-capitalize">
                                  <label>
                                    <input type="checkbox" name="phone[]" class="phone" value="{{$phone}}">
                                    {{ $phone }}
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
                </div>
            </div>
        </div>
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
      $('.phone').prop('checked', true);

      if(localStorage.getItem("sms_success"))
      {
        $('#sms-success-alert').show();
        $('#sms-success-alert').append(localStorage.getItem("sms_success"));
        localStorage.clear();
      }

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
    });
  </script>
@endsection
