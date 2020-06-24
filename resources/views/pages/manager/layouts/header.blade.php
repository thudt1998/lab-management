<nav class="flexible-navbar white navbar navbar-light navbar-expand-lg fixed-top scrolling-navbar">
    <ul class="navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item d-flex">
            <a style="display: flex; align-items: center;">
                <strong class="text-dark admin-name">{{auth()->user()->email}}</strong>
            </a>
            <a href="#" class="ml-2" style="font-size: 20px"><i class="fas fa-bell"><span class="badge badge-danger" style="position: absolute; top: 3px; right: 11px; font-size: 10px">4</span></i></a>
        </li>
    </ul>
</nav>

<style>
    .flexible-navbar {
        transition: padding-left 0.5s;
        padding-left: 270px;
    }
    .navbar-light .navbar-brand {
        margin-left: 15px;
        color: #2196f3 !important;
        font-weight: bolder;
    }

    .admin-name {
        max-width: 200px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        display: inline-block;
        padding-left: 5px;
    }
</style>
