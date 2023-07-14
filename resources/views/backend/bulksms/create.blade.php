@extends('layouts.backend')

@section('title')
    BulkSms
@endsection

@section('backend-style')
    <style>
        #phone-error-alert {
          display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="alert alert-danger" id="phone-error-alert">
        </div>
        <div class="row">
            <div class="col-md-11">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Phone Numbers</h3>
                        <div class="pull-right">
                            <a href="{{ route('bulksms.index') }}" class="btn btn-success">Back to Listing</a>
                        </div>
                    </div>
                    <form>
                        <div class="box-body">
                        
                            @include('backend.bulksms._form')
                            
                        </div>
                        <div class="box-footer">
                            <button type="button" class="btn btn-success" onclick="javascript:send_field()"s>Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('backend-script')
    <script>
        $(document).ready(function () {
            var bulksms = $('#remove-btn')
            if (bulksms.length == 1) {
                $('#remove-btn').hide();
            }
        })

        function send_field() {
            event.preventDefault();
            $.ajax({
                type     : "POST",
                headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url      : "{{route('bulksms.store')}}",
                data     : $('.phones').serialize(),
                success: function(data){
                    if (data.success) {
                        localStorage.setItem("phone_save", data.success);
                        window.location.href = "{{route('bulksms.index')}}";
                    }
                    if(data.error) {
                        var phoneError = data.error;
                        $('#phone-error-alert').append(phoneError);
                        $('#phone-error-alert').show();
                        setTimeout(function(){
                            $("#phone-error-alert").delay(4000).empty();
                            $("#phone-error-alert").delay(4000).hide();
                        }, 3500);
                    }
                },
                error: function(data){
                    if (data.error) {
                        alert(data.error);
                    }
                },
            });
        }

        function add_field() {
            event.preventDefault();
            $('#remove-btn').show();
            var totalBulkSms = $('.bulksms')
            var bulksms = totalBulkSms.last();
            var bulksmsClone = bulksms.clone(false);
            bulksms[0].after(bulksmsClone[0]);
            bulksmsClone.find('.phones').val(null);
        }

        function remove_field(){
            event.preventDefault();
            $(event.target).parent().parent().remove();
            var bulksms = $('.bulksms');
            if (bulksms.length == 1) {
                $('#remove-btn').hide();
            }
        }
    </script>
@endsection

