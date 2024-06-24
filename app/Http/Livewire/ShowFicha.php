<?php

namespace App\Http\Livewire;

use App\Models\Certificado;
use App\Models\Educacion;
use App\Models\Laboral;
use App\Models\Noformal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowFicha extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;

    public $nombreCrud = 'Ficha';
    public $user;
    public $user_id;


    public function render()
    {
        $this->user = Auth::user();

        if (empty($this->user_id)) {
            $this->user_id = $this->user->id;
        }

        $consulta = User::find($this->user_id);

        $consultaCertificados = Certificado::where('user_id', $this->user_id)->first();
        $consultaEducacion = Educacion::where('user_id', $this->user_id)->first();
        $consultaLaboral = Laboral::where('user_id', $this->user_id)->get();
        $consultaNoformal = Noformal::where('user_id', $this->user_id)->get();


        return view('livewire.show-ficha', compact('consulta', 'consultaCertificados', 'consultaEducacion', 'consultaLaboral', 'consultaNoformal'));
    }

}
