<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $dataTable)
    {
        $breadcrumbs = [
            [
                'link' => 'roles.index',
                'name' => 'Roles'
            ]
        ];

        $permissions = Permission::all();
        return $dataTable->render('pages.roles.index', compact('breadcrumbs', 'permissions'));
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
    public function store(RoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->name,
            ]);

            $permissions = Permission::whereIn('id', $request->permissions)->get();
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', $e->getMessage());
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
    public function update(RoleRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $role = Role::find($id);

            $role->update([
                'name' => $request->name,
            ]);

            $role->permissions()->detach();

            $permissions = Permission::whereIn('id', $request->permissions)->get();
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Role berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DB::beginTransaction();
        try {
            Role::find($id)->delete();
            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', 'Role gagal dihapus');
        }
    }
}
