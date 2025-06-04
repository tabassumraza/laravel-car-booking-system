<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        // $this->middleware('can:AdminMiddleware'); 

            $this->userService = new userService();
        $this->userService = $userService;

    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserCreateRequest $request)
    {

        $user = $this->userService->createUser($request->validated());
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'User created successfully!');
    }
    public function edit(User $user)
{
    return view('admin.users.edit', compact('user'));
}

public function update(UserUpdateRequest $request, User $user)
{
    $user->update($request->validated());
    return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
}



}