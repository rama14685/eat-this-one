<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\Category;
use App\Models\Product;
use App\Models\RunningText;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::where('is_active', true)->with('category')->get();
        $addOns = AddOn::where('is_active', true)->orderBy('name')->get();
        $runningTexts = RunningText::where('is_active', true)->orderBy('sort_order')->get();
        $addOnPayloads = $addOns->map(fn (AddOn $addOn): array => [
            'id' => $addOn->id,
            'name' => $addOn->name,
            'price' => $addOn->price,
            'image' => $addOn->image ? rtrim(config('app.url'), '/').'/storage/'.ltrim($addOn->image, '/') : null,
        ])->values()->all();

        return view('catalog', compact('categories', 'products', 'addOns', 'addOnPayloads', 'runningTexts'));
    }
}
