@extends('admin.layouts.admin')

@section('title', 'Create Product - Grocery Mart Admin')
@section('page-title', 'Create New Product')

@section('content')
<div class="container-fluid">
    <div class="content-card">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf

            <div class="row">
                <!-- Basic Information -->
                <div class="col-md-8">
                    <h5 class="mb-3">Basic Information</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Brand <span class="text-danger">*</span></label>
                            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" 
                                   value="{{ old('brand') }}" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">SKU (Optional)</label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" 
                                   value="{{ old('sku') }}" placeholder="Unique product code">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Pricing and Stock -->
                <div class="col-md-4">
                    <h5 class="mb-3">Pricing & Stock</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Price (₱) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price') }}" step="0.01" min="0" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                               value="{{ old('stock', 0) }}" min="0" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Weight</label>
                            <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" 
                                   value="{{ old('weight') }}" step="0.01" min="0">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Unit</label>
                            <select name="unit" class="form-select">
                                <option value="pcs">Pieces (pcs)</option>
                                <option value="kg">Kilogram (kg)</option>
                                <option value="g">Gram (g)</option>
                                <option value="liter">Liter (L)</option>
                                <option value="ml">Milliliter (ml)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" class="form-check-input" value="1" id="is_featured">
                            <label class="form-check-label" for="is_featured">Mark as Featured Product</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" checked>
                            <label class="form-check-label" for="is_active">Active (Visible in store)</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Image - Professional Product Image Upload -->
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="mb-3">Product Image</h5>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="border rounded p-4" style="background: var(--slate-50);">
                                <div class="row align-items-center">
                                    <!-- Image Preview - 200x200 (Standard product thumbnail size) -->
                                    <div class="col-md-3 text-center">
                                        <div class="image-preview mx-auto" id="mainImagePreview" 
                                             style="width: 200px; height: 200px; border: 2px dashed var(--slate-300); border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                            <i class="bi bi-cloud-upload" id="mainImageIcon" style="font-size: 3rem; color: var(--slate-400);"></i>
                                            <img id="mainImage" src="#" alt="Preview" style="width: 100%; height: 100%; object-fit: contain; display: none;">
                                        </div>
                                    </div>
                                    
                                    <!-- Upload Controls and Guidelines -->
                                    <div class="col-md-9">
                                        <h6 class="mb-3">Upload Product Image</h6>
                                        
                                        <div class="mb-3">
                                            <input type="file" name="image" id="mainImageInput" class="form-control form-control-lg" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" 
                                                   onchange="validateAndPreviewImage(this, 'mainImage', 'mainImageIcon')">
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center text-success mb-2">
                                                    <i class="bi bi-check-circle-fill me-2"></i>
                                                    <span class="small">Max file size: 5MB</span>
                                                </div>
                                                <div class="d-flex align-items-center text-success mb-2">
                                                    <i class="bi bi-check-circle-fill me-2"></i>
                                                    <span class="small">Recommended: 500x500px</span>
                                                </div>
                                                <div class="d-flex align-items-center text-success mb-2">
                                                    <i class="bi bi-check-circle-fill me-2"></i>
                                                    <span class="small">Square images work best</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex flex-wrap gap-1 mb-2">
                                                    <span class="badge bg-light text-dark p-2">JPEG</span>
                                                    <span class="badge bg-light text-dark p-2">PNG</span>
                                                    <span class="badge bg-light text-dark p-2">GIF</span>
                                                    <span class="badge bg-light text-dark p-2">WEBP</span>
                                                </div>
                                                <small class="text-danger" id="mainImageError"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="row mt-4">
                <div class="col-12">
                    <hr>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.products.index') }}" class="btn-outline-custom">Cancel</a>
                        <button type="submit" class="btn-primary-custom" id="submitBtn">
                            <i class="bi bi-check-lg"></i> Create Product
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Image Size Error Modal -->
<div class="modal fade" id="imageErrorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Image Upload Error</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="imageErrorMessage">
                Image size exceeds the maximum allowed size of 5MB.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Maximum file size in bytes (5MB)
    const MAX_FILE_SIZE = 5 * 1024 * 1024;

    // Validate and preview main image
    function validateAndPreviewImage(input, previewId, iconId) {
        const preview = document.getElementById(previewId);
        const icon = document.getElementById(iconId);
        const errorSpan = document.getElementById('mainImageError');
        
        // Clear previous error
        if (errorSpan) errorSpan.textContent = '';
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Check file size
            if (file.size > MAX_FILE_SIZE) {
                showImageError(`Image "${file.name}" exceeds 5MB. Please choose a smaller file.`);
                input.value = ''; // Clear the input
                preview.src = '#';
                preview.style.display = 'none';
                if (icon) icon.style.display = 'block';
                return;
            }
            
            // Check file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                showImageError(`Invalid file type. Please upload JPEG, PNG, GIF, or WEBP images only.`);
                input.value = ''; // Clear the input
                preview.src = '#';
                preview.style.display = 'none';
                if (icon) icon.style.display = 'block';
                return;
            }
            
            // Preview the image
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                preview.style.objectFit = 'contain'; // Use contain to show full image without cropping
                if (icon) icon.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    }

    // Show image error modal
    function showImageError(message) {
        document.getElementById('imageErrorMessage').textContent = message;
        const modal = new bootstrap.Modal(document.getElementById('imageErrorModal'));
        modal.show();
    }

    // Form submission validation
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const mainImage = document.getElementById('mainImageInput');
        
        // Validate main image size (if selected)
        if (mainImage.files.length > 0) {
            if (mainImage.files[0].size > MAX_FILE_SIZE) {
                e.preventDefault();
                showImageError('Main image exceeds 5MB. Please choose a smaller file.');
                return false;
            }
        }
    });
</script>
@endpush