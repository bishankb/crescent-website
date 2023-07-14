<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\Media;
use Auth;

class ServiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:view_services', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_services', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_services', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_services', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::statusFilter(request('status'))
                          ->deletedItemFilter(request('deleted-items'))
                          ->get();
               
        return view('backend.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.service.create');
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
                'service_image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
            ]
        );

        if ($request->file('service_image')) {
            $requestFile = $request->file('service_image');
            $storeFile = $request->file('service_image')->store('public/media/service');
            $filename = explode('/', $storeFile);
            $fileType = explode('/', $requestFile->getMimeType());
            $checkFileType = [
                'image' => 'image',
                'application' => 'document',
                'text' => 'document'
            ];

            $service_image = Media::create(
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

        $service = Service::create(
            [
                'title'            => request('title'),
                'slug'             => $this->setSlugAttribute(request('title')),
                'description'      => request('description'),
                'service_image_id' => isset($service_image->id) ? $service_image->id : null,
                'status'           => $request->status ? 1 : 0,
                'created_by'       => Auth::user()->id,
                'updated_by'       => Auth::user()->id,
            ]
        );

        if ($service) {
            flash('Service added successfully.')->success();
            return redirect(route('services.index'));
        } 
        flash('There was some intenal error while adding the service.')->error();
        return redirect(route('services.index'));
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
        $service = Service::find($id);

        return view('backend.service.edit', compact('service'));
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
        $service = Service::find($id);

        $this->validate(
            $request,
            [

                'title'        => 'required|min:3',
                'description'  => 'required|min:3',
                'service_image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
            ]
        );       

        if ($request->file('service_image')) {
            $requestFile = $request->file('service_image');
            $storeFile = $request->file('service_image')->store('public/media/service');
            $filename = explode('/', $storeFile);
            $fileType = explode('/', $requestFile->getMimeType());
            $checkFileType = [
                'image' => 'image',
                'application' => 'document',
                'text' => 'document'
            ];

            $service_image = Media::create(
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

        if(isset($service_image->id) && !empty($service->service_image_id)) {
            if (Media::where('id', $service->service_image_id)->first()) {
                Media::where('id', $service->service_image_id)->first()->delete();
            }
        }

        if($service->title != request('title')) {
            $service->update(['slug' => $this->setSlugAttribute(request('title'))]);
        }

        if (isset($service_image->id)) {
            $service->update(['service_image_id' => $service_image->id]);
        }

        $service->update(
            [
                'title'            => request('title'),
                'description'      => request('description'),
                'status'           => $request->status ? 1 : 0,
                'created_by'       => Auth::user()->id,
                'updated_by'       => Auth::user()->id,
            ]
        );

        if ($service) {
            flash('Service updated successfully.')->info();
            return redirect(route('services.index'));
        } 
        flash('There was some intenal error while adding the service.')->error();
        return redirect(route('services.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        
        if ($service->delete()) {
            flash('Service deleted successfully.')->error();
            return redirect(route('services.index'));
        }
        flash('There was some intenal error while deleting the service.')->error();
        return redirect(route('services.index'));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $service = Service::find($id);

        $service->update(
            [
                'status'=> request('status')
            ]
        );

        if ($service) {
            return [ 'success' => 'Service updated successfully.'];
        }
        return [ 'error' => 'There was some intenal error while updating the service.'];
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
        $service = Service::withTrashed()->find($id);

        if ($service->restore()) {
            flash('Service restored successfully.')->info();
            return redirect(route('services.index'));
        }
        flash('There was some intenal error while restoring the service.')->error();
        return redirect(route('services.index'));
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
        $service = Service::withTrashed()->find($id);

        if ($service->forcedelete()) {
            flash('Service deleted permanently.')->error();
            return redirect(route('services.index'));
        }
        flash('There was some intenal error while deleting the service permanently.')->error();
        return redirect(route('services.index'));
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
        $service = Service::find($id);
        $service_image = Media::where('id', $service->service_image_id)->first();

        if ($service_image->delete()) {
            $service->update(['service_image_id' => null]);
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
        $slugs = Service::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
