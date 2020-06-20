<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
        <div class="container">
            <span>
                 <img src="{{asset('image/logo.png')}}" height="100" width="100">
            </span>
            <a class="navbar-brand waves-effect" href="{{route(LECTURER)}}" style="text-decoration: none">
                <strong class="blue-text ita">LABORATORIES</strong>
            </a>
            <ul class="navbar-nav nav-flex-icons ml-auto">
                <strong>{{auth()->user()->name}}</strong>
            </ul>
        </div>
    </nav>
</header>
