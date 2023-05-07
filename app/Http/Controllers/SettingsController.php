<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $categories = Categorie::where('user_id', $user->id)->orderBy('name')->paginate(50);
        return view('settings.index', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if($request->has('auto_step')){
            $user->auto_step = 1;
        } else {
            $user->auto_step = 0;
        }
        if($request->has('show_result')){
            $user->show_result = 1;
        } else {
            $user->show_result = 0;
        }
        $user->save();
        return redirect()->route('settings.index');
    }

}
