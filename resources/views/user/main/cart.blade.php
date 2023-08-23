
@extends('user.layouts.master')
@section('content')
      <!-- Cart Start -->
      <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle"  id="dataTable">
                        @foreach ($cartList as $cart)
                        <tr>
                            <td><img src="{{asset('storage/'. $cart->product_image)}}" alt="" style="width: 100px;" class="img-thumbnail shadow-sm"></td>
                            <td class="align-middle">{{ $cart->pizza_name }}
                                <input type="hidden" class="orderId" name="orderId"  value="{{$cart->id}}">
                                <input type="hidden" class="productId" name="pizzaId"  value="{{$cart->product_id}}">
                                <input type="hidden" class="userId" name="userId"  value="{{$cart->user_id}}">
                            </td>
                            <td class="align-middle" id="price">{{ $cart->pizza_price}} kyats</td>
                            {{-- <input type="hidden" name="" id="pizzaPrice" value="{{ $cart->pizza_price}}"> --}}
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" >
                                        <i class="fa fa-minus text-white"></i>
                                        </button>
                                    </div>

                                    <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{ $cart->qty }}" id="qty">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle" id="total">{{$cart->pizza_price * $cart->qty}} kyats</td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove" ><i class="fa fa-times"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
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
                        <button class="btn btn-danger btn-block font-weight-bold my-3 py-3 "  id="clearBtn">
                            <span class="text-white">Clear Cart</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->


@endsection

@section('scriptSource')
<script>
    $(document).ready(function(){
        //when + button click
        $('.btn-plus').click(function(){
            $parentNode = $(this).parents('tr');
            $price = Number($parentNode.find('#price').text().replace('kyats',''));
            $qty = Number($parentNode.find('#qty').val());
            // console.log($price);
            $total = $price * $qty;
            $parentNode.find('#total').html($total + " kyats");

            //total summary
            summaryCalculation();


        });
        $('.btn-minus').click(function(){
            //when - button click
            $parentNode = $(this).parents('tr');
            $price = Number($parentNode.find('#price').text().replace('kyats',''));
            $qty = Number($parentNode.find('#qty').val());
            if($qty == 0){
                $('.btn-minus').attr('disabled');
            }
            $total = $price * $qty;
            $parentNode.find('#total').html($total + " kyats");
            summaryCalculation();
             //total summary

        });
        $('.btnRemove').click(function(){
            //when x button click
            $parentNode = $(this).parents('tr');
            $orderId = $parentNode.find('.orderId').val();
            $productId = $parentNode.find('.productId').val();
            $.ajax({
                type: 'get',
                url : 'http://localhost:8000/user/ajax/clear/current/product' ,
                data : {'productId' : $productId, 'orderId' : $orderId},
                dataType :'json',
                success : function(response){
                    window.location.href = "http://localhost:8000/user/homePage";
                }

            })
            $parentNode.remove();
            summaryCalculation();

        })

        function summaryCalculation(){
            //calculate final price for order
            $totalPrice = 0;
            $('#dataTable tr').each(function(index,row){
                $totalPrice += Number($(row).find('#total').text().replace('kyats',''));
            })
            $('#subTotalPrice').html(`${$totalPrice} kyats`) ;
            $('#finalPrice').html(`${$totalPrice + 3000 } kyats`);
        }
        $('#orderBtn').click(function(){
            $random = Math.floor(Math.random()*1000000001);
            $orderList =[];
            $('#dataTable tr').each(function(index,row){
                $orderList.push({
                    'user_id' : $(row).find('.userId').val(),
                    'product_id' : $(row).find('.productId').val(),
                    'qty' : $(row).find('#qty').val(),
                    'total' : $(row).find('#total').text().replace('kyats','')*1,
                    'order_code' : 'POS' + $random
                });
            });


            $.ajax({
                type: 'get',
                url : 'http://localhost:8000/user/ajax/order' ,
                data : Object.assign({},$orderList),
                dataType :'json',
                success : function(response){
                    if(response.status == 'true'){
                        window.location.href = "http://localhost:8000/user/homePage";
                    }
                }
            })
        });
        //when clear button click
        $('#clearBtn').click(function(){
             $('#dataTable tr').remove();
             $('#subTotalPrice').html('0 kyats');
             $('#finalPrice').html('3000 kyats');
             $.ajax({
                type: 'get',
                url : 'http://localhost:8000/user/ajax/clear/cart' ,
                dataType :'json',
                success : function(response){
                    window.location.href = "http://localhost:8000/user/homePage";
                }

            })

        });
    });
</script>

@endsection





