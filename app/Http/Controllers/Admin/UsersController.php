<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with(['roles'])->get();

        $roles = Role::get();

        return view('admin.users.index', compact('roles', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        // $user = User::create($request->all());
        // $user->roles()->sync($request->input('roles', []));



        // return redirect()->route('admin.users.index');
        $data = $request->all();

        // Store plain password temporarily
        $plainPassword = $data['password'];

        // Hash password
        $data['password'] = Hash::make($plainPassword);

        // Create user
        $user = User::create($data);

        // Attach roles
        $user->roles()->sync($request->input('roles', []));

        // Send welcome email with plain password
        $user->notify(new WelcomeUserNotification($user, $plainPassword));

        return redirect()->route('admin.users.index')->with('success', 'User created and email sent!');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        // Send email notification for user update
    $user->notify(new WelcomeUserNotification($user, $request->input('password')));  // Send the notification

        // return redirect()->route('admin.users.index');
        return redirect()->route('admin.users.index')->with('success', 'User updated and email sent!');
    }

    public function show(User $user)
    {
        // abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $users = User::find(request('ids'));

        foreach ($users as $user) {
            $user->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}