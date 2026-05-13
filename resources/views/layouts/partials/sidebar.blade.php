<aside id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-brand border-bottom border-light border-opacity-10">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
            @php 
                $logo = site_settings('logo');
                $appName = site_settings('app_name', config('app.name'));
            @endphp

            @if(!empty($logo))
                @if(str_contains($logo, '<i class'))
                    {!! $logo !!}
                @else
                    <img src="{{ asset('storage/' . $logo) }}" 
                         alt="{{ $appName }}" 
                         style="height: 32px; object-fit: contain;" 
                         class="me-2 brand-logo-img"
                         onerror="this.style.display='none'">
                @endif
            @endif

            <span class="brand-text text-white">{{ $appName }}</span>
        </a>
    </div>

    <nav class="sidebar-menu mt-3">
        {{-- Section: Core --}}
        <div class="nav-group-label">Core Area</div>
        <a href="{{ route('dashboard') }}" class="nav-link-premium {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house-chimney"></i> <span>Overview</span>
        </a>

        {{-- Section: Personal --}}
        <div class="nav-group-label">Personal</div>
        <a href="{{ route('profile.show') }}" class="nav-link-premium {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-circle"></i> <span>My Profile</span>
        </a>

        {{-- Section: Access Control --}}
        @canany(['user-list', 'role-list', 'permission-list'])
            <div class="nav-group-label">Access Control</div>
            
            @can('viewAny', App\Models\User::class)
            <a href="{{ route('users.index') }}" class="nav-link-premium {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> <span>User Directory</span>
            </a>
            @endcan

            @can('viewAny', App\Models\Role::class)
            <a href="{{ route('roles.index') }}" class="nav-link-premium {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-shield"></i> <span>Role Authority</span>
            </a>
            @endcan

            @can('viewAny', App\Models\Permission::class)
            <a href="{{ route('permissions.index') }}" class="nav-link-premium {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                <i class="fa-solid fa-fingerprint"></i> <span>Permission Registry</span>
            </a>
            @endcan
        @endcanany

        {{-- Section: System --}}
        {{-- Check for settings permission - Adjust this based on your specific role setup --}}
        @if(auth()->user()->hasPermissionTo('manage-settings') || auth()->user()->hasRole('Super Admin'))
            <div class="nav-group-label">System</div>
            <a href="{{ route('admin.settings.edit') }}" class="nav-link-premium {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gears"></i> <span>Global Settings</span>
            </a>
        @endif
    </nav>
</aside>

{{-- Mobile Overlay --}}
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>