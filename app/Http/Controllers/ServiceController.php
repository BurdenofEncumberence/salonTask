<?php

namespace App\Http\Controllers;

use App\Models\SalonService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $allServices = SalonService::latest()->paginate(10);
        return view('services.index', compact('allServices'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $req)
    {
        $validatedData = $req->validate([
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric|min:0',
            'service_duration' => 'required|string|max:100',
            'service_description' => 'nullable|string',
        ]);

        SalonService::create($validatedData);

        return redirect()->route('services.index')->with('success', 'Service added successfully!');
    }

    public function edit(SalonService $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $req, SalonService $service)
    {
        $validatedData = $req->validate([
            'service_name' => 'required|string|max:255',
            'service_price' => 'required|numeric|min:0',
            'service_duration' => 'required|string|max:100',
            'service_description' => 'nullable|string',
        ]);

        $service->update($validatedData);

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    public function destroy(SalonService $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }
}
