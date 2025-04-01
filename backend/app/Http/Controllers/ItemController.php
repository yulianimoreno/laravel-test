<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return response()->json($items, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $item = Item::create($validatedData);

        return response()->json([
            'message' => 'Item created successfully',
            'item' => $item
        ], Response::HTTP_CREATED);
    }

    
    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($item, Response::HTTP_OK);
    }

    
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'quantity' => 'integer|min:1',
            'price' => 'numeric|min:0',
        ]);

        $item->update($validatedData);

        return response()->json([
            'message' => 'Item updated successfully',
            'item' => $item
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted successfully'], Response::HTTP_OK);
    }

}
