<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Species;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\Traits;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPets = Pet::sum('quantity');
        $totalSales = Sale::where('status', 'completed')->sum('total_amount');
        $pendingOrders = Sale::where('status', 'pending')->count();
        $totalSpecies = Species::count();

        return view('admin.dashboard', compact('totalPets', 'totalSales', 'pendingOrders', 'totalSpecies'));
    }

    // Pets CRUD
    public function index()
    {
        $pets = Pet::with(['species', 'supplier'])->paginate(15);
        $species = Species::all();
        $suppliers = Supplier::all();
        $traits = Traits::all();
        
        return view('admin.pets.index', compact('pets', 'species', 'suppliers', 'traits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'species_id' => 'required|exists:species,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'trait_id' => 'nullable|exists:traits,id',
            'arrival_date' => 'nullable|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('pets', 'public');
        }

        Pet::create($validated);

        return back()->with('success', 'Pet added successfully!');
    }

    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'species_id' => 'required|exists:species,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'trait_id' => 'nullable|exists:traits,id',
            'arrival_date' => 'nullable|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('pets', 'public');
        }

        $pet->update($validated);

        return back()->with('success', 'Pet updated successfully!');
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();
        return back()->with('success', 'Pet deleted successfully!');
    }

    // Species Management
    public function speciesIndex()
    {
        $species = Species::withCount('pets')->paginate(15);
        return view('admin.species.index', compact('species'));
    }

    public function speciesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:species,name',
            'description' => 'nullable|string',
        ]);

        Species::create($request->all());

        return back()->with('success', 'Species added successfully!');
    }

    public function speciesUpdate(Request $request, Species $species)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:species,name,' . $species->id,
            'description' => 'nullable|string',
        ]);

        $species->update($request->all());

        return back()->with('success', 'Species updated successfully!');
    }

    public function speciesDestroy(Species $species)
    {
        $species->delete();
        return back()->with('success', 'Species deleted successfully!');
    }

    // Suppliers Management
    public function suppliersIndex()
    {
        $suppliers = Supplier::paginate(15);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function suppliersStore(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        return back()->with('success', 'Supplier added successfully!');
    }

    public function suppliersUpdate(Request $request, Supplier $supplier)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $supplier->update($request->all());

        return back()->with('success', 'Supplier updated successfully!');
    }

    public function suppliersDestroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Supplier deleted successfully!');
    }

    // Sales Management
    public function salesIndex()
    {
        $sales = Sale::with(['user', 'salesDetails'])->latest()->paginate(15);
        return view('admin.sales.index', compact('sales'));
    }

    public function updateSaleStatus(Request $request, Sale $sale)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $sale->update(['status' => $request->status]);

        return back()->with('success', 'Sale status updated successfully!');
    }
}