@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/insidestyles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        <div class="col-md-2">
            @include('superAdminSidebar')    
        </div>
        <div class="col-md-10 main-content px-3" id="mainContent">    
            <div class="content-header d-flex justify-content-between align-items-center mb-4">        
                <h4 class="mb-0 d-flex align-items-center" style="margin-left: 10px;">
                    <i class="fas fa-user-injured me-2"></i>Suppliers
                </h4>                
                <div class="action-buttons">
                    <button class="btn btn-primary me-2" id="addSuppliersBtn" data-bs-toggle="modal" data-bs-target="#addSuppliersModal">
                        <i class="fa fa-plus me-1"></i> 
                        <span data-bs-toggle="modal" id="addSuppliersBtn">Add Supplier</span>
                    </button>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#searchSuppliersModal">
                        <i class="fas fa-search me-1 text-white"></i>
                        <span id="searchSuppliersBtn">Search</span>
                    </button>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="table-responsive">
					{{-- Filters Summary --}}
					@if(request()->query())
						<div class="mb-3 p-3 border rounded bg-light">
							<h6 class="mb-2">Active Filters:</h6>
							<div class="d-flex flex-wrap align-items-center gap-2">
								@foreach(request()->query() as $key => $value)
									@if(!empty($value))
										<span class="badge bg-primary">
											{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}
										</span>
									@endif
								@endforeach

								{{-- Clear All Filters --}}
								<a href="{{ url()->current() }}" class="btn btn-sm btn-outline-danger ms-2">
									Clear All Filters
								</a>
							</div>
						</div>
					@endif
                    <table class="table table-hover text-center w-100 m-0">
                        <thead>
                            <tr>
                                <th class="text-center">Supplier Name</th>
                                <th class="text-center">Contact Number</th>
                                <th class="text-center">Supplier Email</th>
                                <th class="text-center">Supplier Address</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Updated At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $supplier)
                            <tr>
								<td>{{ $supplier['name'] }}</td>
								<td>{{ $supplier['contact_number'] }}</td>
								<td>{{ $supplier['email'] }}</td>
								<td>{{ $supplier['address'] }}</td>
								<td>{{ \Carbon\Carbon::parse($supplier['created_at'])->format('d-m-Y') }}</td>
								<td>{{ \Carbon\Carbon::parse($supplier['updated_at'])->format('d-m-Y') }}</td>
								<td>
                                    <div class="d-flex flex-column flex-md-row gap-1">
                                        <button class="btn btn-sm btn-outline-primary view-btn"  data-bs-target="#suppliersModal" data-suppliers='@json($supplier)'>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning edit-btn" data-suppliers='@json($supplier)'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
							</tr>
                            @endforeach
                        </tbody>
                    </table>
                    <x-pagination :pagination="$pagination" :filters="$filters" />
                </div>
            </div>
        </div>
    </div>
</div>
                                                <!---- Add Suppliers model --->
<!--<div class="modal fade" id="addSuppliersModal" tabindex="-1" aria-labelledby="addSuppliersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suppliersModalLabel">
                    <i class="fa fa-file-invoice me-2"></i> Add New Suppliers
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<form id="addSuppliersForm">
					<input type="hidden" name="suppliers_id" />
					<div class="mb-3">
						<label for="supplierName" class="form-label">Supplier Name</label>
						<input type="text" class="form-control" id="supplierName" name="supplier_name" required>
					</div>

					<div class="mb-3">
						<label for="contactNumber" class="form-label">Supplier Phone Number</label>
						<input type="tel" class="form-control" id="contactNumber" name="contact_number" required>
					</div>

					<div class="mb-3">
						<label for="suppliersEmail" class="form-label">Suppliers Email</label>
						<input type="text" class="form-control" id="suppliersEmail" name="suppliers_email" required>
					</div>

					<div class="mb-3">
						<label for="suppliersAddress" class="form-label">Supplier Address</label>
						<input type="text" class="form-control" id="suppliersAddress" name="suppliers_address" required>
					</div>

				</form>
			</div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="addSuppliersForm">Save Supplier</button>                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>                
            </div>
        </div>
    </div>
