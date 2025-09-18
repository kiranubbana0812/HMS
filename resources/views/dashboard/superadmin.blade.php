@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
@endpush

@section('content')
<div class="container-fluid">
	<div class="row">
		@include('superAdminSidebar')
		<!-- Main Content -->
		<div class="col-md-10 main-content" id="mainContent">
			<div class="content-header d-flex justify-content-between align-items-center mb-4">
				<h4 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h4>
			</div>

			<!-- Dashboard Cards -->
			<div class="row">
				<div class="col-lg-3 col-md-6 mb-4">
					<div class="dashboard-card">
						<div class="card-content">
							<div class="card-info">
								<h6 class="card-title">Doctors on board</h6>
								<h2 class="card-number">
									@if(isset($data))
										{{ $data['doctors_count'] ?? 0 }}
									@endif
								</h2>
								<p class="card-subtitle">On duty</p>
							</div>
							<div class="card-icon orange-icon">
								<i class="fas fa-user-md"></i>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 mb-4">
					<div class="dashboard-card">
						<div class="card-content">
							<div class="card-info">
								<h6 class="card-title">Patients in hospital</h6>
								<h2 class="card-number">
									@if(isset($data))
										{{ $data['patients_count'] ?? 0 }}
									@endif
								</h2>
								<p class="card-subtitle">In hospital</p>
							</div>
							<div class="card-icon pink-icon">
								<i class="fas fa-bed"></i>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 mb-4">
					<div class="dashboard-card">
						<div class="card-content">
							<div class="card-info">
								<h6 class="card-title">Billing</h6>
								<h2 class="card-number">₹
									@if(isset($data))
										{{ $data['appointments_doctors_total_fees'] ?? 0 }}
									@endif
								</h2>
								<p class="card-subtitle">Total Amount</p>
							</div>
							<div class="card-icon green-money-icon">
								<i class="fas fa-money-bill-wave"></i>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 mb-4">
					<div class="dashboard-card">
						<div class="card-content">
							<div class="card-info">
								<h6 class="card-title">Appointments</h6>
								<h2 class="card-number">
									@if(isset($data))
										{{ $data['appointments_count'] ?? 0 }}
									@endif
								</h2>
								<p class="card-subtitle">Appointments</p>
							</div>
							<div class="card-icon purple-icon">
								<i class="fas fa-calendar-alt"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
    const API_BASE_URL = "{{ config('services.api.base_url') }}";
    const LOGOUT_ROUTE = "{{ route('logout') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/logout.js') }}"></script>
@endpush
