@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        {{ isset($attribute) ? 'Edit Attribute' : 'Add New Attribute' }} for {{ $category->name }}
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ isset($attribute) ? route('categories.attributes.update', [$category, $attribute]) : route('categories.attributes.store', $category) }}" 
                          method="POST">
                        @csrf
                        @if(isset($attribute))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $attribute->name ?? '') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">Type <span class="text-danger">*</span></label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="text" {{ (old('type', $attribute->type ?? '') == 'text') ? 'selected' : '' }}>Text</option>
                                <option value="number" {{ (old('type', $attribute->type ?? '') == 'number') ? 'selected' : '' }}>Number</option>
                                <option value="date" {{ (old('type', $attribute->type ?? '') == 'date') ? 'selected' : '' }}>Date</option>
                                <option value="select" {{ (old('type', $attribute->type ?? '') == 'select') ? 'selected' : '' }}>Select</option>
                                <option value="multiselect" {{ (old('type', $attribute->type ?? '') == 'multiselect') ? 'selected' : '' }}>Multi Select</option>
                                <option value="textarea" {{ (old('type', $attribute->type ?? '') == 'textarea') ? 'selected' : '' }}>Text Area</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="2">{{ old('description', $attribute->description ?? '') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_required" name="is_required" 
                                       value="1" {{ old('is_required', $attribute->is_required ?? false) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_required">Required Field</label>
                            </div>
                        </div>

                        <div id="options-container" class="form-group" style="display: none;">
                            <label for="options">Options (one per line)</label>
                            <textarea class="form-control @error('options') is-invalid @enderror" 
                                      id="options" name="options" rows="4">{{ old('options', isset($attribute) ? implode("\n", $attribute->options ?? []) : '') }}</textarea>
                            <small class="form-text text-muted">Enter each option on a new line</small>
                            @error('options')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="validation_rules">Validation Rules</label>
                            <input type="text" class="form-control @error('validation_rules') is-invalid @enderror" 
                                   id="validation_rules" name="validation_rules" 
                                   value="{{ old('validation_rules', isset($attribute) ? implode('|', $attribute->validation_rules ?? []) : '') }}"
                                   placeholder="e.g., min:1|max:100">
                            <small class="form-text text-muted">Enter Laravel validation rules separated by |</small>
                            @error('validation_rules')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($attribute) ? 'Update Attribute' : 'Create Attribute' }}
                            </button>
                            <a href="{{ route('categories.attributes.index', $category) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    function toggleOptions() {
        const type = $('#type').val();
        if (type === 'select' || type === 'multiselect') {
            $('#options-container').show();
        } else {
            $('#options-container').hide();
        }
    }

    $('#type').change(toggleOptions);
    toggleOptions(); // Initial state
});
</script>
@endpush
@endsection 