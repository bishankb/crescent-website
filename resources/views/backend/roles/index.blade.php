@extends('layouts.backend')

@section('title')
  Roles
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
            <h3 class="box-title">Roles Table</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="table-control" class="table table-bordered table-striped">
                <thead>
                  @can('add_roles')
                    <a class="btn btn-default add-button" href="{{route('roles.create')}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                  @endcan
                  <tr>
                    <th>#</th>
                    <th>Display Name</th>
                    <th>Identifier</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($roles as $role)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{ $role->display_name }}</td>
                      <td>{{ $role->name }}</td>
                      <td class="text-center">
                        @can('edit_roles')
                          <a class="btn btn-default action-button" href="{{ route('roles.edit', $role->id) }}" data-tooltip="Edit"><i class="fa fa fa-edit"></i></a>
                        @endcan
                        @can('delete_roles')
                          <button class="btn btn-default action-button" data-toggle="modal" data-target="#delete-modal{{$role->id}}"><i class="fa fa-trash"></i></button>
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
    @foreach($roles as $role)
      <form action="{{ route('roles.destroy', $role->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        {{method_field('DELETE')}}
        <div class="modal fade" id="delete-modal{{$role->id}}" role="dialog">
          @include('backend.partials.delete-modal')
        </div>
      </form>
    @endforeach
  </div>
@endsection