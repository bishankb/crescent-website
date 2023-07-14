<?php

namespace App\Http\Controllers\Backend\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;
use App\Category;
use App\Tag;
use App\Media;
use Auth;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:view_blogs', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_blogs', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_blogs', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_blogs', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::statusFilter(request('status'))
                       ->deletedItemFilter(request('deleted-items'))
                       ->latest()
                       ->get();
               
        return view('backend.blog-section.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->select('id', 'title')->get();
        $tags = Tag::where('status', 1)->select('id', 'title')->get();

        return view('backend.blog-section.blog.create', compact('categories', 'tags'));
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
                'title'        => 'required|min:3',
                'description'  => 'required|min:3',
                'category'     => 'required',
                'blog_image'   => 'image|mimes:jpg,png,jpeg|max:2048'
            ]
        );

        $categoryName = $request->category;
        if (isset($categoryName)) {
            $category = Category::where('title', $categoryName)->first();
            if (!(isset($category))) {
                $category = Category::create([
                    'title'        => $categoryName,
                    'slug'         => $this->setSlugAttribute($categoryName),
                    'category_for' => 'blog',
                    'status'       => 1,
                    'created_by'   => Auth::user()->id,
                    'updated_by'   => Auth::user()->id
                ]);
            }
        }

        $tagsNames = $request->tags;
        if (isset($tagsNames)) {
            $tagsIds = [];
            foreach ($tagsNames as $tagsName) {
                $tag = Tag::where('title', $tagsName)->first();
                if (!(isset($tag))) {
                    $tag = Tag::create([
                        'title'      => $tagsName,
                        'slug'       => $this->setSlugAttribute($tagsName),
                        'tag_for'    => 'blog',
                        'status'     => 1,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id
                    ]);
                }
                array_push($tagsIds, $tag->id);
            }
        }

        if ($request->file('blog_image')) {
            $requestFile = $request->file('blog_image');
            $storeFile = $request->file('blog_image')->store('public/media/blog');
            $filename = explode('/', $storeFile);
            $fileType = explode('/', $requestFile->getMimeType());
            $checkFileType = [
                'image' => 'image',
                'application' => 'document',
                'text' => 'document'
            ];

            $blog_image = Media::create(
                [
                    'filename'           => $filename[3],
                    'original_filename'  => $requestFile->getClientOriginalName(),
                    'extension'          => $requestFile->getClientOriginalExtension(),
                    'mime'               => $requestFile->getMimeType(),
                    'type'               => $checkFileType[$fileType[0]],
                    'file_size'          => $requestFile->getClientSize()
                ]
            );
        }

        $blog = Blog::create(
            [
                'title'         => request('title'),
                'slug'          => $this->setSlugAttribute(request('title')),
                'description'   => request('description'),
                'category_id'   => $category->id,
                'blog_image_id' => isset($blog_image->id) ? $blog_image->id : null,
                'status'        => $request->status ? 1 : 0,
                'created_by'    => Auth::user()->id,
                'updated_by'    => Auth::user()->id,
            ]
        );

        if (isset($tagsIds)) {
            $blog->tags()->attach($tagsIds);
        }

        if ($blog) {
            flash('Blog added successfully.')->success();
            return redirect(route('blogs.index'));
        } 
        flash('There was some intenal error while adding the blog.')->error();
        return redirect(route('blogs.index'));
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
        $blog = Blog::find($id);
        $categories = Category::where('status', 1)->select('id', 'title')->get();
        $tags = Tag::where('status', 1)->select('id', 'title')->get();

        return view('backend.blog-section.blog.edit', compact('blog', 'categories', 'tags'));
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
        $blog = Blog::find($id);

        $this->validate(
            $request,
            [
                'title'        => 'required|min:3',
                'description'  => 'required|min:3',
                'category'     => 'required',
                'blog_image'   => 'image|mimes:jpg,png,jpeg|max:2048'
            ]
        );

        $categoryName = $request->category;
        if (isset($categoryName)) {
            $category = Category::where('title', $categoryName)->first();
            if (!(isset($category))) {
                $category = Category::create([
                    'title'        => $categoryName,
                    'slug'         => $this->setSlugAttribute($categoryName),
                    'category_for' => 'blog',
                    'status'       => 1,
                    'created_by'   => Auth::user()->id,
                    'updated_by'   => Auth::user()->id
                ]);
            }
        }

        $tagsNames = $request->tags;
        if (isset($tagsNames)) {
            $tagsIds = [];
            foreach ($tagsNames as $tagsName) {
                $tag = Tag::where('title', $tagsName)->first();
                if (!(isset($tag))) {
                    $tag = Tag::create([
                        'title'      => $tagsName,
                        'slug'       => $this->setSlugAttribute($tagsName),
                        'tag_for'    => 'blog',
                        'status'     => 1,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id
                    ]);
                }
                array_push($tagsIds, $tag->id);
            }
        }

        if ($request->file('blog_image')) {
            $requestFile = $request->file('blog_image');
            $storeFile = $request->file('blog_image')->store('public/media/blog');
            $filename = explode('/', $storeFile);
            $fileType = explode('/', $requestFile->getMimeType());
            $checkFileType = [
                'image' => 'image',
                'application' => 'document',
                'text' => 'document'
            ];

            $blog_image = Media::create(
                [
                    'filename'           => $filename[3],
                    'original_filename'  => $requestFile->getClientOriginalName(),
                    'extension'          => $requestFile->getClientOriginalExtension(),
                    'mime'               => $requestFile->getMimeType(),
                    'type'               => $checkFileType[$fileType[0]],
                    'file_size'          => $requestFile->getClientSize()
                ]
            );
        }

        if(isset($blog_image->id) && !empty($blog->blog_image_id)) {
            if (Media::where('id', $blog->blog_image_id)->first()) {
                Media::where('id', $blog->blog_image_id)->first()->delete();
            }
        }

        if($blog->title != request('title')) {
            $blog->update(['slug' => $this->setSlugAttribute(request('title'))]);
        }

        if (isset($blog_image->id)) {
            $blog->update(['blog_image_id' => $blog_image->id]);
        } 

        $blog->update(
            [
                'title'         => request('title'),
                'description'   => request('description'),
                'category_id'   => $category->id,
                'status'        => $request->status ? 1 : 0,
                'created_by'    => Auth::user()->id,
                'updated_by'    => Auth::user()->id,
            ]
        );

        $blog->tags()->detach();
        if (isset($tagsIds)) {
            $blog->tags()->attach($tagsIds);
        }

        if ($blog) {
            flash('Blog updated successfully.')->info();
            return redirect(route('blogs.index'));
        } 
        flash('There was some intenal error while adding the blog.')->error();
        return redirect(route('blogs.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        
        if ($blog->delete()) {
            flash('Blog deleted successfully.')->error();
            return redirect(route('blogs.index'));
        }
        flash('There was some intenal error while deleting the blog.')->error();
        return redirect(route('blogs.index'));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $blog = BLog::find($id);

        $blog->update(
            [
                'status'=> request('status')
            ]
        );

        if ($blog) {
            return [ 'success' => 'Blog updated successfully.'];
        }
        return [ 'error' => 'There was some intenal error while updating the blog.'];
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
        $blog = BLog::withTrashed()->find($id);

        if ($blog->restore()) {
            flash('Blog restored successfully.')->info();
            return redirect(route('blogs.index'));
        }
        flash('There was some intenal error while restoring the blog.')->error();
        return redirect(route('blogs.index'));
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
        $blog = BLog::withTrashed()->find($id);

        if ($blog->forcedelete()) {
            flash('Blog deleted permanently.')->error();
            return redirect(route('blogs.index'));
        }
        flash('There was some intenal error while deleting the blog permanently.')->error();
        return redirect(route('blogs.index'));
    }

    /**
     * Remove the specified image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage($id)
    {
        $blog = BLog::find($id);
        $blog_image = Media::where('id', $blog->blog_image_id)->first();

        if ($blog_image->delete()) {
            $blog->update(['blog_image_id' => null]);
            return [ 'success' => 'Image deleted successfully.'];
        }
        return [ 'error' => 'There was some intenal error while deleting the image.'];
    }


    /**
     * Creating the unique slug.
     *
     */
    private function setSlugAttribute($slug)
    {
        $slug = str_slug($slug);
        $slugs = Blog::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
