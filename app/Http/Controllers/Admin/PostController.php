<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index()
    {
        $items = Post::with(['category','user'])->orderBy('created_at','DESC')->get();
        return view('admin.pages.post.index',[
            'title' => 'Data Artikel',
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post_categories = PostCategory::orderBy('name','ASC')->get();
        return view('admin.pages.post.create',[
            'title' => 'Tambah Artikel',
            'post_categories' => $post_categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => ['required','max:255'],
            'post_category_id' => ['required'],
            'short_description' => ['required','max:255'],
            'description' => ['required'],
            'is_active' => ['required'],
            'image' => ['required','image','mimes:jpg,png,jpeg,svg']
        ]);

        $data = request()->all();
        $data['slug'] = \Str::kebab(request('title'));
        $cekSlug = Post::where('slug',$data['slug'])->count();
        if($cekSlug > 0)
        {
            $data['slug'] = $data['slug'] . '-' . \Str::random(5);
        }
        $data['image'] = request('image')->store('post','public');
        $data['user_id'] = auth()->id();
        Post::create($data);
        return redirect()->route('admin.posts.index')->with('success','Artikel berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Post::with(['category'])->findOrFail($id);
        $post_categories = PostCategory::orderBy('name','ASC')->get();
        return view('admin.pages.post.edit',[
            'title' => 'Edit Artikel',
            'item' => $item,
            'post_categories' => $post_categories
        ]);
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
        request()->validate([
            'title' => ['required','max:255'],
            'post_category_id' => ['required'],
            'short_description' => ['required','max:255'],
            'description' => ['required'],
            'is_active' => ['required'],
            'image' => ['image','mimes:jpg,png,jpeg,svg']
        ]);

        $data = request()->all();
        $item = Post::findOrFail($id);
        $data['slug'] = \Str::kebab(request('title'));
        $cekSlug = Post::where('slug',$data['slug'])->count();
        if($cekSlug > 0)
        {
            $data['slug'] = $data['slug'] . '-' . \Str::random(5);
        }
        if(request('image'))
        {
            Storage::disk('public')->delete($item->image);
            $data['image'] = request('image')->store('post','public');
        }else{
            $data['image'] = $item->image;
        }
        $data['user_id'] = auth()->id();
        $item->update($data);
        return redirect()->route('admin.posts.index')->with('success','Artikel berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Post::findOrFail($id);
        Storage::disk('public')->delete($item->image);
        $item->delete();
        return redirect()->route('admin.posts.index')->with('success','Artikel berhasil dihapus.');
    }
}
