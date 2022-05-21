<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $items = Role::latest()->get();
        return view('admin.pages.role.index',[
            'title' => 'Data Role',
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
        return view('admin.pages.role.create',[
            'title' => 'Create Role',
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
            'name' => ['required','unique:roles,name']
        ]);

        $data = request()->all();
        Role::create($data);
        return redirect()->route('admin.roles.index')->with('success','Role berhasil disimpan.');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $permissions = Permission::whereNotIn('id',$role->permissions->pluck('id'))->get();
        return view('admin.pages.role.permission',[
            'title' => 'Role Permission',
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function permissionsUpdate($id)
    {
        $role = Role::find($id);
        $permissions = request('permissions');
        $role->syncPermissions($permissions);
        return redirect()->route('admin.roles.index')->with('success','Role Permission berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Role::findOrFail($id);
        return view('admin.pages.role.edit',[
            'title' => 'Edit Role',
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
            'name' => ['required',Rule::unique('roles','name')->ignore($id)]
        ]);
        $item = Role::findOrFail($id);
        $data = request()->all();
        $item->update($data);
        return redirect()->route('admin.roles.index')->with('success','Role berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Role::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.roles.index')->with('success','Role berhasil dihapus.');
    }
}
