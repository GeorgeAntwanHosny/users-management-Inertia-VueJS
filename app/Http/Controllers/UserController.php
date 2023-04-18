<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Users/index', [

            'users' => User::query()
                ->when(
                    $request->input('search'), function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(8)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'can' => [
                        'edit' => Auth::user()?->can('update', $user)
                    ]
                ]),
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(Request $request): \Inertia\Response|\Illuminate\Http\RedirectResponse
    {
        if ($request->user()->cannot('create', User::class)) {
           return redirect()->route('users.index');
        }
        return Inertia::render('Users/create');
    }

    public function store(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->user()->cannot('create', User::class)) {
            return redirect()->route('users.index');
        }
        $attributes = $request->validateWithBag('users.store.validation', [
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required',
        ]);

        User::create($attributes);
        return to_route('users.index');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }
    public function update(Request $request,User $user): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        $attributes = $request->validateWithBag('users.update.validation', [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users','email')->ignore($user->id),],

        ]);

        $user->update($attributes);
        return to_route('users.index');
    }

}
