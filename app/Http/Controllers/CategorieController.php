<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    private $rules = [
        'name' => 'required|max:255',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $categories = Categorie::where('user_id', $user->id)->orderBy('name')->paginate(50);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $data = $request->validate($this->rules);
        $user = auth()->user();
        $data['user_id'] = $user->id;
        Categorie::create($data);
        return response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categorie = Categorie::findOrFail($id);
        $user = auth()->user();
        if( $categorie->user_id != $user->id){
            return response()->json(['success' => false], 401);
        }
        return response()->json($categorie);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules);
        $categorie = Categorie::findOrFail($id);
        $user = auth()->user();
        if( $categorie->user_id != $user->id){
            return response()->json(['success' => false], 401);
        }
        $categorie->update($data);
        return response()->json(['success' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $categorie = Categorie::findOrFail($id);
            $user = auth()->user();
            if( $categorie->user_id != $user->id){
                return response()->json(['success' => false], 401);
            }
            $categorie->delete();
        } catch (Exception $e) {
            return response()->json(['success' => false], 404);
        }
        return response()->json(['success' => true], 200);
    }
}
