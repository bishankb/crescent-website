<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PhoneBook;
use App\Media;
use Auth;
use Illuminate\Support\Facades\Storage;
use File;

class PhoneBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phonebooks = Phonebook::deletedItemFilter(request('deleted-items'))
                          ->latest()
                          ->get();
        return view('backend.phonebook.index', compact('phonebooks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.phonebook.create');
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
                'title'          => 'required|min:3',
                'description'    => 'nullable|min:3',
                'phonebook_file' => 'required|mimes:txt,doc,pdf,docx|max:10240'
            ]
        );

        if ($request->file('phonebook_file')) {
            $requestFile = $request->file('phonebook_file');
            $storeFile = $request->file('phonebook_file')->store('public/media/phonebook');
            $filename = explode('/', $storeFile);
            $fileType = explode('/', $requestFile->getMimeType());
            $checkFileType = [
                'image' => 'image',
                'application' => 'document',
                'text' => 'document'
            ];

            $phonebook_file = Media::create(
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

        $phonebook = Phonebook::create(
            [
                'phone_book_type'   => 'upload_phones',
                'title'             => request('title'),
                'description'       => request('description'),
                'phonebook_file_id' => isset($phonebook_file->id) ? $phonebook_file->id : null,
                'created_by'        => Auth::user()->id,
                'updated_by'        => Auth::user()->id,
            ]
        );
        
        if ($phonebook) {
            flash('Phone Book added successfully.')->success();
            return redirect(route('phonebooks.index'));
        } 
        flash('There was some intenal error while adding the phonebook.')->error();
        return redirect(route('phonebooks.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $phonebook = Phonebook::with('file')->find($id);
        $phonesRaw =  file_get_contents('storage/media/phonebook/' . $phonebook->file->filename);
        $phonesArray = preg_split("/[, \n]/", $phonesRaw);
        $phones = preg_grep("/^9+([7-8][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]+)/", $phonesArray);
        
        return view('backend.phonebook.show', compact('phones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $phonebook = Phonebook::find($id);

        return view('backend.phonebook.edit', compact('phonebook'));
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
        $phonebook = Phonebook::find($id);

        $this->validate(
            $request,
            [
                'title'          => 'required|min:3',
                'description'    => 'nullable|min:3',
                'phonebook_file' => 'mimes:txt,doc,pdf,docx|max:10240'
            ]
        );

        if ($request->file('phonebook_file')) {
            $requestFile = $request->file('phonebook_file');
            $storeFile = $request->file('phonebook_file')->store('public/media/phonebook');
            $filename = explode('/', $storeFile);
            $fileType = explode('/', $requestFile->getMimeType());
            $checkFileType = [
                'image' => 'image',
                'application' => 'document',
                'text' => 'document'
            ];

            $phonebook_file = Media::create(
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

        if(isset($phonebook_file->id) && !empty($phonebook->phonebook__id)) {
            if (Media::where('id', $phonebook->phonebook_file_id)->first()) {
                Media::where('id', $phonebook->phonebook_file_id)->first()->delete();
            }
        }

        if (isset($phonebook_image->id)) {
            $phonebook->update(['phonebook_file_id' => $phonebook_image->id]);
        }

        $phonebook->update(
            [
                'title'              => request('title'),
                'description'        => request('description'),
                'updated_by'         => Auth::user()->id,
            ]
        );

        if ($phonebook) {
            flash('Phone Book updated successfully.')->info();
            return redirect(route('phonebooks.index'));
        } 
        flash('There was some intenal error while adding the phonebook.')->error();
        return redirect(route('phonebooks.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phonebook = PhoneBook::find($id);
        
        if ($phonebook->delete()) {
            flash('Phone Book deleted successfully.')->error();
            return redirect(route('phonebooks.index'));
        }
        flash('There was some intenal error while deleting the phonebook.')->error();
        return redirect(route('phonebooks.index'));
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
        $phonebook = PhoneBook::withTrashed()->find($id);

        if ($phonebook->restore()) {
            flash('Phone Book restored successfully.')->info();
            return redirect(route('phonebooks.index'));
        }
        flash('There was some intenal error while restoring the phonebook.')->error();
        return redirect(route('phonebooks.index'));
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
        $phonebook = PhoneBook::withTrashed()->find($id);

        if ($phonebook->forcedelete()) {
            flash('Phone Book deleted permanently.')->error();
            return redirect(route('phonebooks.index'));
        }
        flash('There was some intenal error while deleting the phonebook permanently.')->error();
        return redirect(route('phonebooks.index'));
    }
}
