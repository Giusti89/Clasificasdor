<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class AdministracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('administracion.usuarios.index');
        } catch (\Exception $e) {
            
            return response()->view('errors.500', [], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $encryptedId)
    {
        try {
            
            $id = Crypt::decrypt($encryptedId);               
            $user = User::find($id);    
            $rol = Rol::pluck('id', 'nombre');
            return view('administracion.usuarios.edit', compact('user', 'rol'));
        } catch (DecryptException $e) {
            
            return Redirect::route('adminIndex')->with('msj', 'error');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ( $user = User::findOrFail($id)) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'rol' => ['required'],
                'password' => ['nullable', 'min:8'],
                'file' => ['nullable', 'image', 'max:10240'],
            ]);
    
            $user->name = $request->name;
            $user->email = $request->email;
            $user->rol_id = $request->rol;
    
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
    
            if ($request->hasFile('file')) {
                if ($user->image_url) {
                    Storage::disk('public')->delete('avatar/' . $user->image_url);
                }
    
                $fileName = time() . '.' . $request->file->extension();
                $request->file->move(public_path('avatar'), $fileName);
                $user->image_url = $fileName;
            }
    
            $user->update();
    
            return Redirect::route('adminIndex')->with('msj', 'cambio');
        }else{
            return Redirect::route('adminIndex')->with('msj', 'error');
        }

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $usucli = User::findOrFail($id);
            if ($usucli->users()->exists()) {
                return redirect()->route('adminIndex')->with(['msj' => 'error']);
            }
            $usucli->delete();
            return redirect()->route('adminIndex')->with('msj', 'ok');
        } catch (\Throwable $th) {
            return redirect()->route('adminIndex')->with('success', 'ok');
        }
    }
}
