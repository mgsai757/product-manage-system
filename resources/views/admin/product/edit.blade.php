@extends('admin.layouts.master')
@section('title','Category List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row">
            <div class="col-3 offset-7 mb-2">
                @if(session('updateSuccess'))
                <div class="">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-check"></i> {{session('updateSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                </div>
                @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-3">
                                {{-- <a href="{{route('product#list')}}"> --}}
                                    <i class="fa-solid fa-left-long text-dark" onclick="history.back()"></i>
                                {{-- </a> --}}
                            </div>
                            <div class="card-title">
                                {{-- <h3 class="text-center title-2">Pizza Details</h3> --}}
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-1 h-50 ">

                                        <img src="{{ asset('storage/'. $pizza->image) }}" alt="John Doe" />

                                </div>
                                <div class="col-8 ">
                                    <div class="my-3 btn btn-danger text-white d-block w-50 text-center fs-5">{{$pizza->name}}</div>
                                    <span class="my-3 btn btn-dark text-white"><i class="fa-solid fs-5 fa-money-bill-wave me-2"></i>{{$pizza->price}} kyats</span>
                                    <span class="my-3 btn btn-dark text-white"><i class="fa-solid fs-5 fa-clock me-2"></i></i>{{$pizza->waiting_time}}</span>
                                    <span class="my-3 btn btn-dark text-white"><i class="fa-solid fs-5 fa-eye me-2"></i>{{$pizza->view_count}}</span>
                                    <span class="my-3 btn btn-dark text-white"><i class="fa-solid fa-coins me-2"></i>{{$pizza->category_name}}</span>
                                    <span class="my-3 btn btn-dark text-white"><i class="fa-solid fs-5 fa-user-clock me-2"></i>{{$pizza->created_at->format('j-F-Y')}}</span>
                                    <div class="my-3"><i class="fa-solid fa-file-lines me-2"></i>Details</div>
                                    <div class="">{{$pizza->description}}</div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
