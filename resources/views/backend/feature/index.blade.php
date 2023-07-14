@extends('layouts.backend')

@section('title')
  Features
@endsection

@section('backend-style')
  <style>
    .dataTables_length {
      display: none;
    }
    .dataTables_paginate  {
      display: none;
    }
    .max-feature {
      font-size: 13px;
      color: #ed1025;
    }
  </style>
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
            <h3 class="box-title">Features Table <span class="max-feature">(Note: Max 6 items only)</span></h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="table-control" class="table table-bordered table-striped">
                <thead>
                  <div style="display: inline-flex;">
                    @can('add_features')
                      <a class="btn btn-default add-button" href="{{route('features.create')}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    @endcan
                  </div>
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($features as $feature)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$feature->title}}</td>
                      <td>{{$feature->createdBy['name']}}</td>
                      <td>{{$feature->updatedBy['name']}}</td>
                      <td class="text-center">
                        @can('edit_features')
                          <a class="btn btn-default action-button" href="{{ route('features.edit', $feature->id) }}" data-tooltip="Edit"><i class="fa fa fa-edit"></i></a>
                        @endcan
                        @can('delete_features')
                            <button class="btn btn-default action-button" data-toggle="modal" data-target="#delete-modal{{$feature->id}}"><i class="fa fa-trash"></i></button>
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
    @foreach($features as $feature)
      <form action="{{ route('features.destroy', $feature->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{method_field('DELETE')}}
        <div class="modal fade" id="delete-modal{{$feature->id}}" role="dialog">
          @include('backend.partials.delete-modal')
        </div>
      </form>
    @endforeach
  </div>
@endsection

