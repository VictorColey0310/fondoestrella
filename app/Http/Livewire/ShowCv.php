<?php

namespace App\Http\Livewire;

use App\Models\Certificado;
use App\Models\Educacion;
use App\Models\Laboral;
use App\Models\Noformal;
use App\Models\TratamientoDatos;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;


class ShowCv extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;

    public $user;
    public $user_id;
    public $modalDatos = false;
    public $politicasDatos;

    public function render()
    {

        $this->user = Auth::user();
        $datos = $this->user->datos;
        //dd($datos);

        if (empty($this->empresa_id)) {
            $this->empresa_id = config('app.empresa');
        }

        $this->politicasDatos = TratamientoDatos::where('empresa_id', $this->empresa_id->id)->orderBy('created_at', 'desc')->first();
        if (!empty($this->politicasDatos)) {
            if (!empty($datos)) {

                if ($datos->id != $this->politicasDatos->id) {

                    $this->modalDatos = true;
                }
            } else {
                $this->modalDatos = true;
            }
        }


        if (empty($this->user_id)) {
            $this->user_id = $this->user->id;
        }


        $consulta = User::find($this->user_id);
        $consultaCertificados = Certificado::where('user_id', $this->user_id)->first();

        $consultaEducacion = Educacion::where('user_id', $this->user_id)->get();
       
        $consultaLaboral = Laboral::where('user_id', $this->user_id)->whereNotNull('certificado_laboral')->latest('created_at')->first();
        $consultaCertificacionLaboral = Laboral::where('user_id', $this->user_id)->whereNotNull('certificacion_laboral')->latest('created_at')->first();

        $consultaNoformal = Noformal::where('user_id', $this->user_id)->get();


        return view('livewire.show-cv', compact('consulta', 'consultaCertificados', 'consultaCertificacionLaboral', 'consultaEducacion', 'consultaLaboral', 'consultaNoformal'));
    }

    public function aceptar()
    {

        $id = $this->politicasDatos->id;
        $this->user->update(['datos_id' => $id]);

        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
