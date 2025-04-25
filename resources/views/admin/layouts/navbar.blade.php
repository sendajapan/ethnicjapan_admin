<div class="col-nav">
    <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i class="material-icons md-apps"></i></button>
    <ul class="nav">
        <li class="nav-item hidden">
            <a class="nav-link btn-icon" href="#">
                <i class="material-icons md-notifications animation-shake"></i>
                <span class="badge rounded-pill">3</span>
            </a>
        </li>
        <li class="nav-item hidden">
            <a class="nav-link btn-icon darkmode" href="#"> <i class="material-icons md-nights_stay"></i> </a>
        </li>
        <li class="dropdown nav-item">
            <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount" aria-expanded="false">
                <img class="img-xs rounded-circle" src="{{asset('assets/imgs/people/avatar-2.png')}}" alt="User" />
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                <a class="dropdown-item" href="#"><i class="material-icons md-perm_identity"></i>{{ Auth::user()->email  }}</a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item text-danger" href="#"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="material-icons md-exit_to_app"></i><span>Logout</span>
                    </a>
                </form>
            </div>
        </li>
    </ul>
</div>
