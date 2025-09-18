@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">    
@endpush

@section('content')
<div class="container-fluid p-0">
	<div class="row g-0">
        <div class="col-md-2">
           @include('pharamacySidebar')     
        </div>
		<!-- Main Content -->
		<div class="col-md-10 main-content" id="mainContent">
			<div class="content-header d-flex justify-content-between align-items-center mb-4">
				<h4 class="mb-0"><i class="fas fa-user-injured me-2"></i>User / Profile Update</h4>
                
                
            </div>
			@if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif

            @error('profile_image')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
            
            <div class="container mt-5">
				<div class="card shadow p-4 position-relative">
					<!-- Edit Profile Form -->
					<form id="updateDoctorForm" action="{{ route('pharma.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT') <!-- Use PUT for updating -->

						<!-- Edit Button -->
						<button type="submit" class="btn btn-success position-absolute top-0 end-0 m-3" title="Save Changes">
							<i class="fas fa-save"></i>
						</button>
						<div class="row align-items-center">
							<!-- Left: Profile Info -->
							<div class="col-md-9">
								<!-- Name & ID -->
								<div class="mb-3">
									<input type="hidden" name="id" id="id" class="form-control" value="{{ $userdata['user']['id'] }}" required>
									<label for="username" class="form-label">Full Name</label>
									<input type="text" name="name" id="name" class="form-control" value="{{ $userdata['user']['name'] }}" required>
								</div>        
								
								<!-- Contact Info -->
								<div class="mb-3">
									<label for="phone" class="form-label">Phone</label>
									<input type="text" name="phone" id="phone" class="form-control" value="{{ $userdata['user']['phone'] }}" required>
								</div>
								<div class="mb-3">
									<label for="email" class="form-label">Email</label>
									<input type="email" name="email" id="email" class="form-control" value="{{ $userdata['user']['email']}}" required>
								</div>
							</div>
							<!-- Right: Profile Image -->
							<div class="col-md-3 d-flex flex-column align-items-end justify-content-center">
								<input type="file" name="profile_image" id="profileImageInput" style="display:none" accept="image/*" onchange="previewSelectedImage(this)" />
								<img src="{{ $userdata['user']['image'] }}"
									alt="Profile Photo"
									class="img-fluid border border-0 rounded mb-2"
									style="max-width: 200px; cursor: pointer;"
									id="previewImage"
									onclick="document.getElementById('profileImageInput').click();">
									<span class="notice-display">Click on image to update profile image.</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script>
function previewSelectedImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('previewImage').src = e.target.result;
    }
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endpush
