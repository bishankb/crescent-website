<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feature;
use Auth;

class FeatureController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:view_features', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_features', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_features', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_features', ['only' => 'destroy']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = Feature::get();
               
        return view('backend.feature.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $featureCount = Feature::get()->count();
        if( $featureCount < 6) {
            return view('backend.feature.create');
        }
        flash('Cannot add more than 6 items.')->error();
        return redirect(route('features.index'));
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
                'feature_icon' => 'required|min:3',
                'description'  => 'required|min:3'
            ]
        );

        $feature = Feature::create(
            [
                'title'        => request('title'),
                'slug'         => $this->setSlugAttribute(request('title')),
                'feature_icon' => request('feature_icon'),
                'description'  => request('description'),
                'status'       => $request->status ? 1 : 0,
                'created_by'   => Auth::user()->id,
                'updated_by'   => Auth::user()->id,
            ]
        );

        if ($feature) {
            flash('Feature added successfully.')->success();
            return redirect(route('features.index'));
        } 
        flash('There was some intenal error while adding the feature.')->error();
        return redirect(route('features.index'));
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
        $feature = Feature::find($id);

        return view('backend.feature.edit', compact('feature'));
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
        $feature = Feature::find($id);

        $this->validate(
            $request,
            [
                'title'        => 'required|min:3',
                'feature_icon' => 'required|min:3',
                'description'  => 'required|min:3'
            ]
        );     

        if($feature->title != request('title')) {
            $feature->update(['slug' => $this->setSlugAttribute(request('title'))]);
        }  

        $feature->update(
            [
                'title'        => request('title'),
                'feature_icon' => request('feature_icon'),
                'description'  => request('description'),
                'status'       => $request->status ? 1 : 0,
                'created_by'   => Auth::user()->id,
                'updated_by'   => Auth::user()->id,
            ]
        );

        if ($feature) {
            flash('Feature updated successfully.')->info();
            return redirect(route('features.index'));
        } 
        flash('There was some intenal error while adding the feature.')->error();
        return redirect(route('features.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feature = Feature::find($id);
        
        if ($feature->delete()) {
            flash('Feature deleted successfully.')->error();
            return redirect(route('features.index'));
        }
        flash('There was some intenal error while deleting the feature.')->error();
        return redirect(route('features.index'));
    }

    /**
     * Creating the unique slug.
     *
     */
    private function setSlugAttribute($slug)
    {
        $slug = str_slug($slug);
        $slugs = Feature::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
