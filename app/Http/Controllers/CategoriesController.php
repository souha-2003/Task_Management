<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Gate;

class CategoriesController extends Controller
{
    //
    public function index(){
        $categories = Category::withCount(['tasks' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->get();
        return view('categories.index', compact('categories'));
    }
 
    public function create(){
        Gate::authorize('manage categories');
        $category = new Category();
        return view('categories.create', compact('category'));
    }

    public function store(StoreCategoryRequest $request){
        Gate::authorize('manage categories');
        $validated = $request->validated();

        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category){
        Gate::authorize('manage categories');
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category){
        Gate::authorize('manage categories');
        $validated = $request->validated();

        $category->update($validated);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function show(Category $category){
        // جلب المهام المرتبطة بهذا التصنيف والتي تخص المستخدم الحالي فقط
        $tasks = $category->tasks()->where('user_id', auth()->id())->get();
        return view('categories.show', compact('category', 'tasks'));
    }

    public function destroy(Category $category){
        Gate::authorize('manage categories');
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
