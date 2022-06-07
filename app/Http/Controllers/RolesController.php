<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = ($request->search)??'';
        $role = ($request->role)??'';

        $lista = Role::orderBy('created_at', 'DESC')
            ->where(function($x) use($search) {
                if ($search != '') {
                    $x->where('name', 'like', '%'.$search.'%');
                }
            })
            ->paginate(20);

        return view('roles.index', [
            'lista' => $lista
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.nuevo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^([^0-9]*)$/',
            'description' => 'required|string|max:255|regex:/^([^0-9]*)$/'
        ]);

        $rol = new Role;
        $rol->name = $request->name;
        $rol->description = $request->description;
        $rol->save();

        return redirect('/roles/lista')->with('ok', 'Registro éxitoso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol = Role::find($id);

        return view('roles.editar', [
            'rol' => $rol
        ]);
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
        $request->validate([
            'name' => 'required|string|max:255|regex:/^([^0-9]*)$/',
            'description' => 'required|string|max:255|regex:/^([^0-9]*)$/'
        ]);

        $rol = Role::find($id);
        $rol->name = $request->name;
        $rol->description = $request->description;
        $rol->save();
        
        return redirect('/roles/lista')->with('ok', 'Datos actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = Role::find($id);
        $del->delete();

        return back()->with('ok', 'Rol eliminado con éxito.');
    }
}
