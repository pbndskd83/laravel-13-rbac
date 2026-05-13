@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    
    {{-- Header Section --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-800 text-dark mb-1">{{ isset($user) ? 'Edit User Profile' : 'Create New User' }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-muted text-decoration-none">Team</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ isset($user) ? 'Edit' : 'Create' }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-light border shadow-sm rounded-pill px-4 fw-bold">
            <i class="fa-solid fa-xmark me-2"></i>Cancel
        </a>
    </div>

    {{-- Form Wrapper --}}
    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @if(isset($user))
            @method('PATCH')
        @endif

        <div class="row g-4">
            {{-- Left Column: Avatar & Status --}}
            <div class="col-xl-3 col-lg-4">
                <div class="card mb-4 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 text-center">
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-bold small tracking-widest mb-3">Profile Image</h6>
                            
                            <div class="position-relative d-inline-block">
                                {{-- Avatar Wrapper --}}
                                <div class="avatar-preview shadow-sm mx-auto mb-3 rounded-circle overflow-hidden position-relative border" 
                                     style="width: 120px; height: 120px; transition: var(--transition-bounce);">
                                    
                                    {{-- 1. Placeholder (BRANDED: Deep Blue & Vivid Orange) --}}
                                    <div id="placeholderPreview"
                                        class="d-flex align-items-center justify-content-center w-100 h-100 {{ isset($user) && $user->avatar ? 'd-none' : '' }}"
                                        style="background-color: #214497;">
                                        <i class="fa-solid fa-user" style="font-size: 3rem; color: #FFA500;"></i>
                                    </div>

                                    {{-- 2. Actual Image --}}
                                    <img id="imagePreview"
                                        src="{{ isset($user) && $user->avatar ? asset('storage/' . $user->avatar) : '#' }}"
                                        class="object-fit-cover w-100 h-100 {{ isset($user) && $user->avatar ? '' : 'd-none' }}"
                                        alt="Profile Preview">
                                </div>

                                {{-- 3. Upload Button --}}
                                <label for="avatarUpload" 
                                       class="btn btn-premium rounded-circle position-absolute bottom-0 end-0 mb-1 me-1 shadow-sm z-3"
                                       style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; padding: 0;">
                                    <i class="fa-solid fa-camera small text-white"></i>
                                    <input type="file" name="avatar" id="avatarUpload" class="d-none" accept="image/png, image/jpeg, image/jpg">
                                </label>
                            </div>
                            
                            <p class="text-muted small mb-0 mt-2">High-res PNG or JPG preferred</p>
                            @error('avatar')
                                <div class="text-danger fw-bold small mt-2"><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4 border-light">
                        
                        {{-- Account Status --}}
                        <div class="text-start form-group mb-0">
                            <label class="form-label text-uppercase text-muted fw-bold small tracking-widest mb-3">Account Status</label>
                            
                            <div class="d-flex align-items-center justify-content-between p-3 border rounded-3 bg-light">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-power-off text-muted"></i>
                                    <span class="fw-semibold text-dark small">Active Account</span>
                                </div>
                                
                                {{-- Hidden input to ensure 0 is sent if switch is toggled off --}}
                                <input type="hidden" name="status" value="0">
                                
                                <label class="custom-switch mb-0">
                                    <input type="checkbox" name="status" value="1" 
                                        {{ old('status', $user->status ?? 1) == 1 ? 'checked' : '' }}>
                                    <span class="switch-slider"></span>
                                </label>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: User Details --}}
            <div class="col-xl-9 col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header border-0 py-4 px-4 bg-white rounded-top-4">
                        <h5 class="fw-bold mb-0">User Identity</h5>
                        <p class="text-muted small mb-0">Fill in the details below to {{ isset($user) ? 'update' : 'register' }} an account.</p>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="row g-4">
                            
                            {{-- Name --}}
                            <div class="col-md-6 form-group mb-0">
                                <label class="form-label fw-bold text-dark">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" 
                                    value="{{ old('name', $user->name ?? '') }}"
                                    class="form-control pro-input @error('name') is-invalid @enderror" 
                                    placeholder="Enter first and last name" required>
                                @error('name') 
                                    <div class="invalid-feedback fw-bold small mt-1">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            
                            {{-- Email --}}
                            <div class="col-md-6 form-group mb-0">
                                <label class="form-label fw-bold text-dark">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" 
                                    value="{{ old('email', $user->email ?? '') }}"
                                    class="form-control pro-input @error('email') is-invalid @enderror" 
                                    placeholder="username@domain.com" required>
                                @error('email') 
                                    <div class="invalid-feedback fw-bold small mt-1">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                    </div> 
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6 form-group mb-0">
                                <label class="form-label fw-bold text-dark">Phone Number</label>
                                <input type="text" name="phone" 
                                    value="{{ old('phone', $user->phone ?? '') }}"
                                    class="form-control pro-input @error('phone') is-invalid @enderror" 
                                    placeholder="e.g., +1 555-0123">
                                @error('phone') 
                                    <div class="invalid-feedback fw-bold small mt-1">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            
                            {{-- Address --}}
                            <div class="col-md-6 form-group mb-0">
                                <label class="form-label fw-bold text-dark">Mailing Address</label>
                                <input type="text" name="address" 
                                    value="{{ old('address', $user->address ?? '') }}"
                                    class="form-control pro-input @error('address') is-invalid @enderror" 
                                    placeholder="Street, City, Postcode">
                                @error('address') 
                                    <div class="invalid-feedback fw-bold small mt-1">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                    </div> 
                                @enderror
                            </div>

                            {{-- Security Section --}}
                            <div class="col-12 mt-5">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="bg-soft-primary p-2 rounded-3 me-2 text-primary d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <h6 class="fw-bold mb-0">Security Credentials</h6>
                                </div>
                                <div class="row g-3 p-3 rounded-4 border bg-light">
                                    <div class="col-md-6 form-group mb-0">
                                        <label class="form-label fw-bold text-dark">{{ isset($user) ? 'Change Password' : 'Password' }} {!! !isset($user) ? '<span class="text-danger">*</span>' : '' !!}</label>
                                        <input type="password" name="password" 
                                            class="form-control pro-input @error('password') is-invalid @enderror"
                                            placeholder="{{ isset($user) ? 'Leave empty to keep current' : 'Min. 8 characters' }}"
                                            autocomplete="new-password" {{ !isset($user) ? 'required' : '' }}>
                                        @error('password') 
                                            <div class="invalid-feedback fw-bold small mt-1">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div> 
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-0">
                                        <label class="form-label fw-bold text-dark">Confirm Password {!! !isset($user) ? '<span class="text-danger">*</span>' : '' !!}</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control pro-input" 
                                            placeholder="Re-type password"
                                            autocomplete="new-password" {{ !isset($user) ? 'required' : '' }}>
                                    </div>
                                </div>
                            </div>

                            {{-- Roles Section (Protected by Policy) --}}
                            @can('viewAny', App\Models\Role::class)
                            <div class="col-12 mt-5 form-group mb-0">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="bg-soft-warning p-2 rounded-3 me-2 text-warning d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </span>
                                    <h6 class="fw-bold mb-0">Access Permissions</h6>
                                </div>
                                
                                <select name="roles[]" class="form-select pro-input @error('roles') is-invalid @enderror" multiple size="3" style="min-height: 120px;">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" class="py-2 px-3 border-bottom"
                                            {{ in_array($role, old('roles', $userRole ?? [])) ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                @error('roles') 
                                    <div class="invalid-feedback fw-bold small mt-1">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                    </div> 
                                @enderror
                                
                                <div class="mt-2 text-muted small"><i class="fa-solid fa-circle-info me-1 text-primary"></i> Hold CTRL (Windows) or CMD (Mac) to select multiple roles.</div>
                            </div>
                            @endcan
                            
                            {{-- Form Actions --}}
                            <div class="col-12 mt-5 pt-4 border-top d-flex flex-column flex-sm-row gap-3">
                                <button type="submit" class="btn btn-premium rounded-pill px-5 py-2">
                                    <i class="fa-solid fa-save me-2"></i>{{ isset($user) ? 'Update Profile' : 'Create Account' }}
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-light rounded-pill px-5 py-2 border shadow-sm fw-semibold text-muted text-center">Cancel</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Avatar Live Preview Script
    document.addEventListener("DOMContentLoaded", function() {
        const uploadInput = document.getElementById('avatarUpload');
        
        if (uploadInput) {
            uploadInput.onchange = function(evt) {
                const file = evt.target.files[0];
                if (file) {
                    const preview = document.getElementById('imagePreview');
                    const placeholder = document.getElementById('placeholderPreview');

                    const objectUrl = URL.createObjectURL(file);

                    preview.src = objectUrl;
                    preview.classList.remove('d-none');

                    if (placeholder) {
                        placeholder.classList.add('d-none');
                    }

                    // Cleanup memory
                    preview.onload = () => URL.revokeObjectURL(objectUrl);
                }
            };
        }
    });
</script>
@endsection