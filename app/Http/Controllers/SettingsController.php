<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Exception;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getAllSettings()
    {
        try {
            return Settings::all();
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ], 403);
        }
    }

    public function create(Request $request)
    {
        try {
            return Settings::create($request->all());
        } catch (Exception $err) {
            return response()->json([
                'err' => $err
            ], 403);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $data = Settings::find($id);
            $data->fill($request->all());
            $data->save();
            return response()->json([], 200);
        } catch (Exception $err) {
            return response()->json([
                'err' => $err
            ], 403);
        }
    }

    public function delete($id)
    {
        try {
            return Settings::destroy($id);
        } catch (Exception $err) {
            return response()->json([
                'err' => $err
            ], 403);
        }
    }
}
