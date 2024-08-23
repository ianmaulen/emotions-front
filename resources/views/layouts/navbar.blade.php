<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container px-5">
        <a class="navbar-brand" href="{{route('home')}}">JOB-FITTER</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown row">
                    <a class="nav-link col-lg-auto col-12 d-flex {{ request()->routeIs('home') ? 'text-white' : '' }}" href="{{ route('home') }}" id="navbarDropdown" role="button">
                        <i class="bi bi-house me-1"></i>
                        Inicio
                    </a>
                    <a class="nav-link col-lg-auto col-12 d-flex {{ request()->routeIs('configParams') ? 'text-white' : '' }}" href="{{ route('configParams') }}" id="navbarDropdown" role="button">
                        <i class="bi bi-gear me-1"></i>
                        Condiciones
                    </a>
                    <a class="nav-link col-lg-auto col-12 d-flex {{ request()->routeIs('configOutputs') ? 'text-white' : '' }}" href="{{ route('configOutputs') }}" id="navbarDropdown" role="button">
                        <i class="bi bi-clipboard me-1"></i> 
                        Outputs
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>