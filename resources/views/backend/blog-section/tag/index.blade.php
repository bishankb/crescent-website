@extends('layouts.backend')

@section('title')
  Tags
@endsection

@section('content')
  <div class="container-fluid">
    <div class="alert alert-success" id="status-change-alert">
      Status Changed Sucessfully.
    </div>
    <div class="row">
      <div class="col-md-11">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Tags Table</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="table-control" class="table table-bordered table-striped">
                <thead>
                  <a class="btn btn-default add-button" href="{{route('tags.create')}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                  <span class="filter">
                    <label>&nbsp Filters: </label>
                    <div class="dropdown inline">
                      <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                      @if(request('status') != null)
                        {{ request('status') }}
                      @else
                        Filter by Status
                      @endif
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                          <li>
                              <a href="{{ route('tags.index') }}">
                                  All
                              </a>
                          </li>
                          <li>
                            <a href="{{ route('tags.index', ['filter_by' => 'status', 'status' => 'Active']) }}">
                              Active
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('tags.index', ['filter_by' => 'status', 'status' => 'Inactive']) }}">
                              Inactive
                            </a>
                          </li>
                      </ul>
                    </div>
                    <div class="dropdown inline">
                      <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                      @if(request('deleted-items') != null)
                        {{ request('deleted-items') }}
                      @else
                        Filter by Deleted Items
                      @endif
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                          <li>
                              <a href="{{ route('tags.index') }}">
                                Without Deleted
                              </a>
                          </li>
                          <li>
                            <a href="{{ route('tags.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']) }}">
                              Only Deleted
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('tags.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'All']) }}">
                              All
                            </a>
                          </li>
                      </ul>
                    </div>
                  </span>
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($tags as $tag)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$tag->title}}</td>
                      <td>{{$tag->createdBy['name']}}</td>
                      <td>{{$tag->updatedBy['name']}}</td>
                      <td class="text-center">
                        <label class="switch">
                          <input type="checkbox" class="changeStatus{{$tag->id}}" @if($tag->status == 1) checked @endif>
                          <span class="slider round"></span>
                        </label>
                      </td>
                      <td class="text-center">
                        <a class="btn btn-default action-button" href="{{ route('tags.edit', $tag->id) }}" data-tooltip="Edit"><i class="fa fa fa-edit"></i></a>
                        @if($tag->deleted_at == null)
                          <button class="btn btn-default action-button" data-toggle="modal" data-target="#delete-modal{{$tag->id}}"><i class="fa fa-trash"></i></button>
                          
                        @else
                          <button class="btn btn-default action-button" data-toggle="modal" data-target="#restore-modal{{$tag->id}}"><i class="fa fa-recycle"></i></button>
                          
                          <button class="btn btn-default action-button" data-toggle="modal" data-target="#force-delete-modal{{$tag->id}}"><i class="fa fa-trash" style="color: red"></i></button>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    @foreach($tags as $tag)
      <form action="{{ route('tags.destroy', $tag->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        {{method_field('DELETE')}}
        <div class="modal fade" id="delete-modal{{$tag->id}}" role="dialog">
          @include('backend.partials.delete-modal')
        </div>
      </form>

      <form action="{{ route('tags.restore', $tag->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        <div class="modal fade" id="restore-modal{{$tag->id}}" role="dialog">
          @include('backend.partials.restore-modal')
        </div>
      </form>

      <form action="{{ route('tags.forceDestroy', $tag->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        {{method_field('DELETE')}}
        <div class="modal fade" id="force-delete-modal{{$tag->id}}" role="dialog">
          @include('backend.partials.force-delete-modal')
        </div>
      </form>
    @endforeach
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function(){
      @foreach($tags as $tag)
        $('.changeStatus'+'{{$tag->id}}').click(function () {
          var tagId = {{$tag->id}};
          var val = $(this).prop('checked') == false ? 0 : 1;
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : "{{route('tags.changeStatus', '')}}/"+tagId,
            data     : {status: val},
            success: function(response){
              if (response.success) {
                $("#status-change-alert").show();
                $('#status-change-alert').delay(3000).fadeOut(1000);
              }
            },
            error: function(data){
              alert("There was some internal error while updating the status.");
              window.location.reload(); 
            },
          });
        });
      @endforeach
    });
  </script>
@endsection