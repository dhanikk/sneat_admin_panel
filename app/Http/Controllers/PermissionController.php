<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Setting;
use App\Repositories\FlashRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    private $flashRepository;

    public function __construct() {
        $this->flashRepository = new FlashRepository;
    }

    public function index() {
        $permissionList = Module::with(
            'permission'
        )->groupBy('modules.name')->get();
        if (request()->ajax()) {
            return datatables()->of($permissionList)
                ->addColumn('permission', function ($row) {
                    return $row->permission->pluck('name')->unique()->implode('<br>');
                })
                ->addColumn('action', function ($row) {
                    $permissions = $row->permission;
                    $btn = '';
                    if ($permissions->isNotEmpty()) {
                        if (auth()->user()->can('update.permission')) {
                            $btn = '<a title="Edit permission" href="' . route('permission.edit', ['permission' => $row->permission[0]->id]) . '" class="btn btn-success btn-xs edit-permission" data-name="' . $row->name . '" data-id=' . $row->permission[0]->id . '> <i class="fa fa-edit"></i> </a>';
                        }
                    }
                    if (auth()->user()->can('delete.permission')) {
                        $btn = $btn . '<button title="Delete permission" type="submit" class="btn btn-danger btn-xs delete-permission ml-2" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                    }
                    return $btn;
                })
                ->rawColumns(['permission', 'role', 'action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('permission.list');
    }

    public function create() {
        $roles = Role::where('is_enable', 1)->get();
        $moduleList = Module::all();
        $permission = Permission::where('id', '')->get();

        $viewData = array(
            'permission' => $permission,
            'moduleList' => $moduleList,
            'roles' => $roles
        );
        return view('permission.form', $viewData);
    }

    public function store(Request $request) {
        $input = $request->all();
        $rules = [];
        $messages = [];

        $rules['module'] = 'required|max:255';
        $rules['guard_name'] = 'required|max:255';
        $validator = Validator::make($request->all(), $rules, $messages);

        $moduleName = Module::where('id', $request->module)->first();
        $moduleName = strtolower($moduleName->name);
        $permissionData = [];
        $now = date('Y-m-d H:i:s');
        $default = config('auth.defaults.guard');
        $fullName = array();
        foreach ($request->name as $value) {
            $fullName[] = $value . '.' . $moduleName;
            $permissionData[] = [
                'name' => $value . '.' . $moduleName,
                'guard_name' => 'web',
                'module' => intval($request->module),
                'created_at' => $now,
                'updated_at' => $now
            ];
        }
        $permission = Permission::insert($permissionData);
        if (!$permission) {
            $this->flashRepository->setFlashSession('alert-danger', 'Permission not created.');
            return redirect()->route('permission.index');
        } else {
            $this->flashRepository->setFlashSession('alert-success', 'Permission created successfully.');
            return redirect()->route('permission.index');
        }
    }

    public function edit(Permission $permission) {
        $roles = Role::where('is_enable', 1)->get();
        $moduleList = Module::all();
        if (!$permission) {
            $this->flashRepository->setFlashSession('alert-danger', 'Permission not found.');
            return view('permission.index');
        }
        $assignedRoleIds = null;
        if (!$permission->roles->isEmpty()) {
            $assignedRoleIds = $permission->roles->pluck('id')->toArray();
        }
        $permission = Permission::where('module', $permission->module)->get();

        $viewData = array(
            'permission' => $permission,
            'moduleList' => $moduleList,
            'roles' => $roles,
            'assignedRoleIds' => $assignedRoleIds
        );
        return view('permission.form', $viewData);
    }

    public function update(Request $request) {
        $input = $request->all();
        $permissionData = [];
        $inputData = [];
        $moduleName = Module::where('id', $request->module)->first();
        $moduleName = strtolower($moduleName->name);

        $fullName = array();
        foreach ($input['permissionData'] as $key => $value) {
            $fullName[] = $value[1] . '.' . $moduleName;
            $permissionData[$key]['id'] = $value[0] ? (int) $value[0] : null;
            if (str_contains($value[1], $moduleName)) {
                $permissionData[$key]['name'] = $value[1];
            } else {
                $permissionData[$key]['name'] = $value[1] . '.' . $moduleName;
            }
            $permissionData[$key]['guard_name'] = 'web';
            $permissionData[$key]['module'] = $request['module'];

            $inputData['name'][] = $value[1];
            $inputData['id'][] = $value[0] ? (int) $value[0] : null;
        }

        $inputData['module'] = $request->module;

        $rules = [];
        foreach ($inputData['name'] as $key => $val) {
            if ($inputData['id'][$key]) {
                $rules['name.' . $key] = [
                    'required', Rule::unique('permissions', 'name')->ignore($inputData['id'][$key])->where(function ($query) use ($request) {
                        return $query->where('guard_name', $request['guardName']);
                    }),
                ];
            } else {
                $rules['name.' . $key] = [
                    'required', Rule::unique('permissions', 'name')->where(function ($query) use ($request) {
                        return $query->where('guard_name', $request['guardName']);
                    }),
                ];
            }
            $messages['name.' . $key . '.unique'] = 'The Permission Name has already been taken.';
        }

        $rules['module'] = 'required|max:255';
        $validator = Validator::make($inputData, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()], 400);
        } else {
            Permission::upsert($permissionData, ['id'], ['name', 'module']);
            return response()->json(['msg' => 'Permission updated successfully.'], 200);
        }
    }

    public function deleteSinglePermission(Request $request) {
        $permissionDelete = Permission::find($request->id)->delete();
        if ($permissionDelete)
            return response()->json(['msg' => 'Permission deleted successfully!']);

        return response()->json(['msg' => 'Something went wrong, Please try again.'], 500);
    }

    public function destroy(Request $request) {
        $permissionDelete = Permission::where('module', $request->id)->delete();
        if ($permissionDelete) {
            return response()->json(['msg' => 'Permission deleted successfully!']);
        } else {
            $module = Module::where('id', $request->id)->delete();
            if ($module) {
                return response()->json(['msg' => 'Permission deleted successfully!']);
            } else {
                return response()->json(['msg' => 'Something went wrong, Please try again.'], 500);
            }
        }
        return response()->json(['msg' => 'Something went wrong, Please try again.'], 500);
    }

    public function moduleStore(Request $request) {
        $request->validate([
            'name' => 'required|unique:modules,name',
        ]);
        $group = Module::create([
            'name' => $request->name,
        ]);

        if ($group) {
            return response($group);
        }
    }
}
