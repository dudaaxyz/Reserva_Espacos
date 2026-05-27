<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;

class SpaceController extends Controller
{
    public function index()
    {
        $spaces = Space::where('is_active', true)->get();
        return view('spaces.index', compact('spaces'));
    }

    public function create()
    {
        return view('spaces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Space::create($request->only(['name', 'type', 'capacity', 'description']));
        return redirect()->route('spaces.index')->with('success', 'Espaço criado com sucesso!');
    }

    public function show(Space $space)
    {
        return view('spaces.show', compact('space'));
    }

    public function edit(Space $space)
    {
        return view('spaces.edit', compact('space'));
    }

    public function update(Request $request, Space $space)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $space->update($request->all());
        return redirect()->route('spaces.index')->with('success', 'Espaço atualizado com sucesso!');
    }

    public function destroy(Space $space)
    {
        $space->update(['is_active' => false]);
        return redirect()->route('spaces.index')->with('success', 'Espaço removido com sucesso!');
    }
}