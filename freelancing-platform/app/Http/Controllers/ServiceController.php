<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the user's services.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user

        // Get the services for the authenticated user
        $services = $user->services()->latest()->paginate(10);

        // Pass the services to the view
        return view('services.index', compact('services', 'user'));
    }

    /**
     * Show the form for creating a new service.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user=Auth::user();
        return view('services.create',compact('user'));
    }

    /**
     * Store a newly created service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tag' => 'nullable|string|max:50',
        ]);

        $serviceData = $request->all();

        // Handle file upload if there's an image
        if ($request->hasFile('image')) {
            $serviceData['image'] = $request->file('image')->store('service_images', 'public');
        }

        Auth::user()->services()->create($serviceData);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }
    /**
     * Show the form for editing the specified service.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\View\View
     */
    public function edit(Service $service)
    {
        $this->authorize('update', $service);

        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    public function exploreMarket(Request $request)
    {
        $query = $request->input('query'); // Get the search query
        $services = [];
        $user=Auth::user();

        if ($query) {
            // Search services where the tag matches the query
            $services = Service::where('tag', 'LIKE', '%' . $query . '%')->paginate(10);
        }

        return view('market.explore', compact('services', 'query','user'));
    }


    public function show($id)
    {
        // Retrieve the service by its ID
        $service = Service::with('user')->findOrFail($id);
        $user=Auth::user();

        // Pass the service data to the view
        return view('services.show', compact('service','user'));
    }




}
