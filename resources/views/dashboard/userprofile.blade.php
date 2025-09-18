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
			@if(session('user.role')==='superadmin')
				@include('superAdminSidebar')
			@elseif(session('user.role')==='admin') 
				@include('superAdminSidebar')
			@elseif(session('user.role')=== 'frontdesk')
				@include('sidebar')
			@endif
        </div>
		<!-- Main Content -->
		<div class="col-md-10 main-content" id="mainContent">
			<div class="content-header d-flex justify-content-between align-items-center mb-4">
				<h4 class="mb-0"><i class="fas fa-user-injured me-2"></i>User / Profile</h4>
            </div>
			<div class="container mt-5">
				<div class="card shadow p-4 position-relative"> <!-- Added position-relative -->
					{{-- <form id="updateDoctorForm" action="{{ route('user.edit') }}" method="get"> --}}
						
                   
                   @if(session('user.role')==='superadmin')
                   
                    <button type="button" 
								class="btn btn-light position-absolute top-0 end-0 m-3" 
								onclick="window.location='{{ route('superadmin.edit') }}'" 
								id="editProfileBtn" 
								title="Edit Profile">
							<i class="fas fa-edit"></i>
						</button>
                       @elseif(session('user.role')==='admin') 
                         <button type="button" 
								class="btn btn-light position-absolute top-0 end-0 m-3" 
								onclick="window.location='{{ route('admin.edit') }}'" 
								id="editProfileBtn" 
								title="Edit Profile">
							<i class="fas fa-edit"></i>
						</button>
                         @elseif(session('user.role')=== 'frontdesk')
                         <button type="button" 
								class="btn btn-light position-absolute top-0 end-0 m-3" 
								onclick="window.location='{{ route('frontdesk.edit') }}'" 
								id="editProfileBtn" 
								title="Edit Profile">
							<i class="fas fa-edit"></i>
						</button>
                         @endif      
					{{-- </form> --}}
					<div class="row align-items-center">
						<!-- Left: Profile Info -->
						<div class="col-md-9">
							<!-- Name & ID -->
							<div class="mb-3">
								<h3 class="mb-1">{{ $userdata['user']['name'] }}</h3>
								<p class="text-muted mb-0">{{ $userdata['user']['email'] }}</p>
							</div>
							<!-- Designation -->
							<div class="mb-3">
								<span class="badge bg-primary fs-6">{{ $userdata['user']['phone'] }}</span>
							</div>
							
						</div>
						<div class="col-md-3 d-flex flex-column align-items-end justify-content-center">
							<input type="hidden" name="id" value="{{ $userdata['user']['id'] }}">
							<input type="file" name="image" id="profileImageInput" style="display:none" accept="image/*" />
							<img src="{{ $userdata['user']['image'] }}"
								alt="Profile Photo"
								class="img-fluid border border-0 rounded mb-2"
								style="max-width: 200px;"
							id="previewImage">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
