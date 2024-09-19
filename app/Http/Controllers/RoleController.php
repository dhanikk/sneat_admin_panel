<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Module;
use App\Repositories\FlashRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $flashRepository;

    public function __construct() {
        $this->flashRepository = new FlashRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        if (request()->ajax()) {
            $role = Role::all();

            return datatables()->of($role)
                ->addColumn('action', 'company-action')
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= '<button title="Change status" class="toggle-btn btn btn-' . ($row->is_enable ? 'success' : 'danger') . ' btn-xs" style="width: 50px;" data-id="' . $row->id . '" data-state="' . ($row->is_enable ? 'enable' : 'disable') . '">' . ($row->is_enable ? 'Enable' : 'Disable') . '</button>';
                    if (auth()->user()->can('update.role')) {
                        $btn .= '<a title="Edit role" href="' . route('role.edit', ['role' => $row->id]) . '" class="btn btn-success btn-xs edit-user ml-2"> <i class="fa fa-edit"></i> </a>';
                    }
                    if (auth()->user()->can('delete.role')) {
                        $btn = $btn . '<button title="Delete role" type="submit" class="btn btn-danger btn-xs delete-role ml-2" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                    }

                    return $btn;
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('role.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $permissionList = Module::with(
            'permission'
        )->groupBy('modules.name')->get();
        return view('role.form', ['role' => new Role(), 'groupPermission' => $permissionList, 'permissionsData' => []]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request) {
        $request->validated();

        $role = \Spatie\Permission\Models\Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);
        if (!$role) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!');
            return redirect()->route('role.index');
        } else {
            $role->givePermissionTo($request->permission_data);
            $this->flashRepository->setFlashSession('alert-success', 'Role created successfully.');
            return redirect()->route('role.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role) {
        $permissionList = Module::with(
            'permission'
        )->groupBy('modules.name')->get();
        // Get the role instance by ID
        $role = Role::findById($role->id);

        if ($role->permissions) {
            $permissions = $role->permissions->pluck('id')->toArray();
        } else {
            $permissions = [];
        }
        // Get the assigned permissions for the role
        return view('role.form', ['role' => $role, 'groupPermission' => $permissionList, 'permissionsData' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role) {
        $request->validated();

        $roles = Role::find($role->id);
        $roles->name = $request->name;
        $roles->guard_name = 'web';
        $roles->update();

        if (!$roles) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!');
            return redirect()->route('role.index');
        } else {
            $role->syncPermissions($request->permission_data);
            $this->flashRepository->setFlashSession('alert-success', 'Role update successfully.');
            return redirect()->route('role.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role) {
        $role = Role::findOrFail($role->id);

        $usersWithRole = User::with('roles')
            ->whereHas('roles', function ($query) use ($role) {
                $query->where('id', $role->id);
            })
            ->get();

        if ($usersWithRole->count() > 0) {
            return response()->json(['message' => 'Role is assigned to users and cannot be deleted.'], 403);
        }

        $roleDelete = Role::find($role->id)->delete();
        if ($roleDelete) {
            return response()->json(['msg' => 'Role deleted successfully!'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong, please try again.'], 200);
        }
    }

    public function updateStatus(Request $request, $roleId) {
        $role = Role::findOrFail($roleId);

        $usersWithRole = User::with('roles')
            ->whereHas('roles', function ($query) use ($role) {
                $query->where('id', $role->id);
            })
            ->get();

        if ($usersWithRole->count() > 0) {
            return response()->json(['message' => 'Role is assigned to users and cannot be disabled.'], 403);
        } else {
            $role->is_enable = $request->state === 'Enable' ? 1 : 0;
            $role->save();
            return response()->json(['message' => 'Role status toggled successfully.']);
        }
    }
}
