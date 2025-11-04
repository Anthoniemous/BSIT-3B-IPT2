<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Species;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function shop(Request $request)
    {
        $query = Pet::with(['species', 'trait'])->where('quantity', '>', 0);

        if ($request->has('species') && $request->species != '') {
            $query->where('species_id', $request->species);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('breed', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $pets = $query->paginate(12);
        $species = Species::all();

        return view('shop', compact('pets', 'species'));
    }

    public function show($id)
    {
        $pet = Pet::with(['species', 'trait', 'supplier'])->findOrFail($id);
        $relatedPets = Pet::where('species_id', $pet->species_id)
            ->where('id', '!=', $pet->id)
            ->where('quantity', '>', 0)
            ->take(4)
            ->get();

        return view('pets.show', compact('pet', 'relatedPets'));
    }
}