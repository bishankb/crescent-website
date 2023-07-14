<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Media;
use Auth;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:view_products', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_products', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_products', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_products', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::statusFilter(request('status'))
                          ->deletedItemFilter(request('deleted-items'))
                          ->latest()
                          ->get();
               
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product.create');
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
                'title'         => 'required|min:3',
                'description'   => 'required|min:3',
                'features'      => 'required|min:3',
                'product_image' => 'image|mimes:jpg,png,jpeg|max:2048'
            ]
        );

        if ($request->file('product_image')) {
            $requestFile = $request->file('product_image');
            $storeFile = $request->file('product_image')->store('public/media/product');
            $filename = explode('/', $storeFile);
            $fileType = explode('/', $requestFile->getMimeType());
            $checkFileType = [
                'image' => 'image',
                'application' => 'document',
                'text' => 'document'
            ];

            $product_image = Media::create(
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

        $product = Product::create(
            [
                'title'            => request('title'),
                'slug'             => $this->setSlugAttribute(request('title')),
                'description'      => request('description'),
                'features'         => request('features'),
                'product_image_id' => isset($product_image->id) ? $product_image->id : null,
                'status'           => $request->status ? 1 : 0,
                'created_by'       => Auth::user()->id,
                'updated_by'       => Auth::user()->id,
            ]
        );

        if ($product) {
            flash('Product added successfully.')->success();
            return redirect(route('products.index'));
        } 
        flash('There was some intenal error while adding the product.')->error();
        return redirect(route('products.index'));
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
        $product = Product::find($id);

        return view('backend.product.edit', compact('product'));
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
        $product = Product::find($id);

        $this->validate(
            $request,
            [
                'title'         => 'required|min:3',
                'description'   => 'required|min:3',
                'features'      => 'required|min:3',
                'product_image' => 'image|mimes:jpg,png,jpeg|max:2048'
            ]
        );       

        if ($request->file('product_image')) {
            $requestFile = $request->file('product_image');
            $storeFile = $request->file('product_image')->store('public/media/product');
            $filename = explode('/', $storeFile);
            $fileType = explode('/', $requestFile->getMimeType());
            $checkFileType = [
                'image' => 'image',
                'application' => 'document',
                'text' => 'document'
            ];

            $product_image = Media::create(
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

        if(isset($product_image->id) && !empty($product->product_image_id)) {
            if (Media::where('id', $product->product_image_id)->first()) {
                Media::where('id', $product->product_image_id)->first()->delete();
            }
        }

        if($product->title != request('title')) {
            $product->update(['slug' => $this->setSlugAttribute(request('title'))]);
        }

        if (isset($product_image->id)) {
            $product->update(['product_image_id' => $product_image->id]);
        }

        $product->update(
            [
                'title'        => request('title'),
                'description'  => request('description'),
                'features'     => request('features'),
                'status'       => $request->status ? 1 : 0,
                'created_by'   => Auth::user()->id,
                'updated_by'   => Auth::user()->id,
            ]
        );

        if ($product) {
            flash('Product updated successfully.')->info();
            return redirect(route('products.index'));
        } 
        flash('There was some intenal error while adding the product.')->error();
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        
        if ($product->delete()) {
            flash('Product deleted successfully.')->error();
            return redirect(route('products.index'));
        }
        flash('There was some intenal error while deleting the product.')->error();
        return redirect(route('products.index'));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $product = Product::find($id);

        $product->update(
            [
                'status'=> request('status')
            ]
        );

        if ($product) {
            return [ 'success' => 'Product updated successfully.'];
        }
        return [ 'error' => 'There was some intenal error while updating the product.'];
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
        $product = Product::withTrashed()->find($id);

        if ($product->restore()) {
            flash('Product restored successfully.')->info();
            return redirect(route('products.index'));
        }
        flash('There was some intenal error while restoring the product.')->error();
        return redirect(route('products.index'));
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
        $product = Product::withTrashed()->find($id);

        if ($product->forcedelete()) {
            flash('Product deleted permanently.')->error();
            return redirect(route('products.index'));
        }
        flash('There was some intenal error while deleting the product permanently.')->error();
        return redirect(route('products.index'));
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
        $product = Product::find($id);
        $product_image = Media::where('id', $product->product_image_id)->first();

        if ($product_image->delete()) {
            $product->update(['product_image_id' => null]);
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
        $slugs = Product::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
