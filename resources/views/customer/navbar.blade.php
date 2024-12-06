<header class="header_section">
    <div class="container-fuild">
        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <a href="{{route('customer.dashboard')}}">
                <img src="{{asset('assets/img/logo.png')}}" style="width: 15%" alt="">
            </a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId"
                aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('customer.dashboard')}}">My Rentals <span class="sr-only">(current)</span></a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Document
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId" style="left: -50px;">
                            <a class="dropdown-item"
                        href="{{ url('/customer/show_documents/' . session()->get('ADMIN_EMAIL')) }}">Show Documents</a>
                    {{-- <a class="dropdown-item"
                        href="{{ url('/customer/update_documents/' . session()->get('ADMIN_EMAIL')) }}">Upload Here</a> --}}
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="{{ url('/assets/img/icon.png') }}" alt="" class="rounded-circle" width="40px">
                            {{ session()->get('ADMIN_NAME') }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId" style="left: -50px;">
                            <a class="dropdown-item" href="{{url('/customer/profile/'.session()->get('ADMIN_EMAIL'))}}">My Profile</a>
                            <a class="dropdown-item" href="{{url('/customer/reset_password/'.session()->get('ADMIN_EMAIL'))}}">Reset Password</a>
                            <a class="dropdown-item" href="{{url('/customer/logout')}}">Logout</a>                
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
