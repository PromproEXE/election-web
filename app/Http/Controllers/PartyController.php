<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use Exception;
use Illuminate\Support\Facades\Validator;

class PartyController extends Controller
{
    public function getAll()
    {
        try {
            $data = Party::all();
            return response()->json($data);
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }

    public function create(Request $input)
    {
        Validator::make($input->all(), [
            'party_number' => ['required'],
            'party_name' => ['required', 'string']
        ])->validate();

        return Party::create([
            'party_number' => $input['party_number'],
            'party_name' => $input['party_name']
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Party::find($id);
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
            Party::destroy($id);
            return response()->json();
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }
}
