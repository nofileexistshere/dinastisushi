<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Rating;

class MenuManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $category = $request->get('category', 'Semua');
        
        $query = MenuItem::query();
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }
        
        if ($category !== 'Semua') {
            $query->where('category', $category);
        }
        
        $menuItems = $query->orderBy('category')->orderBy('name')->paginate(15);
        
        return view('admin.menu.index', compact('menuItems', 'search', 'category'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:Nigiri,Maki,Sashimi,Special',
            'image' => 'required|url',
            'tags' => 'nullable|string',
        ]);
        
        $validated['tags'] = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];
        
        MenuItem::create($validated);
        
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        return view('admin.menu.edit', compact('menuItem'));
    }

    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:Nigiri,Maki,Sashimi,Special',
            'image' => 'required|url',
            'tags' => 'nullable|string',
        ]);
        
        $validated['tags'] = $request->tags ? array_map('trim', explode(',', $request->tags)) : [];
        
        $menuItem->update($validated);
        
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();
        
        return back()->with('success', 'Menu berhasil dihapus.');
    }
}
