<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostCategoryController extends Controller
{
    public function index()
    {
        $items = PostCategory::orderBy('name','ASC')->get();
        return view('admin.pages.post-category.index',[
            'title' => 'Data Kategori',
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
        return view('admin.pages.post-category.create',[
            'title' => 'Tambah Kategori',
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
            'name' => ['required','unique:post_categories,name']
        ]);

        $data = request()->all();
        $data['slug'] = \Str::kebab(request('name'));
        PostCategory::create($data);
        return redirect()->route('admin.post-categories.index')->with('success','Kategori berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = PostCategory::findOrFail($id);
        return view('admin.pages.post-category.edit',[
            'title' => 'Edit Kategori',
            'item' => $item
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
            'name' => ['required',Rule::unique('post_categories','name')->ignore($id)]
        ]);
        $item = PostCategory::findOrFail($id);
        $data = request()->all();
        $data['slug'] = \Str::kebab(request('slug'));
        $item->update($data);
        return redirect()->route('admin.post-categories.index')->with('success','Kategori berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = PostCategory::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.post-categories.index')->with('success','Kategori berhasil dihapus.');
    }
}
