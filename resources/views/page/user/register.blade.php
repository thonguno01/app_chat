@extends('layouts.app')
@section('title', 'Đăng Ký')
@section('content')

    <div class="container-fluid">
        @if (session('errorVerify'))
            <div class="alert alert-danger">
                <p>{{ session('errorVerify') }}</p>
            </div>
        @endif
        <div class="row no-gutter">

            <div class="col-md-6 d-none d-md-flex bg-image">
                <img src="{{ asset('asset/images/anh_nen.jpg') }}" alt="">
            </div>
            <!-- The content half -->
            <div class="col-md-6 bg-light">

                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xl-7 mx-auto">
                            <h3 class="display-4">Đăng Ký</h3>
                            <form action="{{ route('register.post') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <input id="inputEmail" name="Email" type="email" placeholder="Email address"
                                        autofocus="" class="form-control rounded-pill border-0 shadow-sm px-4">

                                    @error('Email')
                                        <div class=" text-danger pt-2" style="font-size: 12px">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input id="inputPassword" name="Password" type="password" placeholder="Password"
                                        class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                    @error('Password')
                                        <div class=" text-danger pt-2" style="font-size: 12px">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input id="Password_confirmation" name="Password_confirmation" type="password"
                                        placeholder="Nhập lại Password"
                                        class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                    @error('Password_confirmation')
                                        <div class=" text-danger pt-2" style="font-size: 12px">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input id="inputFullname" name="Fullname" type="text" placeholder="Họ và Tên"
                                        class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                    @error('Fullname')
                                        <div class=" text-danger pt-2" style="font-size: 12px">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input id="inputTel" name="Tel" type="text" placeholder="Số điện thoại"
                                        class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                    @error('Tel')
                                        <div class=" text-danger pt-2" style="font-size: 12px">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input id="inputAddress" name="Address" type="text" placeholder="Địa chỉ"
                                        class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                    @error('Address')
                                        <div class=" text-danger pt-2" style="font-size: 12px">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" name="submit_register"
                                    class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">Sign
                                    in</button>

                            </form>
                        </div>
                    </div>
                </div><!-- End -->

            </div>
        </div><!-- End -->

    </div>
    </div>
@endsection