</div>-->
<div class="modal fade" id="addSuppliersModal" tabindex="-1" aria-labelledby="addSuppliersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="suppliersModalLabel">
                    <i class="fa fa-file-invoice me-2"></i> Add New Suppliers
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
			    {{-- ✅ Success / Error alerts --}}
			    <div id="formAlert"></div>

			    <form id="addSuppliersForm">
			        <input type="hidden" id="suppliers_id" name="suppliers_id" />

			        <div class="mb-3">
			            <label for="supplierName" class="form-label">Supplier Name</label>
			            <input type="text" class="form-control" id="supplierName" name="supplier_name">
			        </div>

			        <div class="mb-3">
			            <label for="contactNumber" class="form-label">Supplier Phone Number</label>
			            <input type="tel" class="form-control" id="contactNumber" name="contact_number">
			        </div>

			        <div class="mb-3">
			            <label for="suppliersEmail" class="form-label">Suppliers Email</label>
			            <input type="email" class="form-control" id="suppliersEmail" name="suppliers_email">
			        </div>

			        <div class="mb-3">
			            <label for="suppliersAddress" class="form-label">Supplier Address</label>
			            <input type="text" class="form-control" id="suppliersAddress" name="suppliers_address">
			        </div>
			    </form>
			</div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="addSuppliersForm">Save Supplier</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

                                                    <!---- Suppliers model --->
<div class="modal fade" id="suppliersModal" tabindex="-1" role="dialog" aria-labelledby="suppliersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suppliersModalLabel">
                    <i class="fas fa-user-md me-2"></i> Supplier Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">                                    
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Supplier Name:</div>
                        <div class="col-md-8" id="modal-name"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Supplier Contact No:</div>
                        <div class="col-md-8" id="modal-phone-no"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Suppliers Email:</div>
                        <div class="col-md-8" id="modal-email"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Suppliers Address:</div>
                        <div class="col-md-8" id="modal-address"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Created At:</div>
                        <div class="col-md-8" id="modal-created-at"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Updated At:</div>
                        <div class="col-md-8" id="modal-updated-at"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	                                            <!-- Search Suppliers Modal -->
	<div class="modal fade" id="searchSuppliersModal" tabindex="-1" aria-labelledby="searchSuppliersModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="searchSuppliersModalLabel">
						<i class="fa fa-search me-2"></i> Search Suppliers
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form method="GET" action="{{ route('superadmin.suppliers') }}">
						<div class="row">
							<div class="col-md-6 mb-3">
								<label>Suppliers Name</label>
								<input type="text" name="name" class="form-control" value="{{ $filters['name'] ?? '' }}">
							</div>
							<div class="col-md-6 mb-3">
								<label>Contact Number</label>
								<input type="text" name="contact_number" class="form-control" value="{{ $filters['contact_number'] ?? '' }}">
							</div>
							<div class="col-md-6 mb-3">
								<label>Address</label>
								<input type="text" name="suppliers_phone_number" class="form-control" value="{{ $filters['address'] ?? '' }}">
							</div>
							<div class="col-md-3 mb-3">
								<label>From Date</label>
								<input type="date" name="from_date" class="form-control" value="{{ $filters['from_date'] ?? '' }}">
							</div>
							<div class="col-md-3 mb-3">
								<label>To Date</label>
								<input type="date" name="to_date" class="form-control" value="{{ $filters['to_date'] ?? '' }}">
							</div>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-primary me-2">Search</button>
							<a href="{{ route('superadmin.suppliers') }}" class="btn btn-secondary">Reset</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


@endsection
@push('scripts')
<script>
const API_BASE_URL = "{{ config('services.api.base_url') }}";
const AUTH_TOKEN = localStorage.getItem('auth_token');
</script>
<script src="{{ asset('js/suppliersScript.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs/dayjs.min.js"></script>
@endpush
