<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Requerimiento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PublicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('docentes.menu.index');
    }

    public function ver($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $reque = Requerimiento::findOrFail($id);

        $this->authorize('autor', $reque);

        $items = Item::where('requerimiento_id', '=', $id)->paginate(5);

        return view('docentes.menu.ver', compact('id', 'items', 'reque'));
    }

    public function pgenerarPpdf($encryptedId)
    {
        PDF::setOptions(['isRemoteEnabled' => true]);
        $id = Crypt::decrypt($encryptedId);
        $item = Item::find($id);
        $pdf=Pdf::loadView('docentes.menu.itempdf', compact('item'));
        return $pdf->stream('reporte_Item.pdf');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
