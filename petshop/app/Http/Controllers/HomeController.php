<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Species;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPets = Pet::where('quantity', '>', 0)
            ->with(['species', 'trait'])
            ->latest()
            ->take(6)
            ->get();
        
        $species = Species::withCount('pets')->get();
        
        return view('home', compact('featuredPets', 'species'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you would send an email or save to database
        
        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    public function profile()
    {
        return view('profile');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        auth()->user()->update($request->all());

        return back()->with('success', 'Profile updated successfully!');
    }

    public function orders()
    {
        $orders = auth()->user()->sales()->with('salesDetails.pet')->latest()->paginate(10);
        
        return view('orders', compact('orders'));
    }
}