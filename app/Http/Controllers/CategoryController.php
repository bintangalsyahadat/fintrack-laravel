<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Http\Resources\CategoryResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Categories::where('user_id', Auth::id())->get();

        // API
        if ($request->wantsJson()) {
            return CategoryResource::collection($categories);
        }

        // Web
        return view('pages.categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        try {
            $category = Categories::create([
                'user_id' => Auth::id(),
                'name'    => $validated['name'],
                'type'    => $validated['type'],
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Category created successfully',
                    'data' => new CategoryResource($category)
                ], 201);
            }

            return redirect()
                ->route('web.categories.index')
                ->with('success', 'Category created successfully');
        } catch (Exception $error) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to create category'
                ], 500);
            }

            return back()->withErrors('Failed to create category');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $category = Categories::find($id);
        if ($this->authorizeCategory($id) === false) {
            return $this->notFoundResponse();
        };

        if ($request->wantsJson()) {
            return new CategoryResource($category);
        }

        return view('categories.show', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Categories::find($id);
        if ($this->authorizeCategory($id) === false) {
            return $this->notFoundResponse();
        };

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        try {
            $category->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Category updated successfully',
                    'data' => new CategoryResource($category)
                ], 201);
            }

            return redirect()
                ->route('web.categories.index')
                ->with('success', 'Category updated successfully');
        } catch (Exception $error) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to update category'
                ], 500);
            }

            return back()->withErrors('Failed to update category');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $category = Categories::find($id);
        if ($this->authorizeCategory($id) === false) {
            return $this->notFoundResponse();
        };

        try {
            $category->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Category deleted successfully',
                    'data' => new CategoryResource($category)
                ], 201);
            }

            return redirect()
                ->route('web.categories.index')
                ->with('success', 'Category deleted successfully');
        } catch (Exception $error) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Failed to delete category'
                ], 500);
            }

            return back()->withErrors('Failed to delete category');
        }
    }


    /**
     * Ensure category belongs to authenticated user
     */
    private function authorizeCategory(string $id)
    {
        $category = Categories::find($id);
        if ($category === null) {
            return false;
        }

        if ($category->user_id !== Auth::id()) {
            return false;
        };

        return true;
    }

    private function notFoundResponse()
    {
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        return back()->withErrors('Category not found');
    }
}
