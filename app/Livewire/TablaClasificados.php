<?php

namespace App\Livewire;

use App\Models\Requerimiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TablaClasificados extends Component
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
               
                ->where(function ($query) {
                    $query->where('estado', 'clasificado')
                        ->orWhere(function ($query) {
                            $query->where('estado', 'clasificado')
                                ->whereHas('carrera', function ($query) {
                                    $query->where('nombre', 'Administracción');
                                });
                        });
                })
                ->orderByRaw("FIELD(estado, 'aprobado', 'pendiente') ASC")
                ->paginate($this->paginate);
        }
        return view('livewire.tabla-clasificados', [
            'requerimientos' => $requerimientos,
        ]);
        
    }
}
