@extends('layouts.app')

@section('title', 'Manage Pets - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Pets</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPetModal">
            <i class="fas fa-plus"></i> Add New Pet
        </button>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Species</th>
                            <th>Breed</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pets as $pet)
                        <tr>
                            <td>{{ $pet->id }}</td>
                            <td>
                                @if($pet->image)
                                    <img src="{{ asset('storage/' . $pet->image) }}" width="50" height="50" class="rounded">
                                @else
                                    <img src="https://via.placeholder.com/50" class="rounded">
                                @endif
                            </td>
                            <td>{{ $pet->name }}</td>
                            <td>{{ $pet->species->name }}</td>
                            <td>{{ $pet->breed ?? 'N/A' }}</td>
                            <td>₱{{ number_format($pet->price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $pet->quantity > 0 ? 'success' : 'danger' }}">
                                    {{ $pet->quantity }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editPet({{ $pet }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.pets.destroy', $pet) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No pets found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pets->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Pet Modal -->
<div class="modal fade" id="addPetModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Pet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.pets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Breed</label>
                            <input type="text" name="breed" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Species</label>
                            <select name="species_id" class="form-select" required>
                                <option value="">Select Species</option>
                                @foreach($species as $specie)
                                    <option value="{{ $specie->id }}">{{ $specie->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Supplier</label>
                            <select name="supplier_id" class="form-select">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trait</label>
                            <select name="trait_id" class="form-select">
                                <option value="">Select Trait</option>
                                @foreach($traits as $trait)
                                    <option value="{{ $trait->id }}">{{ $trait->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Arrival Date</label>
                            <input type="date" name="arrival_date" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Pet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Pet Modal -->
<div class="modal fade" id="editPetModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPetForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body" id="editPetContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Pet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editPet(pet) {
    document.getElementById('editPetForm').action = `/admin/pets/${pet.id}`;
    
    const content = `
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="${pet.name}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Breed</label>
                <input type="text" name="breed" class="form-control" value="${pet.breed || ''}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="${pet.price}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" value="${pet.quantity}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Species</label>
                <select name="species_id" class="form-select" required>
                    @foreach($species as $specie)
                        <option value="{{ $specie->id }}" ${pet.species_id == {{ $specie->id }} ? 'selected' : ''}>{{ $specie->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Supplier</label>
                <select name="supplier_id" class="form-select">
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" ${pet.supplier_id == {{ $supplier->id }} ? 'selected' : ''}>{{ $supplier->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">${pet.description || ''}</textarea>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Image (leave empty to keep current)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
        </div>
    `;
    
    document.getElementById('editPetContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('editPetModal')).show();
}
</script>
@endpush