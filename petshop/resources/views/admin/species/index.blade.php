@extends('layouts.app')

@section('title', 'Manage Species - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Species</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSpeciesModal">
            <i class="fas fa-plus"></i> Add New Species
        </button>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Total Pets</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($species as $specie)
                        <tr>
                            <td>{{ $specie->id }}</td>
                            <td>{{ $specie->name }}</td>
                            <td>{{ Str::limit($specie->description, 50) }}</td>
                            <td><span class="badge bg-primary">{{ $specie->pets_count }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editSpecies({{ $specie }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.species.destroy', $specie) }}" method="POST" class="d-inline">
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
                            <td colspan="5" class="text-center">No species found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $species->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Species Modal -->
<div class="modal fade" id="addSpeciesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Species</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.species.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Species</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Species Modal -->
<div class="modal fade" id="editSpeciesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Species</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSpeciesForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" id="editSpeciesContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Species</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editSpecies(species) {
    document.getElementById('editSpeciesForm').action = `/admin/species/${species.id}`;
    
    const content = `
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="${species.name}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">${species.description || ''}</textarea>
        </div>
    `;
    
    document.getElementById('editSpeciesContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('editSpeciesModal')).show();
}
</script>
@endpush