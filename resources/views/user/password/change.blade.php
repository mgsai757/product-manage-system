
@extends('user.layouts.master')
@section('content')
    <div class="row">
        <div class="col-6 offset-3 ">

                <!-- MAIN CONTENT-->
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h3 class="text-center title-2">Change Password</h3>
                                        </div>
                                        <hr>
                                        <form action="{{ route('user#changePassword') }}" method="post" novalidate="novalidate">
                                            @csrf
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Old Password</label>
                                                <input id="cc-pament" name="oldPassword"  type="password" class="form-control @if (session('notMatch')) is-invalid @endif @error('oldPassword') is-invalid @enderror mb-2" aria-required="true" aria-invalid="false" placeholder="Enter Old Password...">
                                                @error('oldPassword')
                                                    <div class="is-invalid">
                                                        {{$message}}
                                                    </div>
                                                @enderror
                                                @if (session('notMatch'))
                                                    <div class="is-invalid">
                                                        {{session('notMatch')}}
                                                    </div>

                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">New Password</label>
                                                <input id="cc-pament" name="newPassword"  type="password" class="form-control @error('newPassword') is-invalid @enderror mb-2" aria-required="true" aria-invalid="false" placeholder="Enter New Password...">
                                                @error('newPassword')
                                                    <div class="is-invalid">
                                                        {{$message}}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Confirm Password</label>
                                                <input id="cc-pament" name="confirmPassword"  type="password" class="form-control @error('confirmPassword') is-invalid @enderror mb-2" aria-required="true" aria-invalid="false" placeholder="Enter Confirm Password...">
                                                @error('confirmPassword')
                                                    <div class="is-invalid">
                                                        {{$message}}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div>
                                                <button id="payment-button" type="submit" class="btn btn-lg bg-dark text-white btn-block">
                                                    <i class="fa-solid fa-key me-2"></i>
                                                    <span id="payment-button-amount">Change Password</span>
                                                    {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}

                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MAIN CONTENT-->
        </div>
    </div>
@endsection
