<?php

namespace App\Http\Controllers\Backend\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::where('tag_for', 'blog')
                          ->statusFilter(request('status'))
                          ->deletedItemFilter(request('deleted-items'))
                          ->latest()
                          ->get();
               
        return view('backend.blog-section.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blog-section.tag.create');
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
                'title' => 'required|string|min:2|max:255"|unique:tags,title',
            ]
        );

        $tag = Tag::create(
            [
                'tag_for' => 'blog',
                'title'        => request('title'),
                'slug'         => $this->setSlugAttribute(request('title')),
                'status'       => $request->status ? 1 : 0,
                'created_by'   => Auth::user()->id,
                'updated_by'   => Auth::user()->id,
            ]
        );

        if ($tag) {
            flash('Tag added successfully.')->success();
            return redirect(route('tags.index'));
        }

        flash('There was some intenal error while adding the tag.')->error();
        return redirect(route('tags.index'));
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
         $tag = Tag::where('tag_for', 'blog')->find($id);

        return view('backend.blog-section.tag.edit', compact('tag'));
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
        $tag = Tag::where('tag_for', 'blog')->find($id);

        $this->validate($request, [
            'title'     => 'required|string|min:2|max:255|unique:tags,title,'.$tag->id,
        ]);

        $tag->update([
            'title'      => request('title'),
            'status'     => request('status') ? 1 : 0,
            'updated_by' => Auth::user()->id,
        ]);

        if($tag) {
            flash('Tag updated successfully.')->info();
            return redirect(route('tags.index'));
        }
        flash('There was some intenal error while updating the tag.')->error();
        return redirect(route('tags.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::where('tag_for', 'blog')->find($id);
        
        if ($tag->delete()) {
            flash('Tag deleted successfully.')->error();
            return redirect(route('tags.index'));
        }
        flash('There was some intenal error while deleting the tag.')->error();
        return redirect(route('tags.index'));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $tag = Tag::where('tag_for', 'blog')->find($id);

        $tag->update(
            [
                'status'=> request('status')
            ]
        );

        if ($tag) {
            return [ 'success' => 'Tag updated successfully.'];
        }
        return [ 'error' => 'There was some intenal error while updating the tag.'];
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
        $tag = Tag::where('tag_for', 'blog')->withTrashed()->find($id);

        if ($tag->restore()) {
            flash('Tag restored successfully.')->info();
            return redirect(route('tags.index'));
        }
        flash('There was some intenal error while restoring the tag.')->error();
        return redirect(route('tags.index'));
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
        $tag = Tag::where('tag_for', 'blog')->withTrashed()->find($id);

        if ($tag->forcedelete()) {
            flash('Tag deleted permanently.')->error();
            return redirect(route('tags.index'));
        }
        flash('There was some intenal error while deleting the tag permanently.')->error();
        return redirect(route('tags.index'));
    }

    /**
     * Creating the unique slug.
     *
     */
    private function setSlugAttribute($slug)
    {
        $slug = str_slug($slug);
        $slugs = Tag::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
