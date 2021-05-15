<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->isSuperUser() && !Gallery::canView(Auth::user()->role)) {
            abort(401);
        } else {
            $galleries = Gallery::all();
            return view('gallery.home', compact('galleries'));
        }
    }

    public function getCreatePage() {
        if (!Auth::user()->isSuperUser() && !Gallery::canCreate(Auth::user()->role)) {
            abort(401);
        }

        return view('gallery.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!Auth::user()->isSuperUser() && !Gallery::canCreate(Auth::user()->role)) {
            abort(401);
        }

        $validator = Validator::make($request->all(), [
            'gallery_name' => 'required|min:1|max:255|unique:galleries,gallery,except,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $files = $request->file('gallery_images');

        $paths = [];
        foreach ($files as $file) {
            $path = Storage::disk('gallery_uploads')->put('/', $file);
            array_push($paths, $path);
        }

        $gallery = new Gallery();

        $gallery->gallery = $request->get('gallery_name');
        $gallery->image_path = $paths;
        $gallery->save();

        $request->session()->flash('alert-success', 'Image successfully Stored.');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function editGalleryPage(Gallery $gallery, Request $request) {
        if (!Auth::user()->isSuperUser() && !Gallery::canEdit(Auth::user()->role)) {
            abort(401);
        }

        return view('gallery.edit', compact('gallery'));
    }

    public function edit(Gallery $gallery, Request $request)
    {
        if (!Auth::user()->isSuperUser() && !Gallery::canEdit(Auth::user()->role)) {
            abort(401);
        }

        $files = $request->file('gallery_images');

        $paths = [];
        if ($files) {
            foreach ($files as $file) {
                $path = Storage::disk('gallery_uploads')->put('/', $file);
                array_push($paths, $path);
            }
        }

        $gallery->gallery = $request->get('gallery_name');

        if (count($paths)) {
            $gallery->image_path = $paths;
        }

        $gallery->save();

        $request->session()->flash('alert-success', 'Gallery successfully Updated.');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery, Request $request)
    {
        if (!Auth::user()->isSuperUser() && !Gallery::canDelete(Auth::user()->role)) {
            abort(401);
        }

        foreach ($gallery->image_path as $path) {
            Storage::disk('gallery_uploads')->delete('/' . $path);
        };

        $gallery->delete();
        $request->session()->flash('alert-success', 'Gallery successfully deleted');
        return redirect()->back();
    }
}
