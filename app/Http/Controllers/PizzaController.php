<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function index()
    {
        return Pizza::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        return Pizza::create($request->all());
    }

    public function show(Pizza $pizza)
    {
        return $pizza;
    }

    public function update(Request $request, Pizza $pizza)
    {
        $request->validate([
            'name' => 'string',
            'description' => 'nullable|string',
            'price' => 'numeric',
        ]);

        $pizza->update($request->all());
        return $pizza;
    }

    public function destroy(Pizza $pizza)
    {
        $pizza->delete();
        return response()->noContent();
    }
}
