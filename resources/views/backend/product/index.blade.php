@extends('layouts.backend')

@section('title')
  Products
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
            <h3 class="box-title">Products Table</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="table-control" class="table table-bordered table-striped">
                <thead>
                  <div style="display: inline-flex;">
                    @can('add_products')
                      <a class="btn btn-default add-button" href="{{route('products.create')}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    @endcan
                    <div class="filter">
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
                                <a href="{{ route('products.index') }}">
                                    All
                                </a>
                            </li>
                            <li>
                              <a href="{{ route('products.index', ['filter_by' => 'status', 'status' => 'Active']) }}">
                                Active
                              </a>
                            </li>
                            <li>
                              <a href="{{ route('products.index', ['filter_by' => 'status', 'status' => 'Inactive']) }}">
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
                                <a href="{{ route('products.index') }}">
                                  Without Deleted
                                </a>
                            </li>
                            <li>
                              <a href="{{ route('products.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']) }}">
                                Only Deleted
                              </a>
                            </li>
                            <li>
                              <a href="{{ route('products.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'All']) }}">
                                All
                              </a>
                            </li>
                        </ul>
                      </div>
                    </div>
                  </div>
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
                  @foreach($products as $product)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$product->title}}</td>
                      <td>{{$product->createdBy['name']}}</td>
                      <td>{{$product->updatedBy['name']}}</td>
                      <td class="text-center">
                        <label class="switch">
                          <input type="checkbox" class="changeStatus{{$product->id}}" @if($product->status == 1) checked @endif>
                          <span class="slider round"></span>
                        </label>
                      </td>
                      <td class="text-center">
                        @can('edit_products')
                          <a class="btn btn-default action-button" href="{{ route('products.edit', $product->id) }}"><i class="fa fa fa-edit"></i></a>
                        @endcan
                        @can('delete_products')
                          @if($product->deleted_at == null)
                            <button class="btn btn-default action-button" data-toggle="modal" data-target="#delete-modal{{$product->id}}"><i class="fa fa-trash"></i></button>
                            
                          @else
                            <button class="btn btn-default action-button" data-toggle="modal" data-target="#restore-modal{{$product->id}}"><i class="fa fa-recycle"></i></button>
                            
                            <button class="btn btn-default action-button" data-toggle="modal" data-target="#force-delete-modal{{$product->id}}"><i class="fa fa-trash" style="color: red"></i></button>
                          @endif
                        @endcan
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
    @foreach($products as $product)
      <form action="{{ route('products.destroy', $product->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        {{method_field('DELETE')}}
        <div class="modal fade" id="delete-modal{{$product->id}}" role="dialog">
          @include('backend.partials.delete-modal')
        </div>
      </form>

      <form action="{{ route('products.restore', $product->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        <div class="modal fade" id="restore-modal{{$product->id}}" role="dialog">
          @include('backend.partials.restore-modal')
        </div>
      </form>

      <form action="{{ route('products.forceDestroy', $product->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        {{method_field('DELETE')}}
        <div class="modal fade" id="force-delete-modal{{$product->id}}" role="dialog">
          @include('backend.partials.force-delete-modal')
        </div>
      </form>
    @endforeach
  </div>
@endsection

@section('backend-script')
  <script type="text/javascript">
    $(document).ready(function(){
      @foreach($products as $product)
        $('.changeStatus'+'{{$product->id}}').click(function () {
          var productId = {{$product->id}};
          var val = $(this).prop('checked') == false ? 0 : 1;
          $.ajax({
            type     : "POST",
            headers  : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url      : "{{route('products.changeStatus', '')}}/"+productId,
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