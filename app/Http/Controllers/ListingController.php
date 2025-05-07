<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotUserMiddleware;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ListingController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [new Middleware(['auth', 'verified', NotUserMiddleware::class], except: ['index', 'show'])];
    }
    public function index(Request $request)
    {
        $listings = Listing::whereHas('user', callback: function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })
            ->with('user')
            ->where('approved', true)
            ->filter(request(['search', 'user_id', 'tag']))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $searchTerm = $request->search;
        $msg = session('msg');

        return inertia('Listing/Index', compact('listings', 'searchTerm', 'msg'));
    }

    public function create()
    {
        Gate::authorize('create', Listing::class);
        return inertia('Listing/Create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Listing::class);

        // $newTags = explode(',', $request->tags);
        // $newTags = array_map('trim', $newTags);
        // $newTags = array_filter($newTags);
        // $newTags = array_unique($newTags);
        // $newTags = implode(',', $newTags);

        // $newTags = implode(',', array_unique(array_filter(array_map('trim',explode(',', $request->tags)))));

        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'email' => 'nullable|email',
            'link' => 'nullable|url',
            'image' => 'nullable|file|max:1042|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('image')) {
            $fields['image'] = Storage::disk('public')->put('images/listing', $request->image);
        }

        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags)))));

        $request->user()->listings()->create($fields);

        return redirect()->route('dashboard')->with('msg', 'Listing created successfully.');
    }

    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);
        $user = $listing->user->only('id', 'name');
        $canModify = Auth::user() ? Auth::user()->can('modify', $listing) : false;
        return inertia('Listing/Show', compact('listing', 'user', 'canModify'));
    }

    public function edit(Listing $listing)
    {
        Gate::authorize('modify', $listing);
        return inertia('Listing/Edit', compact('listing'));
    }

    public function update(Request $request, Listing $listing)
    {
        Gate::authorize('modify', $listing);
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'email' => 'nullable|email',
            'link' => 'nullable|url',
            'image' => 'nullable|file|max:1042|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('image')) {
            if ($listing->image) {
                Storage::disk('public')->delete($listing->image);
            }
            $fields['image'] = Storage::disk('public')->put('images/listing', $request->image);
        } else {
            $fields['image'] = $listing->image;
        }

        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags)))));

        $listing->update([...$fields, 'approved' => false]);

        return redirect()->route('dashboard')->with('msg', 'Listing updated successfully.');
    }

    public function destroy(Listing $listing)
    {
        Gate::authorize('modify', $listing);
        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }
        $listing->delete();

        return redirect()->route('dashboard')->with('msg', 'Listing deleted successfully.');
    }
}
