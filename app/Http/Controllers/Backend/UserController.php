<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use App\Media;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_users', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_users', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_users', ['only' => 'destroy']);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $redirectTo = '/login';

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $users = User::statusFilter(request('status'))
                        ->deletedItemFilter(request('deleted-items'))
                        ->get();
        } else {
            $users = User::statusFilter(request('status'))
                        ->deletedItemFilter(request('deleted-items'))
                        ->get();
        }
                        
        return view('backend.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user.create');
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
                'name'     => 'required|string|min:2|max:255',
                'email'    => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed'
            ]
        );

        $user = User::create(
            [
                'name'     => request('name'),
                'slug'     => $this->setSlugAttribute(request('name')),
                'email'    => request('email'),
                'password' => Hash::make(request('password'))
            ]
        );

        if ($user) {
            flash('User added successfully.')->success();
            return redirect(route('users.index'));
        } 
        flash('There was some intenal error while adding the user.')->error();
        return redirect(route('users.index'));
        
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
        $user = User::find($id);
        $userProfile = UserProfile::where('user_id', $id)->first();
        $roles = Role::get();

        return view('backend.user.edit', compact('user', 'userProfile', 'roles'));
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
        $user = User::find($id);

        if(Auth::user()->hasRole('admin')) {
            $this->validate(
                $request,
                [
                    'name'    => 'required|string|min:2|max:255',
                    'email'   => 'required|string|email|max:255|unique:users,email,'.$user->id,
                    'role'    => 'required'
                ]
            );

            if($user->name != request('name')) {
                $user->update(['slug' => $this->setSlugAttribute(request('name'))]);
            }

            $user->update(
                [
                    'name'    => request('name'),
                    'email'   => request('email'),
                    'role_id' => request('role'),
                ]
            );
            $role = request('role');
            $user->syncRoles($role);
        } elseif (Auth::user()->id == $user->id) {
            $this->validate(
                $request,
                [
                    'name'    => 'required|string|min:2|max:255',
                    'email'   => 'required|string|email|max:255|unique:users,email,'.$user->id
                ]
            );

            if($user->name != request('name')) {
                $user->update(['slug' => $this->setSlugAttribute(request('name'))]);
            }

            $user->update(
                [
                    'name'    => request('name'),
                    'email'   => request('email')
                ]
            );
        } else {
            $this->validate(
                $request,
                [
                    'name'    => 'required|string|min:2|max:255',
                ]
            );

            if($user->name != request('name')) {
                $user->update(['slug' => $this->setSlugAttribute(request('name'))]);
            }

            $user->update(
                [
                    'name'    => request('name'),
                ]
            );
        }

        if ($user) {
            flash('User updated successfully.')->info();
            return redirect(route('users.index'));
        } 
        flash('There was some intenal error while updating the user.')->error();
        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        
        if ($user->delete()) {
            flash('User deleted successfully.')->error();
            return redirect(route('users.index'));
        }
        flash('There was some intenal error while deleting the user.')->error();
        return redirect(route('users.index'));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $id)
    {
        $user = User::find($id);

        $user->update(
            [
                'active'=> request('status')
            ]
        );

        if ($user) {
            return [ 'success' => 'User updated successfully.'];
        }
        return [ 'error' => 'There was some intenal error while updating the user.'];
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
        $user = User::withTrashed()->find($id);

        if ($user->restore()) {
            flash('User restored successfully.')->info();
            return redirect(route('users.index'));
        }
        flash('There was some intenal error while restoring the user.')->error();
        return redirect(route('users.index'));
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
        $user = User::withTrashed()->find($id);

        if ($user->forcedelete()) {
            flash('User deleted permanently.')->error();
            return redirect(route('users.index'));
        }
        flash('There was some intenal error while deleting the user permanently.')->error();
        return redirect(route('users.index'));
    }

    /**
     * Edit the profile of the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile(Request $request, $id)
    {
        $userProfile = User::find($id);
        $this->validate(
            $request,
            [
                'position'    => 'nullable|min:2|max:20',
                'phone1'      => 'nullable|min:5|max:20',
                'phone2'      => 'nullable|min:5|max:20',
                'address'     => 'nullable|min:2|max:20',
                'city'        => 'nullable|min:2|max:20',
                'country'     => 'nullable|min:2|max:20',
                'user_image'  => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
            ]
        );

        if ($request->file('user_image')) {
            $requestFile = $request->file('user_image');
            $storeFile = $request->file('user_image')->store('public/media/user');
            $filename = explode('/', $storeFile);
            $fileType = explode('/', $requestFile->getMimeType());
            $checkFileType = [
                'image' => 'image',
                'application' => 'document',
                'text' => 'document'
            ];

            $user_image = Media::create(
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

        if(isset($user_image->id) && !empty($userProfile->profile->user_image_id)) {
            if (Media::where('id', $userProfile->profile->user_image_id)->first()) {
                Media::where('id', $userProfile->profile->user_image_id)->first()->delete();
            }
        }

        if (!$userProfile->profile) {
            $userProfile = UserProfile::create(
                [
                    'user_id'       => $id,
                    'position'      => request('position'),
                    'phone1'        => request('phone1'),
                    'phone2'        => request('phone2'),
                    'address'       => request('address'),
                    'city'          => request('city'),
                    'country'       => request('country'),
                    'user_image_id' => isset($user_image->id) ? $user_image->id : null
                ]
            );
        } else {
            if (isset($user_image->id)) {
                $userProfile->profile->update(['user_image_id' => $user_image->id]);
            }
            $userProfile->profile->update(
                [
                    'user_id'       => $id,
                    'position'      => request('position'),
                    'phone1'        => request('phone1'),
                    'phone2'        => request('phone2'),
                    'address'       => request('address'),
                    'city'          => request('city'),
                    'country'       => request('country'),  
                ]
            );
        }

        if ($userProfile) {
            flash('Profile updated successfully.')->success();
            return redirect(route('users.index'));
        } 
        flash('There was some intenal error while updating the profile.')->error();
        return redirect(route('users.index'));
    }

    /**
     * Change the password of the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        if (!(Auth::user()->id == $user->id || Auth::user()->role->name == 'admin')) {
            flash('You dont have authorization to change the password')->error();
            return redirect()->route('users.index');
        } else {
            $this->validate(
                $request,
                [
                    'password' => 'required|string|min:6|confirmed'
                ]
            );

            $user->update(
                [
                    'password' => Hash::make(request('password'))
                ]
            );

            if ($user) {

                flash('Password changed successfully.')->success();
                return redirect(route('users.index'));
            } 
            flash('There was some intenal error while changing the password.')->error();
            return redirect(route('users.index'));
        }
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
        $userProfile = UserProfile::find($id);
        $user_image = Media::where('id', $userProfile->user_image_id)->first();

        if ($user_image->delete()) {
            $userProfile->update(['user_image_id' => null]);
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
        $slugs = User::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
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
