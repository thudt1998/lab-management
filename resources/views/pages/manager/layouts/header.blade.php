<nav class="flexible-navbar white navbar navbar-light navbar-expand-lg fixed-top scrolling-navbar">
    <ul class="navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item">
            <a style="display: flex; align-items: center;">
                <strong class="text-dark admin-name">{{auth()->user()->email}}</strong>
            </a>
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
