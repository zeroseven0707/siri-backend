<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $services = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.services.partials.table', compact('services'))->render(),
                'pagination' => view('admin.partials.pagination', ['data' => $services])->render(),
            ]);
        }

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'icon'         => 'nullable|image|max:5120',
            'base_price'   => 'required|numeric|min:0',
            'vehicle_type' => 'required|in:motor,mobil',
            'is_active'    => 'boolean',
        ]);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('services', 'public');
        }

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']) . '-' . \Illuminate\Support\Str::random(5);

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'icon'         => 'nullable|image|max:5120',
            'base_price'   => 'required|numeric|min:0',
            'vehicle_type' => 'required|in:motor,mobil',
            'is_active'    => 'boolean',
        ]);

        if ($request->hasFile('icon')) {
            if ($service->icon) {
                Storage::disk('public')->delete($service->icon);
            }
            $validated['icon'] = $request->file('icon')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        if ($service->icon) {
            Storage::disk('public')->delete($service->icon);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully');
    }
}
