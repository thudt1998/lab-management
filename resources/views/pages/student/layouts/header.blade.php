<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
            <span>
                 <img src="{{asset('image/logo.png')}}" height="100" width="100">
            </span>
        <a class="navbar-brand waves-effect" href="{{route(STUDENT)}}" style="text-decoration: none; width: 20%">
            <strong style="color: #343A40;font-weight: bold">Hệ thống phòng thí nghiệm</strong>
        </a>
        <span class="d-flex justify-content-end" style="width: 80%">
            <a class="nav-link dropdown-toggle text-dark text-decoration-none" href="#" id="navbarDropdownMenuLink"
               data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false" style="display: flex; align-items: center; outline: none;">
            <strong class="text-dark account-name">{{ auth()->user()->name }}</strong>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item text-center text-dark text-decoration-none" data-toggle="modal"
               data-target="#modalLogoutStudent">Đăng xuất</a>
            </div>
        </span>
    </nav>
</header>
