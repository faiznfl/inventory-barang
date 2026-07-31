<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Category::withCount('products')->latest();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->paginate(10)->withQueryString();

        $topCategory = Category::withCount('products')->orderByDesc('products_count')->first();
        $topCategoryName = $topCategory?->name ?? '-';
        $topCategoryCount = $topCategory?->products_count ?? 0;

        $totalInventoryItems = Product::sum('stock');

        return view('categories.index', compact(
            'categories',
            'topCategoryName',
            'topCategoryCount',
            'totalInventoryItems'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Kategori baru berhasil ditambahkan ke dalam sistem.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Data kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
