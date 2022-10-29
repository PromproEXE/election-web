<?php

namespace App\Http\Controllers;

use App\Models\Elector;
use Exception;
use Illuminate\Http\Request;

class ElectorController extends Controller
{
    protected $elector;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        try {
            $data = Elector::all();
            return response()->json($data);
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }

    public function getOnce($id)
    {
        try {
            $data = Elector::find($id);
            return response()->json($data);
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $electors = Elector::insert($request->all());
            return response()->json();
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Elector  $elector
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $elector = Elector::find($id);
            $elector->fill($request->all());
            $elector->save();

            return response()->json();
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Elector  $elector
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            Elector::destroy($id);
            return response()->json();
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }
}
