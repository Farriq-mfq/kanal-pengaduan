<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:users view', only: ['index']),
            new Middleware('permission:users create', only: ['store']),
            new Middleware('permission:users update', only: ['update']),
            new Middleware('permission:users delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        $breadcrumbs = [
            [
                'link' => route('users.index'),
                'name' => 'Users'
            ],
        ];


        $roles = Role::all();
        $kategori = Kategori::all();
        return $dataTable->render('pages.users.index', compact('breadcrumbs', 'roles', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::find($request->role_id);
            if (!$role) {
                return back()->with('error', 'Role tidak ditemukan');
            }
            $roleName = $role->name;
            if ($roleName == 'tim penanganan') {
                $kategori = Kategori::findOrFail($request->kategori);
                $role->users()->create([
                    'name' => $request->name,
                    'username' => $request->username,
                    'jabatan' => $request->jabatan,
                    'password' => bcrypt($request->password),
                    'kategori_id' => $kategori->id
                ]);
            } else {
                $role->users()->create([
                    'name' => $request->name,
                    'username' => $request->username,
                    'jabatan' => $request->jabatan,
                    'password' => bcrypt($request->password),
                ]);
            }

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'User gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {

        DB::beginTransaction();
        try {
            $user = User::find($id);

            $role = Role::find($request->role_id);
            if (!$role)
                return back()->with('error', 'Role tidak ditemukan');

            if ($role->name == 'tim penanganan') {
                $kategori = Kategori::findOrFail($request->kategori);
                $user->kategori_id = $kategori->id;
            } else {
                $user->kategori_id = null;
            }

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'jabatan' => $request->jabatan,
            ]);

            $user->syncRoles([$role->id]);

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'User gagal diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            User::find($id)->delete();
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'User gagal dihapus');
        }
    }

    public function update_password(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required']
        ], [
            'password.required' => 'Password tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $user = User::find($id);
            if (!$user) {
                return back()->with('error', 'User tidak ditemukan');
            }
            $user->update([
                'password' => bcrypt(request()->password),
            ]);
            DB::commit();
            return redirect()->route('users.index')->with('success', 'Password berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'Password gagal diupdate');
        }
    }

}
