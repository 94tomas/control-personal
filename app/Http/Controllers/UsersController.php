<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
use Auth;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = ($request->search)??'';
        $role = ($request->role)??'';

        $lista = User::orderBy('created_at', 'DESC')
            ->where(function($x) use($search) {
                if ($search != '') {
                    $x->where('username', 'like', '%'.$search.'%');
                    $x->orWhere('name', 'like', '%'.$search.'%');
                    $x->orWhere('last_name', 'like', '%'.$search.'%');
                }
            })
            ->whereHas('roles', function($q) use($role) {
                if ($role != '') {
                    $q->where('name', $role);
                } else {
                    $q->where('name', '!=', 'client');
                }
            })
            ->paginate(20);

        return view('users.index', [
            'lista' => $lista
        ]);
    }
    public function create()
    {
        return view('users.nuevo');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^([^0-9]*)$/',
            'last_name' => 'required|string|max:255|regex:/^([^0-9]*)$/',
            'direction' => 'required|string|max:255',
            'phone' => 'required',
            'ci' => 'required|numeric|unique:users',
            'birthday' => 'required',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required',
        ]);

        // if ($request->role == 'distributor') {
        //     if (User::where('zone_id', $request->zone)->exists()) {
        //         return back()->with('error', 'Ya existe un distribuidor registrado en la zona seleccionada.')->withInput();
        //     }
        // }

        $user = new User;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->direction = $request->direction;
        $user->phone = $request->phone;
        $user->ci = $request->ci;
        $user->birthday = $request->birthday;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = ($request->status=='on')?1:0;
        $user->save();
        $user->roles()->attach(Role::where('name', $request->role)->first());

        return redirect('/usuarios/lista')->with('ok', 'Registro éxitoso.');
    }
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.editar', [
            'user' => $user
        ]);
    }
    public function show($id)
    {
        $user = User::find($id);

        return view('users.ver', [
            'user' => $user
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^([^0-9]*)$/',
            'last_name' => 'required|string|max:255|regex:/^([^0-9]*)$/',
            'direction' => 'required|string|max:255',
            'phone' => 'required',
            'ci' => 'required|numeric|unique:users,ci,' . $id,
            'birthday' => 'required',
            'username' => 'required|string|unique:users,username,' . $id,
            'email' => 'required|string|email|unique:users,email,' . $id,
            'role' => 'required',
        ]);

        $user = User::find($id);

        if(@$request->password) {
            $this->validate($request, [
                'password' => 'required|min:8'
            ]);
            $user->password = bcrypt($request->password);
        }
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->direction = $request->direction;
        $user->phone = $request->phone;
        $user->ci = $request->ci;
        $user->birthday = $request->birthday;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->status = ($request->status=='on')?1:0;
        $user->save();

        $user->save();

        if ($user->roles[0]->name != $request->role) {
            $user->roles()->detach();
            $user->roles()->attach(Role::where('name', $request->role)->first());
        }
        
        return redirect('/usuarios/lista')->with('ok', 'Datos actualizado exitosamente.');
    }
    public function enableBuy(Request $request, $id)
    {
        $enable = User::find($id);
        $enable->if_buy = !$enable->if_buy;
        $enable->save();

        return back()->with('ok', ($enable->if_buy)?'Se inhabilito para realizar compras':'Se habilito para realizar compras');
    }
    /**
     * destroy
     */
    public function destroy($id)
    {
        $del = User::find($id);
        $del->delete();

        return back()->with('ok', 'Usuario eliminado con éxito.');
    }

    /**
     * report
     */
    public function reportUsers(Request $request)
    {
        $search = ($request->search)??'';
        $role = ($request->role)??'';

        $lista = User::orderBy('created_at', 'DESC')
            ->where(function($x) use($search) {
                if ($search != '') {
                    $x->where('username', 'like', '%'.$search.'%');
                    $x->orWhere('name', 'like', '%'.$search.'%');
                    $x->orWhere('last_name', 'like', '%'.$search.'%');
                }
            })
            ->whereHas('roles', function($q) use($role) {
                if ($role != '') {
                    $q->where('name', $role);
                } else {
                    $q->where('name', '!=', 'client');
                }
            })
            ->get();
    
        $pdf = \PDF::loadView('users.users-pdf', [
            'lista' => $lista
        ]);
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('usuarios.pdf');
        
        // return view('users.users-pdf', [
        //     'lista' => $lista
        // ]);
    }
}
