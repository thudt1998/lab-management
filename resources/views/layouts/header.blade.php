<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark white scrolling-navbar pb-0 pt-0">
        <a
            class="navbar-brand text-black-50 text-dark text-decoration-none font-weight-bold"
            href="#"
            title="チャット画面へ"
        >
            LAB MANAGEMENT
        </a>
        <ul class="navbar-nav nav-flex-icons ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark text-decoration-none" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false" style="display: flex; align-items: center; outline: none;">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item text-center text-dark text-decoration-none" href="{{ url('/profile') }}">Đổi mật khẩu</a>
                    <a class="dropdown-item text-center text-dark text-decoration-none" href="{{ url('/logout') }}">Đăng xuất</a>
                </div>
            </li>
        </ul>
    </nav>
</header>

<style scoped>
    .account-name {
        max-width: 150px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        display: inline-block;
        padding-left: 5px;
    }

    @media (max-width:768px) {
        .account-name {
            max-width: 120px;
        }
    }
</style>
