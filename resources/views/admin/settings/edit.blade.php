@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    
    <!-- Top Header & Actions -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bolder text-dark mb-1">System Configurations</h4>
            <p class="text-muted small mb-0">Manage your application's global preferences and identity.</p>
        </div>
        <div class="d-flex gap-2">
            <button form="reset-all-form" type="submit" class="btn btn-outline-danger rounded-pill px-4 fw-bold shadow-sm transition-all">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>Factory Reset
            </button>
            <button form="main-settings-form" type="submit" class="btn btn-premium rounded-pill px-4 fw-bold shadow-sm transition-all">
                <i class="fa-solid fa-save me-2"></i>Save All Changes
            </button>
        </div>
    </div>

    <!-- Main Layout: Sidebar Tabs + Content -->
    <div class="row g-4">
        
        <!-- Left Sidebar Navigation -->
        <div class="col-lg-3 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 90px;">
                <div class="card-body p-2">
                    <div class="nav flex-column nav-pills custom-settings-nav" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active text-start py-3 px-4 fw-bold rounded-3" id="v-pills-identity-tab" data-bs-toggle="pill" data-bs-target="#v-pills-identity" type="button" role="tab" aria-controls="v-pills-identity" aria-selected="true">
                            <i class="fa-solid fa-palette me-2 icon"></i> Identity & Brand
                        </button>
                        <button class="nav-link text-start py-3 px-4 fw-bold rounded-3" id="v-pills-contact-tab" data-bs-toggle="pill" data-bs-target="#v-pills-contact" type="button" role="tab" aria-controls="v-pills-contact" aria-selected="false">
                            <i class="fa-solid fa-headset me-2 icon"></i> Contact & Support
                        </button>
                        <button class="nav-link text-start py-3 px-4 fw-bold rounded-3" id="v-pills-localization-tab" data-bs-toggle="pill" data-bs-target="#v-pills-localization" type="button" role="tab" aria-controls="v-pills-localization" aria-selected="false">
                            <i class="fa-solid fa-earth-americas me-2 icon"></i> Localization
                        </button>
                        <button class="nav-link text-start py-3 px-4 fw-bold rounded-3" id="v-pills-social-tab" data-bs-toggle="pill" data-bs-target="#v-pills-social" type="button" role="tab" aria-controls="v-pills-social" aria-selected="false">
                            <i class="fa-solid fa-share-nodes me-2 icon"></i> Social Links
                        </button>
                        <button class="nav-link text-start py-3 px-4 fw-bold rounded-3" id="v-pills-seo-tab" data-bs-toggle="pill" data-bs-target="#v-pills-seo" type="button" role="tab" aria-controls="v-pills-seo" aria-selected="false">
                            <i class="fa-solid fa-magnifying-glass me-2 icon"></i> SEO & Meta
                        </button>
                        <button class="nav-link text-start py-3 px-4 fw-bold rounded-3" id="v-pills-legal-tab" data-bs-toggle="pill" data-bs-target="#v-pills-legal" type="button" role="tab" aria-controls="v-pills-legal" aria-selected="false">
                            <i class="fa-solid fa-scale-balanced me-2 icon"></i> Legal & Company
                        </button>
                        <button class="nav-link text-start py-3 px-4 fw-bold rounded-3" id="v-pills-integrations-tab" data-bs-toggle="pill" data-bs-target="#v-pills-integrations" type="button" role="tab" aria-controls="v-pills-integrations" aria-selected="false">
                            <i class="fa-solid fa-plug me-2 icon"></i> Integrations
                        </button>
                        <button class="nav-link text-start py-3 px-4 fw-bold rounded-3" id="v-pills-system-tab" data-bs-toggle="pill" data-bs-target="#v-pills-system" type="button" role="tab" aria-controls="v-pills-system" aria-selected="false">
                            <i class="fa-solid fa-gears me-2 icon"></i> System Base
                        </button>
                        <button class="nav-link text-start py-3 px-4 fw-bold rounded-3" id="v-pills-advanced-tab" data-bs-toggle="pill" data-bs-target="#v-pills-advanced" type="button" role="tab" aria-controls="v-pills-advanced" aria-selected="false">
                            <i class="fa-solid fa-wand-magic-sparkles me-2 icon"></i> Advanced & UI
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content Area -->
        <div class="col-lg-9 col-md-8">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="main-settings-form">
                @csrf @method('PATCH')

                <div class="tab-content" id="v-pills-tabContent">
                    
                    {{-- TAB 1: IDENTITY & BRAND --}}
                    <div class="tab-pane fade show active" id="v-pills-identity" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0" style="color: var(--accent-color);"><i class="fa-solid fa-palette me-2"></i>Identity & Branding</h6>
                                <button form="reset-identity-form" type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3">Reset Section</button>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Application Name</label>
                                        <input type="text" name="app_name" value="{{ old('app_name', $data['app_name']) }}" class="form-control pro-input @error('app_name') is-invalid @enderror">
                                        @error('app_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Company Legal Name</label>
                                        <input type="text" name="company_name" value="{{ old('company_name', $data['company_name']) }}" class="form-control pro-input @error('company_name') is-invalid @enderror">
                                        @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="form-label fw-bold small">Site Tagline</label>
                                        <input type="text" name="site_tagline" value="{{ old('site_tagline', $data['site_tagline']) }}" class="form-control pro-input @error('site_tagline') is-invalid @enderror">
                                        @error('site_tagline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label fw-bold small">Theme Layout</label>
                                        <select name="theme_layout" class="form-control pro-input @error('theme_layout') is-invalid @enderror">
                                            <option value="light" {{ old('theme_layout', $data['theme_layout']) == 'light' ? 'selected' : '' }}>Light</option>
                                            <option value="dark" {{ old('theme_layout', $data['theme_layout']) == 'dark' ? 'selected' : '' }}>Dark</option>
                                            <option value="auto" {{ old('theme_layout', $data['theme_layout']) == 'auto' ? 'selected' : '' }}>System Auto</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label fw-bold small">Primary Color</label>
                                        <input type="color" name="brand_orange" value="{{ old('brand_orange', $data['brand_orange']) }}" class="form-control form-control-color w-100 shadow-sm @error('brand_orange') is-invalid @enderror" style="height: 46px;">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label fw-bold small">Secondary Color</label>
                                        <input type="color" name="brand_blue" value="{{ old('brand_blue', $data['brand_blue']) }}" class="form-control form-control-color w-100 shadow-sm @error('brand_blue') is-invalid @enderror" style="height: 46px;">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="form-label fw-bold small">Font Family</label>
                                        <input type="text" name="font_family" value="{{ old('font_family', $data['font_family']) }}" class="form-control pro-input @error('font_family') is-invalid @enderror" placeholder="e.g., Plus Jakarta Sans">
                                    </div>
                                    
                                    <div class="col-12"><hr class="text-muted opacity-25 my-2"></div>
                                    
                                    {{-- LOGOS & FAVICON --}}
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small d-flex justify-content-between">
                                            Light Mode Logo
                                            @if(!empty($data['logo'])) <span class="badge bg-soft-success text-success">Uploaded</span> @endif
                                        </label>
                                        <input type="file" name="logo" class="form-control pro-input mb-3" onchange="previewImage(this, 'logo-preview', 'logo-placeholder')">
                                        <div class="image-preview-wrapper shadow-sm">
                                            <div id="logo-placeholder" class="text-muted text-center {{ !empty($data['logo']) ? 'd-none' : '' }}">
                                                <i class="fa-regular fa-image fa-2xl mb-3 d-block opacity-50"></i><span class="small fw-bold opacity-75">No Logo</span>
                                            </div>
                                            <img id="logo-preview" src="{{ !empty($data['logo']) ? asset('storage/'.$data['logo']) : '' }}" class="{{ empty($data['logo']) ? 'd-none' : '' }}" alt="Preview">
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small d-flex justify-content-between">
                                            Dark Mode Logo
                                            @if(!empty($data['logo_dark_mode'])) <span class="badge bg-soft-success text-success">Uploaded</span> @endif
                                        </label>
                                        <input type="file" name="logo_dark_mode" class="form-control pro-input mb-3" onchange="previewImage(this, 'logo-dark-preview', 'logo-dark-placeholder')">
                                        <div class="image-preview-wrapper shadow-sm bg-slate-900">
                                            <div id="logo-dark-placeholder" class="text-muted text-center {{ !empty($data['logo_dark_mode']) ? 'd-none' : '' }}">
                                                <i class="fa-regular fa-image fa-2xl mb-3 d-block opacity-50"></i><span class="small fw-bold opacity-75">No Dark Logo</span>
                                            </div>
                                            <img id="logo-dark-preview" src="{{ !empty($data['logo_dark_mode']) ? asset('storage/'.$data['logo_dark_mode']) : '' }}" class="{{ empty($data['logo_dark_mode']) ? 'd-none' : '' }}" alt="Preview">
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small d-flex justify-content-between">
                                            Mobile Icon/Logo
                                            @if(!empty($data['logo_mobile'])) <span class="badge bg-soft-success text-success">Uploaded</span> @endif
                                        </label>
                                        <input type="file" name="logo_mobile" class="form-control pro-input mb-3" onchange="previewImage(this, 'logo-mobile-preview', 'logo-mobile-placeholder')">
                                        <div class="image-preview-wrapper shadow-sm">
                                            <div id="logo-mobile-placeholder" class="text-muted text-center {{ !empty($data['logo_mobile']) ? 'd-none' : '' }}">
                                                <i class="fa-regular fa-image fa-2xl mb-3 d-block opacity-50"></i><span class="small fw-bold opacity-75">No Mobile Logo</span>
                                            </div>
                                            <img id="logo-mobile-preview" src="{{ !empty($data['logo_mobile']) ? asset('storage/'.$data['logo_mobile']) : '' }}" class="{{ empty($data['logo_mobile']) ? 'd-none' : '' }}" alt="Preview">
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small d-flex justify-content-between">
                                            Favicon
                                            @if(!empty($data['favicon'])) <span class="badge bg-soft-success text-success">Uploaded</span> @endif
                                        </label>
                                        <input type="file" name="favicon" class="form-control pro-input mb-3" onchange="previewImage(this, 'favicon-preview', 'favicon-placeholder')">
                                        <div class="image-preview-wrapper shadow-sm">
                                            <div id="favicon-placeholder" class="text-muted text-center {{ !empty($data['favicon']) ? 'd-none' : '' }}">
                                                <i class="fa-regular fa-image fa-2xl mb-3 d-block opacity-50"></i><span class="small fw-bold opacity-75">No Favicon</span>
                                            </div>
                                            <img id="favicon-preview" src="{{ !empty($data['favicon']) ? asset('storage/'.$data['favicon']) : '' }}" class="{{ empty($data['favicon']) ? 'd-none' : '' }}" alt="Preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 2: CONTACT & SUPPORT --}}
                    <div class="tab-pane fade" id="v-pills-contact" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0" style="color: var(--accent-color);"><i class="fa-solid fa-headset me-2"></i>Contact & Support</h6>
                                <button form="reset-contact-form" type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3">Reset Section</button>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-4 form-group">
                                        <label class="form-label fw-bold small">Primary/Info Email</label>
                                        <input type="email" name="contact_email" value="{{ old('contact_email', $data['contact_email']) }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label fw-bold small">Support Email</label>
                                        <input type="email" name="support_email" value="{{ old('support_email', $data['support_email'] ?? '') }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label fw-bold small">Sales Email</label>
                                        <input type="email" name="sales_email" value="{{ old('sales_email', $data['sales_email'] ?? '') }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label fw-bold small">Landline / Phone</label>
                                        <input type="text" name="phone" value="{{ old('phone', $data['phone']) }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label fw-bold small">Mobile Number</label>
                                        <input type="text" name="mobile_number" value="{{ old('mobile_number', $data['mobile_number'] ?? '') }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label fw-bold small">WhatsApp Number</label>
                                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $data['whatsapp']) }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="form-label fw-bold small">Working Hours</label>
                                        <input type="text" name="working_hours" value="{{ old('working_hours', $data['working_hours']) }}" class="form-control pro-input" placeholder="e.g., Sun - Fri, 9:00 AM - 6:00 PM">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="form-label fw-bold small">Physical Address</label>
                                        <textarea name="address" class="form-control pro-input" rows="2">{{ old('address', $data['address']) }}</textarea>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="form-label fw-bold small">Google Maps Embed URL (iframe src)</label>
                                        <textarea name="map_embed_url" class="form-control pro-input" rows="2" placeholder="https://www.google.com/maps/embed?...">{{ old('map_embed_url', $data['map_embed_url']) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 3: LOCALIZATION --}}
                    <div class="tab-pane fade" id="v-pills-localization" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0" style="color: var(--accent-color);"><i class="fa-solid fa-earth-americas me-2"></i>Localization</h6>
                                <button form="reset-localization-form" type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3">Reset Section</button>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Default Language</label>
                                        <input type="text" name="default_language" value="{{ old('default_language', $data['default_language'] ?? 'en') }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Timezone</label>
                                        <input type="text" name="timezone" value="{{ old('timezone', $data['timezone'] ?? 'Asia/Kathmandu') }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Date Format</label>
                                        <input type="text" name="date_format" value="{{ old('date_format', $data['date_format'] ?? 'Y-m-d') }}" class="form-control pro-input" placeholder="Y-m-d">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Time Format</label>
                                        <input type="text" name="time_format" value="{{ old('time_format', $data['time_format'] ?? 'h:i A') }}" class="form-control pro-input" placeholder="h:i A">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Currency Code</label>
                                        <input type="text" name="currency" value="{{ old('currency', $data['currency']) }}" class="form-control pro-input" placeholder="NPR, USD">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Currency Symbol</label>
                                        <input type="text" name="currency_symbol" value="{{ old('currency_symbol', $data['currency_symbol']) }}" class="form-control pro-input" placeholder="Rs., $">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 4: SOCIAL --}}
                    <div class="tab-pane fade" id="v-pills-social" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0" style="color: var(--accent-color);"><i class="fa-solid fa-share-nodes me-2"></i>Social Connections</h6>
                                <button form="reset-social-form" type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3">Reset Section</button>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Facebook URL</label>
                                        <input type="url" name="social_fb" value="{{ old('social_fb', $data['social_fb']) }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">X (Twitter) URL</label>
                                        <input type="url" name="social_x" value="{{ old('social_x', $data['social_x'] ?? '') }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Instagram URL</label>
                                        <input type="url" name="social_insta" value="{{ old('social_insta', $data['social_insta']) }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">LinkedIn URL</label>
                                        <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $data['social_linkedin']) }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label class="form-label fw-bold small">YouTube URL</label>
                                        <input type="url" name="social_youtube" value="{{ old('social_youtube', $data['social_youtube']) }}" class="form-control pro-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 5: SEO --}}
                    <div class="tab-pane fade" id="v-pills-seo" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0" style="color: var(--accent-color);"><i class="fa-solid fa-magnifying-glass me-2"></i>Search Engine Optimization</h6>
                                <button form="reset-seo-form" type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3">Reset Section</button>
                            </div>
                            <div class="card-body p-4">
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold small">Global Meta Title</label>
                                    <input type="text" name="seo_title" value="{{ old('seo_title', $data['seo_title']) }}" class="form-control pro-input">
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold small">Global Meta Description</label>
                                    <textarea name="seo_desc" class="form-control pro-input" rows="4">{{ old('seo_desc', $data['seo_desc']) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label fw-bold small">Global Keywords</label>
                                    <input type="text" name="seo_keywords" value="{{ old('seo_keywords', $data['seo_keywords']) }}" class="form-control pro-input">
                                    <small class="text-muted mt-1 d-block">Separate keywords with commas.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 6: LEGAL --}}
                    <div class="tab-pane fade" id="v-pills-legal" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0" style="color: var(--accent-color);"><i class="fa-solid fa-scale-balanced me-2"></i>Legal & Company Info</h6>
                                <button form="reset-legal-form" type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3">Reset Section</button>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Tax Number (PAN/VAT)</label>
                                        <input type="text" name="tax_number" value="{{ old('tax_number', $data['tax_number'] ?? '') }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Company Reg Number</label>
                                        <input type="text" name="company_reg_number" value="{{ old('company_reg_number', $data['company_reg_number'] ?? '') }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Privacy Policy URL</label>
                                        <input type="text" name="privacy_policy_url" value="{{ old('privacy_policy_url', $data['privacy_policy_url'] ?? '/privacy-policy') }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Terms & Conditions URL</label>
                                        <input type="text" name="terms_conditions_url" value="{{ old('terms_conditions_url', $data['terms_conditions_url'] ?? '/terms') }}" class="form-control pro-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 7: INTEGRATIONS --}}
                    <div class="tab-pane fade" id="v-pills-integrations" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0" style="color: var(--accent-color);"><i class="fa-solid fa-plug me-2"></i>Tracking & Integrations</h6>
                                <button form="reset-integrations-form" type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3">Reset Section</button>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Google Analytics Measurement ID</label>
                                        <input type="text" name="google_analytics_id" value="{{ old('google_analytics_id', $data['google_analytics_id'] ?? '') }}" class="form-control pro-input" placeholder="G-XXXXXXXXXX">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Google Tag Manager ID</label>
                                        <input type="text" name="google_tag_manager_id" value="{{ old('google_tag_manager_id', $data['google_tag_manager_id'] ?? '') }}" class="form-control pro-input" placeholder="GTM-XXXXXXX">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Facebook Pixel ID</label>
                                        <input type="text" name="facebook_pixel_id" value="{{ old('facebook_pixel_id', $data['facebook_pixel_id'] ?? '') }}" class="form-control pro-input">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small">Google Recaptcha Site Key</label>
                                        <input type="text" name="recaptcha_site_key" value="{{ old('recaptcha_site_key', $data['recaptcha_site_key'] ?? '') }}" class="form-control pro-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 8: SYSTEM --}}
                    <div class="tab-pane fade" id="v-pills-system" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0" style="color: var(--accent-color);"><i class="fa-solid fa-gears me-2"></i>System Base Settings</h6>
                                <button form="reset-system-form" type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3">Reset Section</button>
                            </div>
                            <div class="card-body p-4">
                                
                                <div class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-3 shadow-sm border" style="background-color: var(--bg-body);">
                                    <div>
                                        <div class="fw-bold text-dark">Enable Maintenance Mode</div>
                                        <div class="x-small text-muted">Displays a 'Site under construction' banner to regular visitors.</div>
                                    </div>
                                    <label class="custom-switch">
                                        <input type="hidden" name="maintenance_mode" value="off">
                                        <input type="checkbox" name="maintenance_mode" value="on" {{ old('maintenance_mode', $data['maintenance_mode']) == 'on' ? 'checked' : '' }}>
                                        <span class="switch-slider"></span>
                                    </label>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold small">Global Pagination Limit</label>
                                    <input type="number" name="pagination_limit" value="{{ old('pagination_limit', $data['pagination_limit'] ?? 15) }}" class="form-control pro-input">
                                </div>
                                <div class="form-group">
                                    <label class="form-label fw-bold small">Footer Copyright Text</label>
                                    <input type="text" name="footer_text" value="{{ old('footer_text', $data['footer_text']) }}" class="form-control pro-input">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 9: ADVANCED --}}
                    <div class="tab-pane fade" id="v-pills-advanced" role="tabpanel">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0" style="color: var(--accent-color);"><i class="fa-solid fa-wand-magic-sparkles me-2"></i>Advanced Features & Overrides</h6>
                                <button form="reset-advanced-form" type="submit" class="btn btn-sm btn-light border text-danger rounded-pill px-3">Reset Section</button>
                            </div>
                            <div class="card-body p-4">
                                
                                <div class="row g-4 mb-4">
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border h-100" style="background-color: var(--bg-body);">
                                            <div>
                                                <div class="fw-bold small text-dark">Public Registration</div>
                                            </div>
                                            <label class="custom-switch">
                                                <input type="hidden" name="enable_user_registration" value="off">
                                                <input type="checkbox" name="enable_user_registration" value="on" {{ old('enable_user_registration', $data['enable_user_registration'] ?? 'off') == 'on' ? 'checked' : '' }}>
                                                <span class="switch-slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border h-100" style="background-color: var(--bg-body);">
                                            <div>
                                                <div class="fw-bold small text-dark">Newsletter Popup</div>
                                            </div>
                                            <label class="custom-switch">
                                                <input type="hidden" name="enable_newsletter_popup" value="off">
                                                <input type="checkbox" name="enable_newsletter_popup" value="on" {{ old('enable_newsletter_popup', $data['enable_newsletter_popup'] ?? 'off') == 'on' ? 'checked' : '' }}>
                                                <span class="switch-slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 shadow-sm border h-100" style="background-color: var(--bg-body);">
                                            <div>
                                                <div class="fw-bold small text-dark">Live Chat Widget</div>
                                            </div>
                                            <label class="custom-switch">
                                                <input type="hidden" name="enable_live_chat" value="off">
                                                <input type="checkbox" name="enable_live_chat" value="on" {{ old('enable_live_chat', $data['enable_live_chat'] ?? 'off') == 'on' ? 'checked' : '' }}>
                                                <span class="switch-slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-bold small">Live Chat Script (Tawk.to, Crisp, etc.)</label>
                                    <textarea name="live_chat_script" class="form-control pro-input font-monospace text-muted" rows="3">{{ old('live_chat_script', $data['live_chat_script'] ?? '') }}</textarea>
                                </div>

                                <div class="row g-4">
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small text-danger">Custom CSS Injection</label>
                                        <textarea name="custom_css" class="form-control pro-input font-monospace text-muted" rows="5" placeholder="body { background: #000; }">{{ old('custom_css', $data['custom_css'] ?? '') }}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label fw-bold small text-danger">Custom JS Injection</label>
                                        <textarea name="custom_js" class="form-control pro-input font-monospace text-muted" rows="5" placeholder="console.log('Hello');">{{ old('custom_js', $data['custom_js'] ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

{{-- SECTION RESET HIDDEN FORMS --}}
<form id="reset-identity-form" action="{{ route('admin.settings.reset.section', 'identity') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset Identity & Branding settings?');">@csrf @method('DELETE')</form>
<form id="reset-contact-form" action="{{ route('admin.settings.reset.section', 'contact') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset Contact & Support settings?');">@csrf @method('DELETE')</form>
<form id="reset-localization-form" action="{{ route('admin.settings.reset.section', 'localization') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset Localization settings?');">@csrf @method('DELETE')</form>
<form id="reset-social-form" action="{{ route('admin.settings.reset.section', 'social') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset Social Connections?');">@csrf @method('DELETE')</form>
<form id="reset-seo-form" action="{{ route('admin.settings.reset.section', 'seo') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset SEO settings?');">@csrf @method('DELETE')</form>
<form id="reset-legal-form" action="{{ route('admin.settings.reset.section', 'legal') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset Legal settings?');">@csrf @method('DELETE')</form>
<form id="reset-integrations-form" action="{{ route('admin.settings.reset.section', 'integrations') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset Tracking & Integrations?');">@csrf @method('DELETE')</form>
<form id="reset-system-form" action="{{ route('admin.settings.reset.section', 'system') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset System settings?');">@csrf @method('DELETE')</form>
<form id="reset-advanced-form" action="{{ route('admin.settings.reset.section', 'advanced') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset Advanced settings?');">@csrf @method('DELETE')</form>
<form id="reset-all-form" action="{{ route('admin.settings.reset') }}" method="POST" onsubmit="return confirm('WARNING: This will wipe ALL application settings back to factory defaults. Proceed?');">@csrf @method('DELETE')</form>

{{-- LIVE IMAGE PREVIEW SCRIPT --}}
<script>
    function previewImage(input, targetId, placeholderId) {
        let previewImg = document.getElementById(targetId);
        let placeholder = document.getElementById(placeholderId);
        
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('d-none');
                if(placeholder) placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    /* Synchronized Theme Navigation Styles */
    .custom-settings-nav .nav-link { 
        color: var(--text-muted); 
        border-left: 4px solid transparent; 
        border-radius: 0 0.5rem 0.5rem 0;
        transition: all 0.2s ease-in-out;
    }
    .custom-settings-nav .nav-link .icon { transition: color 0.2s; opacity: 0.6; }
    
    /* Pulls dynamic colors directly from the CSS variables mapped in app.blade.php */
    .custom-settings-nav .nav-link.active { 
        background-color: color-mix(in srgb, var(--accent-color) 8%, transparent); 
        color: var(--accent-color); 
        border-left-color: var(--brand-orange); 
    }
    .custom-settings-nav .nav-link.active .icon { color: var(--accent-color) !important; opacity: 1; }
    
    .custom-settings-nav .nav-link:hover:not(.active) { background-color: var(--bg-body); }

    /* Custom Image Preview Area mapped to Light/Dark Mode Variables */
    .image-preview-wrapper {
        border: 2px dashed var(--border-color);
        background-color: var(--bg-body);
        border-radius: 0.5rem;
        padding: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 140px;
        position: relative;
    }
    .image-preview-wrapper img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        border-radius: 0.25rem;
    }
    
    /* Utility class for Dark Mode Preview Box */
    .bg-slate-900 {
        background-color: #0f172a !important;
        border-color: #334155 !important;
    }
</style>
@endsection