<?php

namespace App\Http\Controllers;

use App\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ingredient = new Ingredient();
        $ingredient->name = $validatedData['name'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('public/images');
            $ingredient->image_path = $path;
        }

        $ingredient->save();

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient created successfully.');
    }

    public function show($id)
    {
        $ingredient = Ingredient::find($id);
        return view('ingredients.show', compact('ingredient'));
    }

    public function edit($id)
    {
        $ingredient = Ingredient::find($id);
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ingredient = Ingredient::find($id);
        $ingredient->name = $validatedData['name'];

        if ($request->hasFile('image')) {
            // Delete the old image from storage
            Storage::delete($ingredient->image_path);

            // Save the new image to storage
            $image = $request->file('image');
            $path = $image->store('public/images');
            $ingredient->image_path = $path;
        }

        $ingredient->save();

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient updated successfully.');
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::find($id);
    
        if (!$ingredient) {
            return redirect()->route('ingredients.index')->with('error', 'Ingredient not found.');
        }
    
        // Delete the image from storage
        Storage::delete($ingredient->image_path);
    
        // Delete the ingredient from the database
        $ingredient->delete();
    
        return redirect()->route('ingredients.index')->with('success', 'Ingredient deleted successfully.');
    }
}