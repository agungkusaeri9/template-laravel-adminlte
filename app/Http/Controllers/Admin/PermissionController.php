<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $items = Permission::latest()->get();
        return view('admin.pages.permission.index',[
            'title' => 'Data Permission',
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
        return view('admin.pages.permission.create',[
            'title' => 'Tambah Permission',
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
            'name' => ['required','unique:permissions,name']
        ]);

        $data = request()->all();
        $data['name'] = Str::kebab(request('name'));
        Permission::create($data);
        return redirect()->route('admin.permissions.index')->with('success','Permission berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Permission::findOrFail($id);
        return view('admin.pages.permission.edit',[
            'title' => 'Edit Permission',
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
            'name' => ['required',Rule::unique('permissions','name')->ignore($id)]
        ]);
        $item = Permission::findOrFail($id);
        $data = request()->all();
        $data['name'] = Str::kebab(request('name'));
        $item->update($data);
        return redirect()->route('admin.permissions.index')->with('success','Permission berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Permission::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.permissions.index')->with('success','Permission berhasil dihapus.');
    }
}
