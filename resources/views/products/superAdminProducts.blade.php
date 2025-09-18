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
<<<<<<< HEAD
                    <i class="fas fa-user-injured me-2"></i>Medicines
=======
                    <i class="fas fa-user-injured me-2"></i>Products
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
                </h4>
                <div class="action-buttons">
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#productFormModal" id="addProductBtn">
                        <i class="fas fa-plus me-1"></i>
                        Add Product
                    </button>
                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#searchProductsModal">
                        <i class="fas fa-search me-1 text-white"></i>
                        <span id="searchProductsBtn">Search</span>
<<<<<<< HEAD
                    </button>      
                    <!-- Hidden file input -->
                    <input type="file" id="importFile" accept=".csv,.xlsx" style="display:none;">

                    <!-- Visible button styled as Import -->
                    <!--<label for="importFile" class="btn btn-success">
                        <i class="fas fa-file-import me-1"></i> Import
                    </label>-->
                    <!-- Export Button -->
                    <button id="importBtn" for="importFile" class="btn btn-primary me-2">
                        <i class="fas fa-file-import me-1"></i> Import
                    </button>

                    <!-- Export Button -->
                    <button id="exportBtn" class="btn btn-primary me-2">
                        <i class="fas fa-file-export me-1"></i> Export
                    </button>            
=======
                    </button>                  
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
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
<<<<<<< HEAD
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Category</th>
=======
                                <th>S No</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Category</th>                                 
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
                                <th>Description</th>
                                <th>Total Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
<<<<<<< HEAD
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['unit']['name'] ?? 'N/A' }}</td>
                                    <td>{{ $product['category']['name'] ?? 'N/A' }}</td>
                                    <td>{{ $product['description'] }}</td>
                                     <td>{{ $product['product_stock'] ?? 'N/A' }}</td>
=======
                                    <td>{{ ($page - 1) * $perPage + $loop->iteration }}</td>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['unit']['name'] ?? 'N/A' }}</td>
                                    <td>{{ $product['category']['name'] ?? 'N/A' }}</td>
                                     
                                    <td>{{ $product['description'] }}</td>
                                    <td>{{ $product['product_stock'] ?? 'N/A' }}</td>
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
                                    <td>
                                        <div class="d-flex flex-column flex-md-row gap-1">
                                            <button class="btn btn-sm btn-outline-primary view-btn" data-product='@json($product)'>
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning edit-btn" data-product='@json($product)'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No products found.</td>
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
                                <!-- Add/Edit Product Modal -->
<div class="modal fade" id="productFormModal" tabindex="-1" role="dialog" aria-labelledby="productFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="productForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="productFormModalLabel">
                        <i class="fas fa-box me-2"></i> Add / Edit Product
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="product-id">
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Unit</label>
                                <select class="form-select" id="unit_id">
                                    <option value="">Choose...</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit['id'] }}">{{ $unit['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>                            
                        </div>
                        <div class="row mb-3">                            
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select class="form-select" id="category_id">
                                    <option value="">Choose...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">GST %</label>
                                <input type="number" class="form-control" id="gst_percent" step="0.01" value="0.00">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="description"></textarea>
                            </div>                            
                        </div>
                    </div>
                </div>                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Product
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>    
        </div>
    </div>
</div>

                                <!-- Product View Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">
                    <i class="fas fa-box me-2"></i> Product Details
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
                        <div class="col-md-4 fw-bold">Unit:</div>
                        <div class="col-md-8" id="modal-unit"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Category:</div>
                        <div class="col-md-8" id="modal-category"></div>
                    </div>                    
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Description:</div>
                        <div class="col-md-8" id="modal-description"></div>
                    </div>                    
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">GST %:</div>
                        <div class="col-md-8" id="modal-gst"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Created on:</div>
                        <div class="col-md-8" id="modal-created-at"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Last updated on:</div>
                        <div class="col-md-8" id="modal-updated-at"></div>
                    </div>
<<<<<<< HEAD
                    <div class="row mb-2">
                                 <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr>
                                                <th>Batch Code</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody id="batch-table-body"></tbody>                                    
                                 </table>               
                      </div>
=======

                                <div class="row mb-2">
                                                        <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                        <th>Batch Code</th>
                                        <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody id="batch-table-body">
                                        <!-- Rows will be added dynamically -->
                                    </tbody>
                                    </table>
                    </div>
                </div>
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
                </div>
            </div>
        </div>
    </div>
</div>
                                <!-- Search Products Modal -->
<div class="modal fade" id="searchProductsModal" tabindex="-1" aria-labelledby="searchProductsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchProductsModalLabel">
                    <i class="fa fa-search me-2"></i> Search Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productSearchForm" method="GET" action="{{ route('products.index') }}">
                    <div class="row">                        
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="searchProductName" class="form-control" value="{{ $filters['name'] ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Unit</label>
                            <input type="text" name="unit" id="searchUnit" class="form-control" value="{{ $filters['unit'] ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Category</label>
                            <input type="text" name="category" id="searchCategory" class="form-control" value="{{ $filters['category'] ?? '' }}">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-2">Search</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Reset</a>
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
<<<<<<< HEAD
</script>
<script src="{{ asset('js/productsScript.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs/dayjs.min.js"></script>
@endpush
=======

</script>
<script src="{{ asset('js/productsScript.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs/dayjs.min.js"></script>


@endpush
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
