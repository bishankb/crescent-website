@extends('layouts.backend')

@section('title')
  Phone Book
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-11">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">PhoneBook Table</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="table-control" class="table table-bordered table-striped">
                <thead>
                  <div style="display: inline-flex;">
                    <a class="btn btn-default add-button" href="{{route('phonebooks.create')}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    <div class="filter">
                      <label>&nbsp Filters: </label>
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
                                <a href="{{ route('phonebooks.index') }}">
                                  Without Deleted
                                </a>
                            </li>
                            <li>
                              <a href="{{ route('phonebooks.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']) }}">
                                Only Deleted
                              </a>
                            </li>
                            <li>
                              <a href="{{ route('phonebooks.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'All']) }}">
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
                    <th>Bulk SMS</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($phonebooks as $phonebook)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td width="20%">{{$phonebook->title}}</td>
                      <td>{{$phonebook->createdBy['name']}}</td>
                      <td>{{$phonebook->updatedBy['name']}}</td>
                      <td>
                        <a href="{{ route('phonebooks.show', $phonebook->id) }}">Manage</a>
                      </td>
                      <td class="text-center">
                        <a class="btn btn-default action-button" href="{{ route('phonebooks.edit', $phonebook->id) }}"><i class="fa fa fa-edit"></i></a>
                        @if($phonebook->deleted_at == null)
                          <button class="btn btn-default action-button" data-toggle="modal" data-target="#delete-modal{{$phonebook->id}}"><i class="fa fa-trash"></i></button>
                        @else
                          <button class="btn btn-default action-button" data-toggle="modal" data-target="#restore-modal{{$phonebook->id}}"><i class="fa fa-recycle"></i></button>
                          
                          <button class="btn btn-default action-button" data-toggle="modal" data-target="#force-delete-modal{{$phonebook->id}}"><i class="fa fa-trash" style="color: red"></i></button>
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
    @foreach($phonebooks as $phonebook)
      <form action="{{ route('phonebooks.destroy', $phonebook->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        {{method_field('DELETE')}}
        <div class="modal fade" id="delete-modal{{$phonebook->id}}" role="dialog">
          @include('backend.partials.delete-modal')
        </div>
      </form>

      <form action="{{ route('phonebooks.restore', $phonebook->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        <div class="modal fade" id="restore-modal{{$phonebook->id}}" role="dialog">
          @include('backend.partials.restore-modal')
        </div>
      </form>

      <form action="{{ route('phonebooks.forceDestroy', $phonebook->id) }}" class="pull-xs-right5 card-link" method="POST">
        {{ csrf_field() }}
        {{method_field('DELETE')}}
        <div class="modal fade" id="force-delete-modal{{$phonebook->id}}" role="dialog">
          @include('backend.partials.force-delete-modal')
        </div>
      </form>
    @endforeach
  </div>
@endsection
