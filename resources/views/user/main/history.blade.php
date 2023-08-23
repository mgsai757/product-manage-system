
@extends('user.layouts.master')
@section('content')
      <!-- Cart Start -->
      <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 offset-2 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody class="align-middle"  id="dataTable">
                        @foreach ($order as $o )
                            <tr>
                                <td class="align-middle" >{{ $o->created_at->format('F-j-Y')}} </td>
                                <td class="align-middle" >{{ $o->order_code}} </td>
                                <td class="align-middle" >{{ $o->total_price}} </td>
                                <td class="align-middle" >
                                    @if ($o->status == 0)
                                        <span class="text-warning"><i class="fa-solid fa-rotate me-2"></i> Pending..</span>
                                    @elseif($o->status == 1)
                                        <span class="text-success"><i class="fa-solid fa-check me-2"></i> Success</span>
                                    @elseif($o->status == 2)
                                        <span class="text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> Reject</span>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{$order->links()}}
                </div>
            </div>
            {{-- <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotalPrice">{{ $totalPrice}} kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">3000 kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $totalPrice + 3000 }} kyats</h5>
                        </div>
                        <button class="btn btn-primary btn-block font-weight-bold my-3 py-3 "  id="orderBtn">
                            <span class="text-white">Proceed To Checkout</span>
                        </button>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <!-- Cart End -->


@endsection






