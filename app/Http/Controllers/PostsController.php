<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; //untuk storage library
use App\Post;
//use DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        //return Post::where('title', 'Post Two')->get();
        //$posts = DB::select('SELECT * FROM posts');
        //posts = Post::all();
        //$posts = Post::orderBy('title','desc')->take(1)->get();
        
        $postsy = Post::orderBy('created_at','desc')->paginate(10);
        return view('posts.index')->with('postsx', $postsy);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            // cover_image harus berupa file gambar (JPEG/dll)
            // atau bisa juga tanpa file
            // dan maks 2 MB
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle file upload
        // jika ada file yg diupload
        if($request->hasFile('cover_image')){
            // ambil nama file dengan ext-nya
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // ambil nama filenya aja
            // ini syntax php
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // ambil ext nya aja
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // nama file yg disimpan di folder
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            //upload gambar
            //disimpan di folder public/cover_images
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        }else {
            //jika tidak ada file diupload
            //default noimage.jpg
            $fileNameToStore = 'noimage.jpg';
        }

        //create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        return view('posts.edit')->with('post', $post);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        // cek apakah upload foto baru
        if($request->hasFile('cover_image')){
            // ambil nama file dengan ext-nya
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            // ambil nama filenya aja
            // ini syntax php
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // ambil ext nya aja
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // nama file yg disimpan di folder
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            //upload gambar
            //disimpan di folder public/cover_images
            $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);
        }

        //create Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        
        //kalo upload foto baru
        if($request->hasFile('cover_image')){
            // menghapus foto lama dari storage
            // foto lama dihapus hanya apabila foto sebelumnya bukan noimage
            if ($post->cover_image != 'noimage.jpg') {
                Storage::delete('public/cover_image/'.$post->cover_image);
            }
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        // Pos dihapus maka foto pun dihapus dari storage
        // foto dihapus hanya apabila foto sebelumnya bukan noimage
        if ($post->cover_image != 'noimage.jpg') {
                Storage::delete('public/cover_image/'.$post->cover_image);
            }

        $post->delete();

        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
