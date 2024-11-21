<header>
    @php $menusHtml = \App\Helpers\Helper::menus($menus); @endphp
    <!-- Header desktop -->
    <div class="container-menu-desktop">

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="#" class="logo">
                <img src="/template/images/icons/logo-01.png" alt="IMG-LOGO">
                    <!-- <h1 style="color: #000;">HealthyShapes</h1> -->
                     <img src="" alt="">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu"><a style="color: #333333" href="/">Trang Chủ</a> </li>

                        {!! $menusHtml !!}

                        <!-- <li>
                            <a href="contact.html">Liên Hệ</a>
                        </li> -->
                        <li><a href="{{ route('post') }}">Bài Viết</a></li>
                        <li><a href="{{ route('bmi-caculator') }}">Tính chỉ số BMI</a></li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    <!-- <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                         data-notify="{{ !is_null(\Session::get('carts')) ? count(\Session::get('carts')) : 0 }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div> -->

                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                    data-notify="{{ (\Session::has('carts') && count(\Session::get('carts')) > 0) ? count(\Session::get('carts')) : 0 }}">
                    <a href="{{route('carts.list')}}"><i class="zmdi zmdi-shopping-cart"></i></a>
                </div>

                <!-- User Authentication -->
                <!-- <div class="col user-auth">
                        @if (auth('user')->check())
                            <span class="row user-name">{{ auth('user')->user()->name; }}</span>
                            <a href="{{ route('user.logout') }}" class="row btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('user.login') }}" class="btn-login">Đăng nhập</a>
                        @endif
                </div> -->
                <!--  hover-->
                <!-- <div class="col user-auth">
                        @if (auth('user')->check())
                            <div class="dropdown">
                                <span class="row user-name" id="userDropdown" style="cursor: pointer;" 
                                    onmouseover="this.nextElementSibling.style.display='block'" 
                                    onmouseout="this.nextElementSibling.style.display='none'">
                                    {{ auth('user')->user()->name }}
                                </span>
                                <div class="dropdown-menu" style="display:none; position:absolute; background-color:white; border:1px solid #ccc; z-index:1000;">
                                    <a href="/" class="dropdown-item">Tài khoản của tôi</a>
                                    <a href="/" class="dropdown-item">Đơn mua</a>
                                    <a href="{{ route('user.logout') }}" class="dropdown-item" 
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
                                </div>
                            </div>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('user.login') }}" class="btn-login">Đăng nhập</a>
                        @endif
                </div> -->


                <div class="col user-auth">
                    @if (Auth::guard('user')->check())
                        <span class="row user-name" onclick="toggleMenu()"> {{ auth('user')->user()->name; }} </span>
                        <div id="account-menu" class="account-menu" style="display: none;">
                            <ul>
                                <li><a href="{{route('user.account')}}">Tài khoản của tôi</a></li>
                                <li><a href="{{ route('user.change-password', ['id' => auth('user')->user()->id]) }}">Đổi mật khẩu</a></li>
                                <li><a href="{{ route('user.orders') }}">Đơn mua</a></li>
                                <li><a href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
                            </ul>
                        </div>
                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('user.login') }}" class="btn-login">Đăng nhập</a>
                    @endif
                </div>

<!--  -->
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="/template/images/icons/logo-01.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="{{ !is_null(\Session::get('carts')) ? count(\Session::get('carts')) : 0 }}">
                <a href="{{route('carts.list')}}"><i class="zmdi zmdi-shopping-cart"></i></a>
            </div>
        </div>

        
        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">
            <li class="active-menu"><a href="/">Trang Chủ</a> </li>

            {!! $menusHtml !!}

            <!-- <li>
                <a href="contact.html">Liên Hệ</a>
            </li> -->
            <li><a href="{{ route('post') }}">Bài Viết</a></li>
            <li><a href="{{ route('bmi-caculator') }}">Tính chỉ số BMI</a></li>
        </ul>
    </div>
    <!-- Modal Search -->
<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
    <div class="container-search-header">
        <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
            <img src="/template/images/icons/icon-close2.png" alt="CLOSE">
        </button>

        <!-- <form class="wrap-search-header flex-w p-l-15" action="{{ route('product.search') }}" method="GET">
            <button class="flex-c-m trans-04" type="submit">
                <i class="zmdi zmdi-search"></i>
            </button>
            <input class="plh3" type="text" name="search" placeholder="Search...">
        </form> -->

        <form class="wrap-search-header flex-w p-l-15" action="{{ route('product.search') }}" method="GET">
    <button class="flex-c-m trans-04" type="submit">
        <i class="zmdi zmdi-search"></i>
    </button>
    <input class="plh3" type="text" name="search" placeholder="Tìm kiếm...">
    </form>
    </div>
</div>

<script>
    function toggleMenu() {
        const menu = document.getElementById('account-menu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }

    // Đóng menu khi click ra ngoài
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('account-menu');
        const userName = document.querySelector('.user-name');
        if (!userName.contains(event.target) && !menu.contains(event.target)) {
            menu.style.display = 'none';
        }
    });
</script>
<style>

.user-name {
    transition: color 0.3s ease;
    cursor: pointer;
    margin-left: 10px;
}

.user-name:hover {
    color: blue; /* Màu xanh khi hover */
    text-shadow: 0 0 8px blue; /* Hiệu ứng phát sáng */
}
    .account-menu {
    position: absolute;
    background: white;
    border: 1px solid #ccc;
    z-index: 1000;
}
.account-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.account-menu ul li {
    padding: 8px 12px;
}
.account-menu ul li:hover {
    background-color: #f0f0f0;
}

</style>
</header>

