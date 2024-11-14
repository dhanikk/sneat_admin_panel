<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Repositories\FlashRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $flashRepository;

    public function __construct() {
        $this->flashRepository = new FlashRepository;
    }

    public function index() {
        if (request()->ajax()) {
            $users = User::query();

            if (!auth()->user()->hasRole('Admin')) {
                $users = $users->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'Admin');
                });
            }

            $users = $users->get();
            if (auth()->user()->hasRole('Admin')) {
                $users = User::all();
            }

            return datatables()->of($users)
                ->addColumn('role', function ($row) {
                    return $row->roles->pluck('name')->implode(', ');
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= '<button title="Change status" class="toggle-btn btn btn-' . ($row->is_enable ? 'success' : 'danger') . ' btn-xs" style="width: 50px;" data-id="' . $row->id . '" data-state="' . ($row->is_enable ? 'enable' : 'disable') . '">' . ($row->is_enable ? 'Enable' : 'Disable') . '</button>';
                    if (auth()->user()->can('view.user')) {
                        $btn .= '<a title="View user" href="javascript:void(0)" class="btn btn-success btn-xs view-user ml-2" data-id="' . $row->id . '"> <i class="fa fa-eye"></i> </a>';
                    }
                    if (auth()->user()->can('update.user')) {
                        $btn .= '<a title="Edit user" href="' . route('user.edit', ['user' => $row->id]) . '" class="btn btn-success btn-xs edit-user ml-2"> <i class="fa fa-edit"></i> </a>';
                    }
                    if (auth()->user()->can('delete.user')) {
                        $btn = $btn . '&nbsp;&nbsp;<button title="Delete user" type="submit" class="btn btn-danger btn-xs delete-user" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                    }

                    return $btn;
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('users.list');
    }

    public function view(Request $request) {
        $userData = User::with('roles')->find($request->id);
        if ($userData) {
            return view('users.user_details', ['userData' => $userData]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::where('is_enable', 1)->get();
        return view('users.form', ['user' => new User(), 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserPostRequest $userPostRequest) {
        $userPostRequest->validated();
        $directory = 'public/user_images';
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory, 0777, true); // Create the directory recursively
        }
        if ($userPostRequest->has('user_profile_image')) {
            $base64String = substr($userPostRequest->user_profile_image, strpos($userPostRequest->user_profile_image, ',') + 1);
            $imageData = base64_decode($base64String);
            $imageName = uniqid() . '.jpg';
            Storage::put("public/user_images/$imageName", $imageData);
            $imagePath = Storage::url("public/user_images/$imageName");
        } else {
            $imagePath = NULL;
        }

        // Create the user with the provided details, including the image path
        $user = User::create([
            'name' => $userPostRequest->name,
            'email' => $userPostRequest->email,
            'password' => Hash::make($userPostRequest->password),
            'user_image' => $imagePath, // Store the image path in the database
        ]);
        $user->assignRole($userPostRequest->role);
        if (!$user) {
            $this->flashRepository->setFlashSession('alert-danger', 'Something went wrong!');
            return redirect()->route('user.index');
        } else {
            $this->flashRepository->setFlashSession('alert-danger', 'User went created!');
            return redirect()->route('user.index');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function edit(User $user) {
        $roles = Role::where('is_enable', 1)->get();
        $users = User::whereNot('id', $user->id)
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Admin');
            })->get();
        $viewData = array(
            'user' => $user,
            'roles' => $roles,
            'users' => $users,
        );
        return view('users.form', $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id) {
        $request->validated();

        $userData = User::find($id);
        $userData->roles()->detach();
        $userData->assignRole($request->role);
        $directory = 'public/user_images';
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory, 0777, true);
        }
        if ($request->has('user_profile_image')) {
            $base64String = substr($request->user_profile_image, strpos($request->user_profile_image, ',') + 1);
            $imageData = base64_decode($base64String);
            $imageName = uniqid() . '.jpg';
            Storage::put("public/user_images/$imageName", $imageData);
            $imagePath = Storage::url("public/user_images/$imageName");
        } else {
            $imagePath = NULL;
        }
        $userData->update([
            'name' => $request->name,
            'email' => $request->email,
            'user_image' => $imagePath,
        ]);
        if (isset($request->password)) {
            $userData->update([
                'password' => Hash::make($request->password),
            ]);
        }
        $this->flashRepository->setFlashSession('alert-success', 'User updated successfully.');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->is_enable = 0;
        $user->save();
        $user->delete();
        if ($user) {
            return response()->json(['msg' => 'User deleted successfully!'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong, please try again.'], 200);
        }
    }

    public function updateStatus(Request $request, $userId) {
        $user = User::findOrFail($userId);
        $user->is_enable = $request->state === 'Enable' ? 1 : 0;
        $user->save();
        return response()->json(['message' => 'User status toggled successfully.']);
    }
}
