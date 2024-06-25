<?php

namespace App\Livewire;

use App\Models\Carrera;
use Livewire\Component;
use Livewire\WithPagination;

class TablaCarrera extends Component
{
    use WithPagination;
    
    public $search;
    public $paginate;

    public function mount()
    {
        $this->paginate = 10;
    }
    public function render()
    {
        $paginate = is_numeric($this->paginate) && $this->paginate > 0 ? $this->paginate : 10;

        $carrera = Carrera::select('carreras.id as id', 'carreras.nombre as nombre', 'presupuestos.monto as presupuesto')
        ->join('presupuestos', 'presupuestos.carrera_id', '=', 'carreras.id')
        ->where('carreras.nombre', 'like', '%' . $this->search . '%')
        ->paginate($paginate);

    return view('livewire.tabla-carrera', compact('carrera'));
    }
}
