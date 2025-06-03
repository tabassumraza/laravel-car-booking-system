<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\Admin\UserCreateRequest;
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
}