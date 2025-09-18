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
                    <i class="fas fa-layer-group me-2"></i>Products Category
                </h4>
                <div class="action-buttons">
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#categoryFormModal" id="addCategoryBtn">
                        <i class="fas fa-plus me-1"></i> Add Product Category
                    </button>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#searchCategoriesModal">
                        <i class="fas fa-search me-1 text-white"></i>
                        <span id="searchCategoriesBtn">Search</span>
                    </button>                 
                </div>
            </div>
            <div class="dashboard-card">
                <div class="table-responsive">					
                    <table class="table table-hover text-center w-100 m-0">
                        <thead>
                            <tr>
                                <th>S No</th>
                                <th>Name</th>                                
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ ($page - 1) * $perPage + $loop->iteration }}</td>
                                    <td>{{ $category['name'] }}</td>
                                    <td>{{ $category['description'] }}</td>
                                    <td>
                                        <span class="badge {{ $category['status'] === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($category['status']) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column flex-md-row gap-1">
                                            <button class="btn btn-sm btn-outline-warning edit-btn" data-category='@json($category)'>
                                                <i class="fas fa-edit"></i>
                                            </button>   
                                            <button class="btn btn-sm btn-outline-primary view-btn" data-category='@json($category)'>
                                                <i class="fas fa-eye"></i>
                                            </button>                                            
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <x-pagination :pagination="$pagination" :filters="$filters" />
                </div>
            </div>
        </div>
    </div>
</div>    
                                <!-- Add/Edit Products category Modal -->
<div class="modal fade" id="categoryFormModal" tabindex="-1" role="dialog" aria-labelledby="categoryFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="categoryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryFormModalLabel">
                        <i class="fas fa-layer-group me-2"></i> Add / Edit Product Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="category-id">

                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3" id="statusRow">
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Category
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>    
        </div>
    </div>
</div>
                                <!--Category Product View Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">
                    <i class="fas fa-layer-group me-2"></i> Category Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>            
            <div class="modal-body">
                <div class="container-fluid">                    
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Name:</div>
                        <div class="col-md-8" id="modal-name"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Description:</div>
                        <div class="col-md-8" id="modal-description"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8" id="modal-status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                                <!-- Search Products Modal -->
<div class="modal fade" id="searchCategoriesModal" tabindex="-1" aria-labelledby="searchCategoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchCategoriesModalLabel">
                    <i class="fa fa-search me-2"></i> Search Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="categorySearchForm" method="GET" action="{{ route('productcategories.index') }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Category Name</label>
                            <!-- Name attribute must match API query param -->
                            <input type="text" name="search" id="searchCategoryName" class="form-control" value="{{ $filters['search'] ?? '' }}">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-2">Search</button>
                        <a href="{{ route('productcategories.index') }}" class="btn btn-secondary">Reset</a>
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
<script src="{{ asset('js/productCategoryScript.js') }}"></script>
@endpush
