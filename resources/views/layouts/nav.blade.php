@if(Auth::check())
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{asset('images/Logo.png')}}" alt="Logo" width="30" height="26" class="d-inline-block align-text-top">
            </a>
            <div class="perfil">
                <i class="bi bi-person-circle userlogo"></i>
                <strong>{{$user->name}}</strong>
                <a class="mr-2" style="margin-right: 2rem" href="{{route('logout')}}">
                    <i class="bi bi-box-arrow-right logout"></i>
                </a>
            </div>
            </div>
        </nav>
    @endif