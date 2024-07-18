<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class TablaInicio extends Component
{
    use WithPagination;

    public $searchMonth;
    public $paginate;

    public function mount()
    {
        $this->paginate = 10;
        $this->searchMonth = Carbon::now()->format('Y-m');
    }

    public function updatingSearchMonth()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $role = $user->rol->nombre;
        $carreraIds = $user->carreras->pluck('id')->toArray();

        $monthYear = explode('-', $this->searchMonth);
        $month = $monthYear[1] ?? Carbon::now()->month;
        $year = $monthYear[0] ?? Carbon::now()->year;

        
        
        if ($role == 'Dir Administrativo') {
            
            $requerimientos = Requerimiento::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('estado',"aprobado")
                ->paginate($this->paginate);

        } elseif ($role == 'Jefe de carrera') {
            
            $requerimientos = Requerimiento::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('estado',"listo")
                ->whereIn('carrera_id', $carreraIds)                
                ->paginate($this->paginate);
                
        } elseif ($role == 'Coordinador de Carrera' && $role == 'Docente') {
            
            $requerimientos = Requerimiento::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->whereIn('carrera_id', $carreraIds)
                ->paginate($this->paginate);
        } else {
            
            $requerimientos = Requerimiento::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->whereIn('carrera_id', $carreraIds)
                ->paginate($this->paginate);
        }

        return view('livewire.tabla-inicio', [
            'requerimientos' => $requerimientos,
        ]);
    }
}
