
@extends('user.layouts.master')
@section('content')
{{-- Main Content  --}}
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-8 offset-2 ">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Contact Us</h3>
                        </div>
                        <hr>

                        <form action="{{ route('user#contact')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-center">

                                <div class="col-6 mt-4">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name"  type="text" value="{{ old('name',Auth::user()->name)}}" class="form-control @if (session('notMatch')) is-invalid @endif @error('name') is-invalid @enderror mb-2" aria-required="true" aria-invalid="false" placeholder="Enter Admin Name...">
                                        @error('name')
                                            <div class="is-invalid">
                                                {{$message}}
                                            </div>
                                        @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email"  type="email" value="{{ old('email',Auth::user()->email)}}" class="form-control @if (session('notMatch')) is-invalid @endif @error('email') is-invalid @enderror mb-2" aria-required="true" aria-invalid="false" placeholder="Enter Admin Email...">
                                        @error('email')
                                            <div class="is-invalid">
                                                {{$message}}
                                            </div>
                                        @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="phone"  type="number" value="{{ old('phone',Auth::user()->phone)}}" class="form-control @if (session('notMatch')) is-invalid @endif @error('phone') is-invalid @enderror mb-2" aria-required="true" aria-invalid="false" placeholder="09xxxxxxxx">
                                        @error('phone')
                                            <div class="is-invalid">
                                                {{$message}}
                                            </div>
                                        @enderror

                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Message</label>
                                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="" cols="30" rows="10" placeholder="Enter Message..."></textarea>
                                        @error('message')
                                            <div class="is-invalid">
                                                {{$message}}
                                            </div>
                                        @enderror

                                    </div>
                                    <div class="mt-3">
                                        <button class="btn bg-dark text-white col-12" type="submit">
                                            Send <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>



                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Main Content  --}}
@endsection
