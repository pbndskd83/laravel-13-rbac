<header class="premium-topbar px-3 px-md-4 py-2 border-bottom d-flex align-items-center justify-content-between sticky-top">
    <div class="d-flex align-items-center gap-2 gap-md-3">
        @auth
            <button class="btn action-btn d-lg-none text-muted" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
                <i class="fa-solid fa-bars-staggered fs-5"></i>
            </button>
        @endauth

        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0 align-items-center">
                <li class="breadcrumb-item small">
                    <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none fw-semibold">Nexus</a>
                </li>
                <li class="breadcrumb-item small active fw-bold topbar-text" aria-current="page">
                    {{ ucfirst(request()->segment(1) ?? 'Dashboard') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex align-items-center gap-2 gap-md-3">
        @auth
            {{-- Quick Actions --}}
            @if(Auth::user()->can('create', App\Models\User::class) || Auth::user()->can('create', App\Models\Permission::class))
                <div class="dropdown d-none d-sm-block">
                    <button class="btn btn-soft-primary rounded-circle p-2 border-0 transition-bounce" data-bs-toggle="dropdown" title="Quick Actions">
                        <i class="fa-solid fa-circle-plus"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-premium border-0 rounded-4 p-2 mt-2 animate__animated animate__fadeIn">
                        <li><h6 class="dropdown-header x-small fw-800 text-muted">Quick Create</h6></li>
                        @can('create', App\Models\User::class)
                            <li>
                                <a class="dropdown-item rounded-3 small py-2 d-flex align-items-center" href="{{ route('users.create') }}">
                                    <i class="fa-solid fa-user-plus me-2 text-primary"></i> New User
                                </a>
                            </li>
                        @endcan
                        @can('create', App\Models\Permission::class)
                            <li>
                                <a class="dropdown-item rounded-3 small py-2 d-flex align-items-center" href="{{ route('permissions.create') }}">
                                    <i class="fa-solid fa-shield-plus me-2 text-success"></i> New Permission
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            @endif

            {{-- Theme Toggle --}}
            <button id="theme-toggle" class="btn btn-light rounded-circle p-2 border-0 shadow-none transition-bounce text-muted bg-transparent" aria-label="Toggle Dark Mode">
                <i class="fa-solid fa-moon dark-hidden fs-5"></i>
                <i class="fa-solid fa-sun light-hidden fs-5" style="display: none; color: var(--brand-orange);"></i>
            </button>

            {{-- Notifications --}}
            <button class="btn btn-light rounded-circle p-2 position-relative border-0 shadow-none transition-bounce bg-transparent">
                <i class="fa-regular fa-bell text-muted fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="margin-top: 5px; margin-left: -5px;"></span>
            </button>

            {{-- User Dropdown --}}
            <div class="dropdown ms-1 ms-md-2">
                <div class="d-flex align-items-center gap-2 border-start ps-2 ps-md-3 cursor-pointer user-dropdown-toggle" role="button" data-bs-toggle="dropdown">
                    <div class="text-end d-none d-md-block">
                        <div class="fw-bold small lh-1 topbar-text">{{ Auth::user()->name }}</div>
                        <span class="text-success x-small fw-semibold">
                            <i class="fa-solid fa-circle me-1" style="font-size: 0.4rem;"></i> Verified Identity
                        </span>
                    </div>
                    
                    <div class="avatar-box border shadow-sm">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff&bold=true" alt="Profile">
                        @endif
                    </div>
                </div>

                {{-- Responsive Dropdown Menu --}}
                <ul class="dropdown-menu dropdown-menu-end shadow-premium border-0 mt-3 p-2 rounded-4 animate__animated animate__fadeIn responsive-dropdown-menu">
                    <li class="px-3 py-3 bg-light rounded-4 mb-2">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="x-small fw-800 text-muted text-uppercase tracking-wider">Security Level</span>
                            <span class="badge bg-soft-success text-success p-1 x-small">Maximum</span>
                        </div>
                        <div class="progress shadow-sm" style="height: 6px;">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                        </div>
                    </li>

                    <li><h6 class="dropdown-header x-small fw-800 text-muted tracking-wider pb-1">Identity & Bio</h6></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center py-2 rounded-3" href="{{ route('profile.show') }}">
                            <div class="icon-box bg-soft-primary text-primary me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fa-solid fa-id-card"></i></div>
                            <div>
                                <div class="fw-semibold small">View Profile</div>
                                <div class="x-small text-muted">Manage personal metadata</div>
                            </div>
                        </a>
                    </li>

                    <li><hr class="dropdown-divider opacity-50 my-2"></li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center text-danger py-2 rounded-3">
                                <div class="icon-box bg-soft-danger text-danger me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fa-solid fa-power-off"></i></div>
                                <div>
                                    <div class="fw-bold small">Terminate Session</div>
                                    <div class="x-small opacity-75">Securely exit Nexus</div>
                                </div>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-sm btn-link text-muted text-decoration-none fw-bold">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-premium rounded-pill px-3">Join Nexus</a>
            </div>
        @endauth
    </div>
</header>