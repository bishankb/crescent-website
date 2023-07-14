<div class="bulksms">
    <div class="form-group{{ $errors->has('phones.*') ? ' has-error' : '' }} clearfix ">
        {!! Form::label('phones', 'Phone  Number', ['class' => 'col-md-4 control-label']) !!}

        <div class="col-md-6">
            {!! Form::text('phones[]', null, ['class' => 'form-control phones' ]) !!}

            <span class="help-block">
                <strong class="phoneError"></strong>
            </span>
        </div>
        <button type="button" class="btn btn-default"  id="remove-btn" onclick="remove_field()">Remove</button>
    </div>
</div>    

<div>
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <button  type="button" onclick="javascript:add_field()" class="btn btn-default">Add</button>
    </div>
    <br>
</div>
