<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::with('parent')->orderBy('sort_order')->paginate(10);
        return view('portal.categories.index', compact('categories'));
    }

    public function create() {
        $category = new Category();
        $parents = Category::whereNull('parent_id')->get();
        return view('portal.categories.form', compact('category', 'parents'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ]);

        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('dashboard.categories.index')->with('success', 'Category added successfully!');
    }

    public function edit(Category $category) {
        $parents = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('portal.categories.form', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category) {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ]);

        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if($request->hasFile('image')) {
            if($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category) {
        if($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully!');
    }
}
