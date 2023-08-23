@extends('admin.layouts.master')
@section('title', 'Category List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    {{-- <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{route('product#createPage')}}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="fa-solid fa-plus"></i>Add Pizza
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div> --}}
                    @if (session('createSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-check"></i> {{ session('createSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-2 offset-10">
                            <h3>Total -(<span class="count">{{ count($orderList) }}</span>)</h3>
                        </div>
                    </div>

                    @if (count($orderList) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <a href="{{route('admin#orderList')}}" class="text-dark" style="text-decoration:none"><i class="fa-solid fa-arrow-left-long me-2"></i> Back</a>
                            <div class="row col-6">
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h3> <i class="fa-solid fa-clipboard me-2"></i> Order Info</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col"><i class="fa-solid fa-user me-2"></i> Name</div>
                                            <div class="col">{{ strtoupper($orderList[0]->user_name) }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col"><i class="fa-solid fa-barcode me-2"></i>Order Code</div>
                                            <div class="col">{{ $orderList[0]->order_code }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col"><i class="fa-regular fa-clock me-2"></i>Order Date</div>
                                            <div class="col">{{ $orderList[0]->created_at->format('F-j-Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Order Date</th>
                                        <th>qty</th>
                                        <th>Amount</th>


                                    </tr>
                                </thead>
                                <tbody id="dataList">

                                    @foreach ($orderList as $o)
                                        <tr class="tr-shadow">
                                            <input type="hidden" name="" class="orderId" value="{{ $o->id}}">
                                            <td class="">{{ $o->id }}</td>
                                            <td class="col-2"> <img src="{{ asset('storage/'.$o->product_image) }}" alt="" class="img-thumbnail shadow-sm"> </td>
                                            <td> {{ $o->product_name }} </td>
                                            <td> {{ $o->created_at->format('F-j-Y') }}</td>
                                            <td> {{ $o->qty }} </td>
                                            <td >{{ $o->total }} kyats</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{-- {{$order->links()}} --}}
                            </div>
                        </div>
                        <!-- END DATA TABLE -->
                    @else
                        <h4 class="text-secondary text-center mt-5">There is no Orders Here!</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

