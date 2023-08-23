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
                                <h2 class="title-1">Contact List</h2>

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

                    <div class="row mb-4">
                        <div class="col-5"><h3>Total -({{ $message->total() }}) </h3></div>

                    </div>
                    @if(count($message)!=0)
                    <div class="table-responsive table-responsive-data2">
                        <table class=" table-data2 text-center">
                            <thead>
                               <tr>
                                    <th class="col-2">Name</th>
                                    <th class="col-2">Email</th>
                                    <th class="col-6">Message</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($message as $a)
                                <tr class="tr-shadow">
                                    <td>{{$a->name}}</td>
                                    <td>{{$a->email}}</td>
                                    <td>
                                          <textarea name="" id="" cols="50" rows="5">{{ $a->message }}</textarea>
                                    </td>

                                    <td>
                                        <div class="table-data-feature">
                                            <a href="{{route('contact#delete',$a->id)}}">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                               @endforeach

                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{$message ->links()}}
                            {{-- {{$admin->appends(request()->query())->links()}} --}}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                    @else
                        <h4 class="text-secondary text-center mt-5">There is no Message Here!</h4>
                     @endif

                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

