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
                    <i class="fas fa-user-injured me-2"></i>Units
                </h4>                
                <div class="action-buttons">
                    <button class="btn btn-primary me-2" id="addUnitsBtn" data-bs-toggle="modal" data-bs-target="#addUnitsModal">
                        <i class="fa fa-plus me-1"></i> 
                        <span data-bs-toggle="modal" id="addUnitsBtn">Add Unit</span>
                    </button>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#searchUnitsModal">
                        <i class="fas fa-search me-1 text-white"></i>
                        <span id="searchUnitsBtn">Search</span>
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
                                <th class="text-center">S No</th>
                                <th class="text-center">Unit Name</th>
                                <th class="text-center">Unit Short Name</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Updated At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($units as $unit)
                            <tr>
								<td>{{ ($page - 1) * $perPage + $loop->iteration }}</td>
								<td>{{ $unit['name'] }}</td>
								<td>{{ $unit['short_name'] }}</td>
								<td>{{ $unit['description'] }}</td>
								<td>{{ \Carbon\Carbon::parse($unit['created_at'])->format('d-m-Y') }}</td>
								<td>{{ \Carbon\Carbon::parse($unit['updated_at'])->format('d-m-Y') }}</td>
								<td>
                                    <div class="d-flex flex-column flex-md-row gap-1">
                                        <button class="btn btn-sm btn-outline-primary view-btn"  data-bs-target="#unitsModal" data-units='@json($unit)'>
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning edit-btn" data-units='@json($unit)'>
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

<div class="modal fade" id="addUnitsModal" tabindex="-1" aria-labelledby="addUnitsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="unitsModalLabel">
                    <i class="fa fa-file-invoice me-2"></i> Add New Suppliers
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
			    {{-- ✅ Success / Error alerts --}}
			    <div id="formAlert"></div>

			    <form id="addUnitsForm">
			        <input type="hidden" id="units_id" name="units_id" />

			        <div class="mb-3">
			            <label for="unitName" class="form-label">Unit Name</label>
			            <input type="text" class="form-control" id="unitName" name="unit_name">
			        </div>

			        <div class="mb-3">
			            <label for="contactNumber" class="form-label">Unit Short Name</label>
			            <input type="text" class="form-control" id="shortName" name="short_name">
			        </div>

			        <div class="mb-3">
			            <label for="unitsDescription" class="form-label">Unit Description</label>
			            <input type="text" class="form-control" id="unitsDescription" name="units_description">
			        </div>
			    </form>
			</div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="addUnitsForm">Save Unit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

                                                    <!---- Units model details --->
<div class="modal fade" id="unitsModal" tabindex="-1" role="dialog" aria-labelledby="unitsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unitsModalLabel">
                    <i class="fas fa-user-md me-2"></i> Unit Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">                                    
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Unit Name:</div>
                        <div class="col-md-8" id="modal-name"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Unit Short Name:</div>
                        <div class="col-md-8" id="modal-short-name"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Unit Description:</div>
                        <div class="col-md-8" id="modal-description"></div>
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

	                                            <!-- Search Units Modal -->
	<div class="modal fade" id="searchUnitsModal" tabindex="-1" aria-labelledby="searchUnitsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="searchUnitsModalLabel">
						<i class="fa fa-search me-2"></i> Search Units
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form method="GET" action="{{ route('superadmin.units') }}">
						<div class="row">
							<div class="col-md-6 mb-3">
								<label>Unit Name</label>
								<input type="text" name="name" class="form-control" value="{{ $filters['name'] ?? '' }}">
							</div>
							<div class="col-md-6 mb-3">
								<label>Unit Short Name</label>
								<input type="text" name="short_name" class="form-control" value="{{ $filters['short_name'] ?? '' }}">
							</div>							
						
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-primary me-2">Search</button>
							<a href="{{ route('superadmin.units') }}" class="btn btn-secondary">Reset</a>
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
<script src="{{ asset('js/unitsScript.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs/dayjs.min.js"></script>
@endpush
