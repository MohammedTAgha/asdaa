@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Attributes for: {{ $category->name }}</h5>
                        <small class="text-muted">{{ $category->type }}</small>
                    </div>
                    <div>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Back to Categories
                        </a>
                        <a href="{{ route('categories.attributes.create', $category) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Attribute
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 50px">Order</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Required</th>
                                    <th>Options</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @forelse($attributes as $attribute)
                                    <tr data-id="{{ $attribute->id }}">
                                        <td>
                                            <i class="fas fa-grip-vertical handle" style="cursor: move"></i>
                                            {{ $attribute->order }}
                                        </td>
                                        <td>{{ $attribute->name }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $attribute->type }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $attribute->is_required ? 'danger' : 'secondary' }}">
                                                {{ $attribute->is_required ? 'Required' : 'Optional' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($attribute->options)
                                                <ul class="list-unstyled mb-0">
                                                    @foreach($attribute->options as $option)
                                                        <li>{{ $option }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">No options</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('categories.attributes.edit', [$category, $attribute]) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('categories.attributes.destroy', [$category, $attribute]) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this attribute?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No attributes found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    $("#sortable").sortable({
        handle: '.handle',
        update: function(event, ui) {
            let order = [];
            $('tr[data-id]').each(function(index) {
                order.push({
                    id: $(this).data('id'),
                    order: index + 1
                });
            });

            $.ajax({
                url: '{{ route("categories.attributes.reorder", $category) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order: order
                },
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    }
                }
            });
        }
    });
});
</script>
@endpush
@endsection 