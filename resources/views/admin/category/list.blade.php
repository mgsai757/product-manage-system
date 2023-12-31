@extends('admin.layouts.master')
@section('title','POS')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Category List</h2>

                            </div>
                        </div>

                    </div>
                    @if(session('createSuccess'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-check"></i> {{session('createSuccess')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                    </div>
                    @endif
                    @if(session('deleteSuccess'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-xmark"></i> {{session('deleteSuccess')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key: <span class="text-danger"> {{request('key')}}</span> </h4>
                        </div>
                        <div class="col-3 offset-9">
                            <form action="{{route('category#list')}}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search...." value="{{request('key')}}">
                                    <button class="btn btn-dark text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5"><h3>Total - ({{$categories->total()}})</h3></div>
                    </div>
                    <div class="table-data__tool-right float-end">
                        <a href="{{route('category#createPage')}}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="fa-solid fa-plus"></i>Add Category
                            </button>
                        </a>

                    </div>
                    @if(count($categories)!=0)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                               <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Created Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($categories as $category)
                                <tr class="tr-shadow">
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->created_at->format('j-F-Y')}}</td>
                                    <td>
                                        <div class="table-data-feature">
                                            {{-- <button class="item" data-toggle="tooltip" data-placement="top" title="Send">
                                                <i class="zmdi zmdi-mail-send"></i>
                                            </button> --}}
                                            <a href="{{route('category#edit',$category->id)}}">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>
                                            </a>
                                            <a href="{{route('category#delete',$category->id)}}">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </a>
                                            {{-- <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                                <i class="zmdi zmdi-more"></i>
                                            </button> --}}
                                        </div>
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{-- {{$categories ->links()}} --}}
                            {{$categories->appends(request()->query())->links()}}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                    @else
                        <h4 class="text-secondary text-center mt-5">There is no Category Here!</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
