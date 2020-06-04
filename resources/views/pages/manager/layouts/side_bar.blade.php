<div class="sidebar-fixed position-fixed">
    <div style="height: 120px;margin:0 auto;text-align: center;padding-top:40px">
        <h2></h2>
    </div>
    <ul class="list-group" style="position: relative">
        <a href="{{route('lecturers.index')}}" style="text-decoration: none;">
            <li
                class="{{request()->is('managers/lecturers*')?
                        'list-group-item d-flex justify-content-between align-items-center list-group-item-action border-top active':
                        'list-group-item d-flex justify-content-between align-items-center list-group-item-action border-top'}}"
            >
                <i class="mr-3 fas fa-users"></i>Giảng viên
            </li>
        </a>
        <a style="text-decoration: none;">
            <li
                class="{{request()->is('managers/laboratories*')?
                    'list-group-item d-flex justify-content-between align-items-center list-group-item-action border-top active':
                    'list-group-item d-flex justify-content-between align-items-center list-group-item-action border-top'}}"
                >
                <i class="mr-3 fas fa-building"></i>Phòng
            </li>
        </a>
        <a style="text-decoration: none;">
            <li
                class="{{request()->is('managers/compartments*')?
                    'list-group-item d-flex justify-content-between align-items-center list-group-item-action border-top active':
                    'list-group-item d-flex justify-content-between align-items-center list-group-item-action border-top'}}"
            >
                <i class="mr-3 fas fa-microscope"></i>Ngăn
            </li>
        </a>

        <a href="{{route(LOGOUT_MANAGER)}}" style="text-decoration: none;font-size:1rem">
            <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-action logout text-dark border-top">
                <i class="mr-3 fas fa-sign-out-alt text-dark"></i>ログアウト
            </li>
        </a>
    </ul>
</div>

<style scoped>
    .sidebar-fixed {
        left: 0;
        top: 0;
        height: 100vh;
        width: 270px;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        z-index: 1050;
        background-color: #fff;
        padding: 1.5rem;
        padding-top: 0;
    }

    .sidebar-fixed .logo-wrapper img {
        width: 100%;
        padding: 2.5rem;
    }

    .sidebar-fixed .list-group-item {
        display: block !important;
        transition: background-color 0.3s;
        border: none;
    }

    .sidebar-fixed .list-group .active {
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        border-radius: 5px;
    }

    .logout {
        position: absolute;
        bottom: 50px;
    }

    .list-group .active {
        border-radius: 0.125rem !important;
    }

    .list-group {
        height: calc(100vh - 120px);
    }

    .border-top {
        border-top: 1px solid rgba(0, 0, 0, .125) !important;
    }
</style>
