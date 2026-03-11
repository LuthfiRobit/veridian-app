@extends('layouts.backend')

@section('title', 'My Profile')

@section('content')
    <div class="page-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">My Profile</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Account</li>
                        <li class="breadcrumb-item">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card user-card">
                <div class="card-body">
                    <div class="user-avatar-section text-center">
                        <div class="d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-3 pt-1" 
                                src="{{ !empty($user->avatar) ? asset($user->avatar) : asset('company-dashboard/assets/images/user/avatar-2.jpg') }}" 
                                alt="User avatar" 
                                id="avatar-preview" 
                                style="width: 120px; height: 120px; object-fit: cover;" />
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $user->name }}</h4>
                                <span class="badge bg-light-primary text-primary">{{ $user->getRoleNames()->first() ?? 'User' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-container mt-4">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="fw-bold me-2">Email:</span>
                                <span>{{ $user->email }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-bold me-2">Status:</span>
                                <span class="badge bg-light-success text-success">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>Profile Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="avatar" class="form-label">Profile Picture</label>
                                <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*" onchange="previewImage(this)" />
                                <div class="form-text">Allowed JPG, GIF or PNG. Max size of 2MB</div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="author_title" class="form-label">Title / Profession</label>
                                <input class="form-control" type="text" id="author_title" name="author_title" value="{{ old('author_title', $user->author_title) }}" placeholder="e.g. Content Writer" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="author_bio" class="form-label">Short Bio</label>
                                <textarea class="form-control" id="author_bio" name="author_bio" rows="3">{{ old('author_bio', $user->author_bio) }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4" />
                        <h5>Change Password <span class="text-muted small fs-6">(Optional)</span></h5>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input class="form-control" type="password" id="password" name="password" placeholder="Leave blank to keep current" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat new password" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            <button type="reset" class="btn btn-label-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatar-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
@endsection
