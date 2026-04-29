<aside id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-brand">
        <i class="fas fa-bolt-lightning me-2 text-primary"></i>NEXUS
    </div>
    
    <nav class="sidebar-menu simplebar-scrollable-y">
        {{-- Section: Core Area --}}
        <div class="nav-group-label">Core Area</div>
        <a href="{{ route('dashboard') }}" class="nav-link-premium {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house-chimney"></i> Overview
        </a>

        {{-- Section: Personal --}}
        <div class="nav-group-label">Personal</div>
        {{-- Updated active check to keep menu highlighted when editing profile --}}
        <a href="{{ route('profile.show') }}" class="nav-link-premium {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-circle"></i> My Profile
        </a>

        {{-- Section: Access Control --}}
        {{-- Logic: Only show the "Access Control" label if the user can view at least one item below --}}
        @if(Auth::user()->can('viewAny', App\Models\User::class) || 
            Auth::user()->can('viewAny', App\Models\Role::class) || 
            Auth::user()->can('viewAny', App\Models\Permission::class))
            
            <div class="nav-group-label">Access Control</div>
            
            {{-- User Directory --}}
            @can('viewAny', App\Models\User::class)
            <a href="{{ route('users.index') }}" class="nav-link-premium {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear"></i> User Directory
            </a>
            @endcan

            {{-- Role Authority --}}
            @can('viewAny', App\Models\Role::class)
            <a href="{{ route('roles.index') }}" class="nav-link-premium {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-shield"></i> Role Authority
            </a>
            @endcan

            {{-- Permission Registry --}}
            @can('viewAny', App\Models\Permission::class)
            <a href="{{ route('permissions.index') }}" class="nav-link-premium {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                <i class="fa-solid fa-fingerprint"></i> Permission Registry
            </a>
            @endcan

        @endif
    </nav>
</aside>

<div class="sidebar-overlay" onclick="toggleSidebar()"></div>