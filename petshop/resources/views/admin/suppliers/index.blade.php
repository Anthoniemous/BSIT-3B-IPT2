@extends('layouts.app')

@section('title', 'Manage Suppliers - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Suppliers</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
            <i class="fas fa-plus"></i> Add New Supplier
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
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->id }}</td>
                            <td>{{ $supplier->full_name }}</td>
                            <td>{{ $supplier->contact ?? 'N/A' }}</td>
                            <td>{{ Str::limit($supplier->address, 40) ?? 'N/A' }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editSupplier({{ $supplier }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" class="d-inline">
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
                            <td colspan="5" class="text-center">No suppliers found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Supplier Modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.suppliers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="firstname" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Middle Name</label>
                        <input type="text" name="middlename" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact</label>
                        <input type="text" name="contact" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Supplier Modal -->
<div class="modal fade" id="editSupplierModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSupplierForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" id="editSupplierContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editSupplier(supplier) {
    document.getElementById('editSupplierForm').action = `/admin/suppliers/${supplier.id}`;
    
    const content = `
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="firstname" class="form-control" value="${supplier.firstname}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="lastname" class="form-control" value="${supplier.lastname}" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Middle Name</label>
            <input type="text" name="middlename" class="form-control" value="${supplier.middlename || ''}">
        </div>
        <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" name="contact" class="form-control" value="${supplier.contact || ''}">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="3">${supplier.address || ''}</textarea>
        </div>
    `;
    
    document.getElementById('editSupplierContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('editSupplierModal')).show();
}
</script>
@endpush

<!-- resources/views/admin/sales/index.blade.php -->
@extends('layouts.app')

@section('title', 'Manage Sales - Admin')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4">Sales Management</h1>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Items</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>#{{ $sale->id }}</td>
                            <td>{{ $sale->user->full_name }}</td>
                            <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                            <td>₱{{ number_format($sale->total_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $sale->status == 'completed' ? 'success' : ($sale->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewItems({{ $sale->id }}, {{ json_encode($sale->salesDetails) }})">
                                    View ({{ $sale->salesDetails->count() }})
                                </button>
                            </td>
                            <td>
                                <form action="{{ route('admin.sales.updateStatus', $sale) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm d-inline-block" style="width: auto;" onchange="this.form.submit()">
                                        <option value="pending" {{ $sale->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ $sale->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $sale->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No sales found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</div>

<!-- View Items Modal -->
<div class="modal fade" id="viewItemsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="itemsContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewItems(orderId, items) {
    let content = '<table class="table"><thead><tr><th>Pet</th><th>Quantity</th><th>Subtotal</th></tr></thead><tbody>';
    
    items.forEach(item => {
        content += `
            <tr>
                <td>${item.pet.name}</td>
                <td>${item.quantity}</td>
                <td>₱${parseFloat(item.subtotal).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '@push('scripts')
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
@en,')}</td>
            </tr>
        `;
    });
    
    content += '</tbody></table>';
    
    document.getElementById('itemsContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('viewItemsModal')).show();
}
</script>
@endpush