@extends('admin.layouts.master')
@section('title', 'Order List')

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
                            <h3>Total -(<span class="count">{{ count($order) }}</span>)</h3>
                        </div>
                    </div>
                    <form action="{{route('admin#changeStatus')}}" method="post">
                        @csrf
                        <div class="d-flex my-3">
                            <label for="" class="mt-2 me-4">Order Status</label>
                            <select id="statusChange" name="orderStatus" class="form-control col-2">
                                <option value="">All</option>
                                <option value="0" @if(request('orderStatus') == '0') selected @endif>Pending</option>
                                <option value="1" @if(request('orderStatus') =='1') selected @endif>Accept</option>
                                <option value="2" @if(request('orderStatus') =='2') selected @endif>Reject</option>
                            </select>
                            <button class="btn btn-sm bg-dark text-white" type="submit">Search</button>
                        </div>
                    </form>
                    @if (count($order) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Amount</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody id="dataList">

                                    @foreach ($order as $o)
                                        <tr class="tr-shadow">
                                            <input type="hidden" name="" class="orderId" value="{{ $o->id}}">
                                            <td class="">{{ $o->user_id }}</td>
                                            <td class="">{{ $o->user_name }}</td>
                                            <td class="">{{ $o->created_at->format('F-j-Y') }}</td>
                                            <td class="">
                                                <a href="{{route('admin#listInfo',$o->order_code)}}" class="text-primary" style="text-decoration:none">
                                                    {{ $o->order_code }}
                                                </a>
                                            </td>
                                            <td >{{ $o->total_price }} kyats</td>
                                            <td class="">
                                                <select  class="form-control changeStatus" >
                                                    <option value="0"
                                                        @if ($o->status == 0) selected @endif>Pending</option>
                                                    <option value="1"
                                                        @if ($o->status == 1) selected @endif>Accept</option>
                                                    <option value="2"
                                                        @if ($o->status == 2) selected @endif>Reject</option>
                                                </select>
                                            </td>
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

@section('scriptSection')
    <script>
        $(document).ready(function() {
            // $('#orderStatus').change(function() {
            //     $status = $('#orderStatus').val();
            //     // console.log($status);
            //     $.ajax({
            //         type: 'get',
            //         url: 'http://localhost:8000/order/ajax/status',
            //         data: {
            //             'status': $status
            //         },
            //         dataType: 'json',
            //         success: function(response) {

            //             //append

            //             $list = '';
            //             for ($i = 0; $i < response.length; $i++) {
            //                 $dbDate = new Date(response[$i].created_at);
            //                 $months = ['January', 'February', 'March', 'April', 'May', 'June',
            //                     'July', 'August', 'September', 'October', 'November',
            //                     'December'
            //                 ];
            //                 $finalDate = $months[$dbDate.getMonth()] + "-" + $dbDate.getDate() +
            //                     "-" + $dbDate.getFullYear();

            //                 if (response[$i].status == 0) {
            //                     $statusMessage = `<select name="status" class="form-control " id="statusChange">
            //                                 <option value="0" selected>Pending</option>
            //                                 <option value="1">Accept</option>
            //                                 <option value="2" >Reject</option>
            //                             </select>`;
            //                 } else if (response[$i].status == 1) {
            //                     $statusMessage = `<select name="status" class="form-control " id="statusChange">
            //                                 <option value="0" >Pending</option>
            //                                 <option value="1" selected>Accept</option>
            //                                 <option value="2" >Reject</option>
            //                             </select>`;
            //                 } else if (response[$i].status == 2) {
            //                     $statusMessage = `<select name="status" class="form-control " id="statusChange">
            //                                 <option value="0" >Pending</option>
            //                                 <option value="1">Accept</option>
            //                                 <option value="2" selected>Reject</option>
            //                             </select>`;
            //                 }


            //                 $list += `<tr class="tr-shadow">

            //                         <td class="">${response[$i].user_id}|| ${response[$i].id}</td>
            //                         <td class="">${response[$i].user_name}</td>
            //                         <td class="">${$finalDate}</td>
            //                         <td class="">${response[$i].order_code}</td>
            //                         <td class="">${response[$i].total_price} kyats</td>
            //                         <td >${$statusMessage}</td>
            //                     </tr>`;
            //             }
            //             $('.count').html(response.length);
            //             $('#dataList').html($list);

            //         }


            //     })
            // })

            $('.changeStatus').change(function(){
                // console.log('change');
                $status = $(this).val();
                $parentNode = $(this).parents('tr');
                $orderId = $parentNode.find('.orderId').val();
                $data ={
                    'status' : $status,
                    'orderId' : $orderId
                };
                // console.log($data);

                $.ajax({
                    type: 'get',
                    url :  'http://localhost:8000/order/ajax/change/status' ,
                    data : $data,
                    dataType: 'json',

                })
                window.location.href ='http://localhost:8000/order/list';

            })
        })
    </script>

@endsection
