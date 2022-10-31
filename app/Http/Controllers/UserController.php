<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAll()
    {
        try {
            $data = User::all();
            return response()->json($data);
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }

    public function getOnce()
    {
    }

    public function getMe()
    {
        if (Auth::check()) {
            return Auth::user();
        } else {
            return response()->json([], 403);
        }
    }

    public function create(Request $input)
    {
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => [
                'elector' => false,
                'register' => false,
                'monitor' => false,
                'admin' => true
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = User::find($id);
            $data->fill($request->all());
            return $data->save();
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }

    public function delete($id)
    {
        try {
            User::destroy($id);
            return response()->json();
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }
}
