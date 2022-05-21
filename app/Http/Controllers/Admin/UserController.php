<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $items = User::orderBy('name','ASC')->get();
        return view('admin.pages.user.index',[
            'title' => 'Data User',
            'items' => $items
        ]);
    }

    public function create()
    {
        $roles = Role::get();
        return view('admin.pages.user.create',[
            'title' => 'Tambah User',
            'roles' => $roles
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => ['required','string','min:3'],
            'username' => ['required','alpha_dash','min:3','unique:users,username'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','min:5'],
            'avatar' => ['image','mimes:jpg,jpeg,png']
        ]);

        $data = request()->except('role');
        if(request()->file('avatar'))
        {
            $data['avatar'] = request()->file('avatar')->store('user','public');
        }else{
            $data['avatar'] = NULL;
        }
        $data['password'] = bcrypt(request('password'));
        $user = User::create($data);

        $user->assignRole(request('role'));

        return redirect()->route('admin.users.index')->with('success','User berhasil disimpan.');
    }

    public function edit($id)
    {
        if($id == auth()->id())
        {
            return redirect()->route('admin.users.index');
        }
        $roles = Role::get();
        $item = User::findOrFail($id);
        return view('admin.pages.user.edit',[
            'title' => 'Edit User',
            'item' => $item,
            'roles' => $roles
        ]);
    }

    public function update($id)
    {
        if($id == auth()->id())
        {
            return redirect()->route('admin.users.index');
        }
        request()->validate([
            'name' => ['required','string','min:3'],
            'username' => ['required','alpha_dash','min:3',Rule::unique('users','username')->ignore($id)],
            'email' => ['required','email',Rule::unique('users','email')->ignore($id)],
            'avatar' => ['image','mimes:jpg,jpeg,png']
        ]);

        $item = User::findOrFail($id);
        $data = request()->except('role');
        if(request()->file('avatar'))
        {
            Storage::disk('public')->delete($item->avatar);
            $data['avatar'] = request()->file('avatar')->store('user','public');
        }else{
            $data['avatar'] = $item->avatar;
        }

        if(request('password'))
        {
            request()->validate([
                'password' => ['min:5']
            ]);
            $data['password'] = bcrypt(request('password'));
        }else{
            $data['password'] = $item->password;
        }
        $item->update($data);
        $item->syncRoles(request('role'));

        return redirect()->route('admin.users.index')->with('success','User berhasil disimpan.');
    }

    public function destroy($id)
    {
        $item = User::findOrFail($id);
        Storage::disk('public')->delete($item->avatar);
        $item->delete();
        return redirect()->route('admin.users.index')->with('success','User berhasil dihapus.');
    }

}
