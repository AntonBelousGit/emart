<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories_count = Category::count();
        $categories = Category::with('parent')->orderBy('id', 'DESC')->get();
        return view('backend.categories.index', compact('categories', 'categories_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();

        return view('backend.categories.create', compact('parent_cats'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_data = $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|nullable',
            'photo' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:active,inactive'
        ]);

        $slug = Str::slug($request->input('title'));
        $slug_count = Category::where('slug', $slug)->count();
        if ($slug_count > 0) {
            $slug = time() . '_' . $slug;
        }
        $validate_data['slug'] = $slug;
        if (!isset($request->is_parent)) {
            $validate_data['is_parent'] = 0;
        }
        $category = Category::create($validate_data);
        if ($category) {
            return redirect()->route('category.index')->with('success', 'Successfully created category');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $parent_cats = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();
        if ($category) {
            return view('backend.categories.edit', compact('category', 'parent_cats'));
        } else {
            return back()->with('error', 'Category not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
//        dd($request);
        $category = Category::find($id);
        if ($category) {
            $validate_data = $this->validate($request, [
                'title' => 'string|required',
                'summary' => 'string|nullable',
                'photo' => 'required',
                'parent_id' => 'nullable|exists:categories,id',
                'status' => 'required|in:active,inactive',
                'is_parent' => 'sometimes|in:1'
            ]);

//            $slug = Str::slug($request->input('title'));
//            $slug_count = Category::where('slug', $slug)->count();
//            if ($slug_count > 0) {
//                $slug = time() . '_' . $slug;
//            }
//            $validate_data['slug'] = $slug;

            if (!isset($request->is_parent)) {
                $validate_data['is_parent'] = 0;
            } else {
                $validate_data['parent_id'] = null;
            }

//            dd($validate_data);
            $category = $category->fill($validate_data)->save();
            if ($category) {
                return redirect()->route('category.index')->with('success', 'Successfully updated category');
            } else {
                return back()->with('error', 'Something went wrong!');
            }
        } else {
            return back()->with('error', 'Category not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $category = Category::find($id);
        $child_cat_id = Category::where('parent_id', $id)->pluck('id');
        if ($category) {
            $status = $category->delete();
            if ($status) {
                if (count($child_cat_id) > 0) {
                    Category::shiftChild($child_cat_id);
                }
                return redirect()->route('category.index')->with('success', 'Successfully deleted category');
            }
            return back()->with('error', 'Something went wrong!');
        }
        return back()->with('error', 'Data not found');
    }

    public function categoryStatus(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('categories')->where('id', $request->id)->update(['status' => 'active']);
        } else {
            DB::table('categories')->where('id', $request->id)->update(['status' => 'inactive']);
        }

        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }

    public function getChildByParentID(Request $request, $id)
    {
        $category = Category::find($request->id);
        if ($category) {
            $child_id = Category::getChildByParentID($request->id);
            if (count($child_id) <= 0) {
                return response()->json(['status' => false, 'data' => null, 'msg' => '']);
            }
            return response()->json(['status' => true, 'data' => $child_id, 'msg' => '']);
        }
        return response()->json(['status' => false, 'data' => null, 'msg' => 'Category not found']);
    }
}
