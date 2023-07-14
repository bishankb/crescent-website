<?php

namespace App\Http\Controllers\Backend\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('category_for', 'blog')
                          ->statusFilter(request('status'))
                          ->deletedItemFilter(request('deleted-items'))
                          ->latest()
                          ->get();
               
        return view('backend.blog-section.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blog-section.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => 'required|string|min:2|max:255"|unique:categories,title',
            ]
        );

        $category = Category::create(
            [
                'category_for' => 'blog',
                'title'        => request('title'),
                'slug'         => $this->setSlugAttribute(request('title')),
                'status'       => $request->status ? 1 : 0,
                'created_by'   => Auth::user()->id,
                'updated_by'   => Auth::user()->id,
            ]
        );

        if ($category) {
            flash('Category added successfully.')->success();
            return redirect(route('categories.index'));
        }

        flash('There was some intenal error while adding the category.')->error();
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $category = Category::where('category_for', 'blog')->find($id);

        return view('backend.blog-section.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::where('category_for', 'blog')->find($id);

        $this->validate($request, [
            'title'     => 'required|string|min:2|max:255|unique:categories,title,'.$category->id,
        ]);

        $category->update([
            'title'      => request('title'),
            'status'     => request('status') ? 1 : 0,
            'updated_by' => Auth::user()->id,
        ]);

        if($category) {
            flash('Category updated successfully.')->info();
            return redirect(route('categories.index'));
        }
        flash('There was some intenal error while updating the category.')->error();
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('category_for', 'blog')->find($id);
        
        if ($category->delete()) {
            flash('Category deleted successfully.')->error();
            return redirect(route('categories.index'));
        }
        flash('There was some intenal error while deleting the category.')->error();
        return redirect(route('categories.index'));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $category = Category::where('category_for', 'blog')->find($id);

        $category->update(
            [
                'status'=> request('status')
            ]
        );

        if ($category) {
            return [ 'success' => 'Category updated successfully.'];
        }
        return [ 'error' => 'There was some intenal error while updating the category.'];
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $category = Category::where('category_for', 'blog')->withTrashed()->find($id);

        if ($category->restore()) {
            flash('Category restored successfully.')->info();
            return redirect(route('categories.index'));
        }
        flash('There was some intenal error while restoring the category.')->error();
        return redirect(route('categories.index'));
    }

    /**
     * Force remove the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($id)
    {
        $category = Category::where('category_for', 'blog')->withTrashed()->find($id);

        if ($category->forcedelete()) {
            flash('Category deleted permanently.')->error();
            return redirect(route('categories.index'));
        }
        flash('There was some intenal error while deleting the category permanently.')->error();
        return redirect(route('categories.index'));
    }

    /**
     * Creating the unique slug.
     *
     */
    private function setSlugAttribute($slug)
    {
        $slug = str_slug($slug);
        $slugs = Category::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
                    ->orderBy('id')
                    ->pluck('slug');
        if (count($slugs) == 0) {
            return $slug;
        } elseif (! $slugs->isEmpty()) {
            $pieces = explode('-', $slugs);
            $number = (int) end($pieces);
            return $slug .= '-' . ($number + 1);
        }
    }
}
