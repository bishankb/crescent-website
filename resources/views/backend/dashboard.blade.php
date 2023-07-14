@extends('layouts.backend')

@section('title')
    Users
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{$totalBlog}}</h3>
                  <p>Total Blogs</p>
                </div>
                <div class="icon">
                  <i class="fa fa-book"></i>
                </div>
                <a href="{{route('blogs.index')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{$totalFeature}}</h3>
                  <p>Total Features</p>
                </div>
                <div class="icon">
                  <i class="fa fa-star"></i>
                </div>
                <a href="{{route('features.index')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$totalProduct}}</h3>
                  <p>Total Products</p>
                </div>
                <div class="icon">
                  <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="{{route('products.index')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$totalService}}</h3>
                  	<p>Total Services</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cogs"></i>
                </div>
                <a href="{{route('services.index', ['filter_by' => 'is_verifed', 'is_verifed' => '3'])}}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


    
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$totalUser}}</h3>
                  <p>Total Users</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                <a href="{{route('users.index')}}" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
