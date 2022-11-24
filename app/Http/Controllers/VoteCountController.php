<?php

namespace App\Http\Controllers;

use App\Models\voteCount;
use Exception;
use Illuminate\Http\Request;

class VoteCountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        try {
            $data = voteCount::all();
            return response()->json($data);
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }

    public function getVoteCount()
    {
        try {
            $count = voteCount::all()->count();
            return response()->json([
                'count' => $count
            ]);
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }

    public function getOnce($id)
    {
        try {
            $data = voteCount::find($id);
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
            voteCount::insert($request->all());
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
            $voteCount = voteCount::find($id);
            $voteCount->fill($request->all());
            $voteCount->save();

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
            voteCount::destroy($id);
            return response()->json();
        } catch (Exception $err) {
            return response()->json([
                'error' => $err
            ]);
        }
    }
}
