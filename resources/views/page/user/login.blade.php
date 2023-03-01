@extends('layouts.app')
@section('title', 'Đăng Nhập')
@section('content')
    <h1 class="text-center">Chào mừng bạn dến với website</h1>
    <div class="container mt-5">
        <form action="{{ route('login.post') }}" method="POST">
            @if (session('errorLogin'))
                <div class="w-100  row d-flex justify-content-center">
                    <div class="alert alert-danger col-md-6">
                        <p>{{ session('errorLogin') }}</p>
                    </div>

                </div>
            @endif
            @if (session('isLogin'))
                <div class="w-100  row d-flex justify-content-center">
                    <div class="alert alert-danger col-md-6">
                        <p>{{ session('isLogin') }}</p>
                    </div>

                </div>
            @endif
            @csrf
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card px-5 py-5" id="form1">
                        <div class="form-data" v-if="!submitted">
                            <div class="forms-inputs mb-4"> <span> Email </span>
                                <input autocomplete="off" type="email" v-model="email" name="email">
                                @error('email')
                                    <div class=" text-danger pt-2" style="font-size: 12px">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="forms-inputs mb-4"> <span>Mật khẩu</span>
                                <input autocomplete="off" type="password" name="pass_word">
                                @error('pass_word')
                                    <div class=" text-danger pt-2" style="font-size: 12px">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="forgot-password d-flex ">
                                <div>
                                    <input type="checkbox" id="remember_password" name="remember_pass">
                                    <label for="remember_password">Nhớ mật khẩu</label>
                                </div>
                                <a href="">Quên mật khẩu ?</a>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-dark w-100">Login</button>
                            </div>
                        </div>
                        {{-- <div class="success-data" v-else>
                            <div class="text-center d-flex flex-column"> <i class='bx bxs-badge-check'></i> <span
                                    class="text-center fs-1">You have been logged in <br> Successfully</span> </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
