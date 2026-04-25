@extends('admin.layouts.admin')

@section('title', 'Create Category - Grocery Mart Admin')
@section('page-title', 'Create New Category')

@section('content')
<div class="container-fluid">
    <div class="content-card">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <!-- Basic Information -->
                    <h5 class="mb-3">Category Information</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="e.g., Fresh Produce, Dairy, Beverages" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="4" placeholder="Describe what products belong in this category...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" 
                                   value="{{ old('order', 0) }}" min="0">
                            <small class="text-muted">Lower numbers appear first in the category list</small>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Category Slug (Optional)</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" 
                                   value="{{ old('slug') }}" placeholder="auto-generated if empty">
                            <small class="text-muted">URL-friendly name (e.g., fresh-produce)</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" checked>
                            <label class="form-check-label" for="is_active">
                                <span class="fw-600">Active</span> - Category will be visible in the store
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Category Image -->
                    <h5 class="mb-3">Category Image</h5>
                    
                    <div class="text-center mb-3">
                        <div class="image-preview mx-auto mb-3" id="imagePreview" 
                             style="width: 250px; height: 250px; border: 2px dashed var(--slate-300); border-radius: 12px; overflow: hidden; position: relative; background: var(--slate-50);">
                            <i class="bi bi-cloud-upload" id="imageIcon" style="font-size: 3rem; color: var(--slate-400); position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                            <img id="categoryImage" src="#" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                        </div>
                        
                        <div class="mt-2">
                            <input type="file" name="image" class="form-control" accept="image/*" 
                                   onchange="previewImage(this, 'categoryImage')">
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle"></i> Recommended size: 300x300px (Max: 2MB)<br>
                                <span class="text-primary">JPG, PNG, or WEBP format</span>
                            </small>
                        </div>
                    </div>

                    <!-- Category Preview Card (How it will look) -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="mb-3"><i class="bi bi-eye me-2"></i>Preview</h6>
                        <div class="border rounded overflow-hidden bg-white">
                            <div class="preview-image" style="height: 120px; background: linear-gradient(135deg, var(--primary), var(--dark)); display: flex; align-items: center; justify-content: center;">
                                <span class="text-white" id="previewEmoji">📦</span>
                            </div>
                            <div class="p-2">
                                <span class="fw-600" id="previewName">Category Name</span>
                                <span class="badge bg-light text-dark float-end">0 products</span>
                            </div>
                        </div>
                        <p class="small text-muted mt-2">This is how your category will appear in the list.</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="row mt-4">
                <div class="col-12">
                    <hr>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.categories.index') }}" class="btn-outline-custom px-4 py-2">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn-primary-custom px-4 py-2">
                            <i class="bi bi-check-lg me-2"></i> Create Category
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview category name in real-time
    document.querySelector('input[name="name"]').addEventListener('input', function() {
        const name = this.value || 'Category Name';
        document.getElementById('previewName').textContent = name;
        
        // Set preview emoji based on category name
        const previewEmoji = document.getElementById('previewEmoji');
        const categoryName = name.toLowerCase();
        
        if (categoryName.includes('fresh') || categoryName.includes('produce') || categoryName.includes('fruit') || categoryName.includes('vegetable')) {
            previewEmoji.textContent = '🥬';
        } else if (categoryName.includes('dairy') || categoryName.includes('milk') || categoryName.includes('cheese') || categoryName.includes('egg')) {
            previewEmoji.textContent = '🥛';
        } else if (categoryName.includes('beverage') || categoryName.includes('drink') || categoryName.includes('juice') || categoryName.includes('soda')) {
            previewEmoji.textContent = '🧃';
        } else if (categoryName.includes('snack') || categoryName.includes('chip') || categoryName.includes('cookie')) {
            previewEmoji.textContent = '🍪';
        } else if (categoryName.includes('bakery') || categoryName.includes('bread') || categoryName.includes('cake') || categoryName.includes('pastry')) {
            previewEmoji.textContent = '🥖';
        } else if (categoryName.includes('meat') || categoryName.includes('seafood') || categoryName.includes('fish') || categoryName.includes('chicken')) {
            previewEmoji.textContent = '🥩';
        } else if (categoryName.includes('frozen')) {
            previewEmoji.textContent = '❄️';
        } else if (categoryName.includes('pantry') || categoryName.includes('grain') || categoryName.includes('rice') || categoryName.includes('pasta')) {
            previewEmoji.textContent = '🍚';
        } else if (categoryName.includes('household') || categoryName.includes('clean')) {
            previewEmoji.textContent = '🧹';
        } else if (categoryName.includes('personal') || categoryName.includes('beauty') || categoryName.includes('care')) {
            previewEmoji.textContent = '🧴';
        } else {
            previewEmoji.textContent = '📦';
        }
    });

    // Image preview function
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const icon = document.getElementById('imageIcon');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (icon) icon.style.display = 'none';
                
                // Also update the preview emoji to show image will be used
                document.getElementById('previewEmoji').textContent = '🖼️';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-generate slug from name (optional feature)
    document.querySelector('input[name="name"]').addEventListener('blur', function() {
        const slugInput = document.querySelector('input[name="slug"]');
        if (slugInput && !slugInput.value) {
            // Simple slug generation
            let slug = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            slugInput.value = slug;
        }
    });
</script>
@endpush