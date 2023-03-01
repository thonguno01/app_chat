<head>
    <div class="container">
        <div class="wrap-header ">
            <div class="header-right">
                <div class="logo">
                    <a href="/">
                        <img class="bg-dark" src="{{ asset('asset/images/logo.png') }}" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="header-left">
                @if (session()->get('isLogin') == false)
                    <div class="btn-login ">
                        <div class="login btn mr-2 bg-secondary">
                            <a href="/login" class="text-light">Đăng nhập </a>
                        </div>
                        <div class="register btn bg-primary p-2 ">
                            <a href="/register" class="text-white">Đăng ký</a>
                        </div>
                    </div>
                @else
                    <div class="head-avatar">
                        <img src="{{ asset('asset/images/avata.png') }}" alt="avata" class="avatar">
                    </div>
                    <div class="header-info">
                        <span class="full-name">{{ session()->get('name') }}</span>
                        <nav class="menu">
                            <ul>
                                <li>
                                    <a href="">Trang cá nhân </a>
                                </li>
                                <li>
                                    <a href="/chat">Tin nhắn </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}">Đăng xuất </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</head>
