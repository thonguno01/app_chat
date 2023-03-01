@extends('layouts.app')
@section('title', 'Xác Thực Tài Khoản')
@section('content')

    <div class="container  d-flex justify-content-center align-items-center " style="height: 650px">
        <div class="position-relative row">
            <form action="/email-verify/{{ $info->id }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('errorOTP'))
                    <div class="alert alert-danger">
                        <p>{{ session('errorOTP') }}</p>
                    </div>
                @endif
                <div class="card p-2 text-center">
                    <h6>Xác thực Tài Khoản</h6>
                    <div> <span>Mã OTP được gừi về mail:</span> <small>{{ $info->email }}</small> </div>
                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                        <input class="m-2 text-center form-control rounded" type="text" id="first" name="first"
                            maxlength="1" />
                        <input class="m-2 text-center form-control rounded" type="text" id="second" name="second"
                            maxlength="1" />
                        <input class="m-2 text-center form-control rounded" type="text" id="third" name="third"
                            maxlength="1" />
                        <input class="m-2 text-center form-control rounded" type="text" id="fourth" name="fourth"
                            maxlength="1" />
                        <input class="m-2 text-center form-control rounded" type="text" id="fifth" name="fifth"
                            maxlength="1" />
                        <input class="m-2 text-center form-control rounded" type="text" id="sixth" name="sixth"
                            maxlength="1" />
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-danger px-4 validate" name="verify">Xác Thực</button>
                    </div>
                </div>

            </form>
            <div class="card-2">
                <div class="content d-flex justify-content-center align-items-center"> <span>Didn't get the code</span> <a
                        href="#" class="text-decoration-none ms-3">Resend(1/3)</a> </div>
            </div>
        </div>
    </div>
@endsection
