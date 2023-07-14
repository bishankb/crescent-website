@extends('layouts.backend')

@section('title')
  Category
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
            <h3 class="box-title">Categories Table</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="table-control" class="table table-bordered table-striped">
                <thead>
                  <a class="btn btn-default add-button" href="{{route('categories.create')}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
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
                              <a href="{{ route('categories.index') }}">
                                  All
                              </a>
                          </li>
                          <li>
                            <a href="{{ route('categories.index', ['filter_by' => 'status', 'status' => 'Active']) }}">
                              Active
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('categories.index', ['filter_by' => 'status', 'status' => 'Inactive']) }}">
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
                              <a href="{{ route('categories.index') }}">
                                Without Deleted
                              </a>
                          </li>
                          <li>
                            <a href="{{ route('categories.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']) }}">
                              Only Deleted
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('categories.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'All']) }}">
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
                  @foreach($categories as $category)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$category->title}}</td>
                      <td>{{$category->createdBy['name']}}</td>
                      <td>{{$category->updatedBy['name']}}</td>
                      <td class="text-center">
                        <label class="switch">
                          <input type="checkbox" class="changeStatus{{$category->id}}" @if($category->status == 1) checked @endif>
                          <span class="slider round"></span>
                        </label>
                      </td>
                      <td class="text-center">
                        <a class="btn btn-default action-button" href="{{ route('categories.edit', $category->id) }}" data-tooltip="Edit"><i class="fa fa fa-edit"></i></a>
                        @if($category->deleted_at == null)
                          <button class="btn btn-default action-button" data-toggle="modal" data-target="#delete-modal{{$category->id}}"><i class="fa fa-trash"></i></button>
                          
                        @else
                          <button class="btn btn-default action-button" data-toggle="modal" data-target="#restore-modal{{$category->id}}"><i class="fa fa-recycle"></i></button>
                          
                          <button class="btn btn-default action-button" data-toggle="modal" data-target="#force-delete-modal{{$category->id}}"><i class="fa fa-trash" style="color: red"></i></button>
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
    @foreach($categories as $category)
      <form action="{{ route('categories.destroy', $category->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        {{method_field('DELETE')}}
        <div class="modal fade" id="delete-modal{{$category->id}}" role="dialog">
          @include('backend.partials.delete-modal')
        </div>
      </form>

      <form action="{{ route('categories.restore', $category->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        <div class="modal fade" id="restore-modal{{$category->id}}" role="dialog">
          @include('backend.partials.restore-modal')
        </div>
      </form>

      <form action="{{ route('categories.forceDestroy', $category->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        {{method_field('DELETE')}}
        <div class="modal fade" id="force-delete-modal{{$category->id}}" role="dialog">
          @include('backend.partials.force-delete-modal')
        </div>
      </form>
    @endforeach
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function(){
      @foreach($categories as $category)
        $('.changeStatus'+'{{$category->id}}').click(function () {
          var categoryId = {{$category->id}};
          var val = $(this).prop('checked') == false ? 0 : 1;
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : "{{route('categories.changeStatus', '')}}/"+categoryId,
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