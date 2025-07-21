<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    // List all services
    public function index()
    {
        $services = Service::all();
        return Inertia::render('Services/Index', compact('services'));
    }

    // Show form to create a new service
    public function create()
    {
        return Inertia::render('Services/Create');
    }

    // Store new service
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service created.');
    }

    // Show single service details
    public function show(Service $service)
    {
        return Inertia::render('Services/Show', compact('service'));
    }

    // Show form to edit a service
    public function edit(Service $service)
    {
        return Inertia::render('Services/Edit', compact('service'));
    }

    // Update service
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated.');
    }

    // Delete service
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted.');
    }
}
