@extends('admin.layouts.master')
@section('title','Category List')

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
                                <h2 class="title-1">User List</h2>

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
                    {{-- <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key: <span class="text-danger"> {{request('key')}}</span> </h4>
                        </div>
                        <div class="col-3 offset-9">
                            <form action="{{route('admin#list')}}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search...." value="{{request('key')}}">
                                    <button class="btn btn-dark text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-5"><h3>Total -({{ $user->total() }}) </h3></div>

                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                               <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>

                               @foreach ($user as $a)
                                <tr class="tr-shadow" >

                                    <td class="col-2" >
                                        @if ($a->image == null)
                                            @if ($a->gender == 'male')
                                                <img src="{{ asset('image/default-user.png' ) }}" class="img-thumbnail shadow-sm" alt="">
                                            @else
                                                <img src="{{ asset('image/female_default.jpg' ) }}" class="img-thumbnail shadow-sm" alt="">

                                            @endif
                                        @else
                                            <img src="{{ asset('storage/'. $a->image ) }}" class="img-thumbnail shadow-sm" alt=""></td>
                                        @endif

                                    </td>
                                    <td>{{$a->name}}<input type="hidden" name="" id="userId" value="{{$a->id}}"></td>
                                    <td>{{$a->email}}</td>
                                    <td>{{$a->gender}} | {{$a->id}}</td>
                                    <td>{{$a->phone}}</td>
                                    <td>{{$a->address}}</td>
                                    <td>
                                        <div class="table-data-feature">
                                           @if (Auth::user()->id == $a->id)

                                           @else
                                                <a href="{{route('admin#changeRole',$a->id)}}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Change Role">
                                                        <i class="fa-solid fa-user-minus me-2"></i>
                                                    </button>
                                                </a>
                                                <a href="{{route('admin#delete',$a->id)}}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>

                                           @endif

                                        </div>
                                    </td>
                                    <td class="col-2">
                                        <select  class="form-control changeStatus" >
                                            <option value="admin" @if ($a->role == 'admin') selected @endif>Admin</option>
                                            <option value="user" @if ($a->role == 'user') selected @endif>User</option>
                                        </select>
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{$user ->links()}}
                            {{-- {{$admin->appends(request()->query())->links()}} --}}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->

                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
@section('scriptSection')
<script>
    $(document).ready(function(){
        $('.changeStatus').change(function(){
            $status = $(this).val();
            $parentNode = $(this).parents('tr');
            $userId = $parentNode.find('#userId').val();
            $data ={
                    'role' : $status,
                    'userId' : $userId
                };
                console.log($data);
            $.ajax({
                type: 'get',
                url :  'http://localhost:8000/admin/change/userRole' ,
                data : $data,
                dataType: 'json',
                success: function(response){
                    console.log('success update')
                }

                })
                window.location.href ='http://localhost:8000/admin/userList';


        })
    });
</script>

@endsection
