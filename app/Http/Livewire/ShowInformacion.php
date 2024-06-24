<?php

namespace App\Http\Livewire;

use App\Models\Informacion;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class ShowInformacion extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $logo;
    public $file_logo;
    public $nombre;
    public $whatsapp;
    public $terminos_condiciones;
    public $politicas_privacidad;
    public $usuario_actualizador;
    public $upload_modelo;
    public $modelo;
    public $upload_instructivo;
    public $instructivo;

    public function render()
    {
        $consulta = Informacion::query()->first();

        //poner el $null de logo cuando se suba la imagen
        if ($consulta != null  && $this->nombre == null && $this->whatsapp == null && $this->terminos_condiciones == null && $this->politicas_privacidad == null) {
            // $this->logo = $consulta->logo;
            $this->nombre = $consulta->nombre;
            $this->whatsapp = $consulta->whatsapp;
            $this->terminos_condiciones = $consulta->terminos_condiciones;
            $this->politicas_privacidad = $consulta->politicas_privacidad;
            $this->logo = $consulta->logo;
            $this->modelo = $consulta->modelo;
            $this->instructivo = $consulta->instructivo;
        }
        
        return view('livewire.show-informacion', [
            'consulta' => $consulta,
        ]);
    }

    //CREAR 
    public function guardar()
    {
        
        if ($this->upload_modelo) {
            $nombrePersonalizado = $this->upload_modelo->getClientOriginalName();
            $this->modelo = $this->upload_modelo->storeAs('storage', $nombrePersonalizado);
        }
        
           
        if ($this->upload_instructivo) {
            
            $nombrePersonalizado = $this->upload_instructivo->getClientOriginalName();
            $this->instructivo = $this->upload_instructivo->storeAs('storage',$nombrePersonalizado);
        }
       
        

        if ($this->file_logo) {
            $this->logo = $this->file_logo->store('storage');
        }
        $this->usuario_actualizador = Auth::user()->id;
        
        $validatedData = $this->validate([
            'logo' => 'required',
            'modelo' => 'required',
            'instructivo' => 'required',
            'nombre' => 'required',
            'whatsapp' => 'required',
            'terminos_condiciones' => 'required',
            'politicas_privacidad' => 'required',
            'usuario_actualizador' => 'required',

        ]);

        $informacion = Informacion::first();

        if ($informacion) {
            $informacion->update($validatedData);
            $this->alert('success', 'Actualizado correctamente!', [
                'position' => 'top'
            ]);
        } else {
            Informacion::create($validatedData);
            $this->alert('success', 'Creado correctamente!', [
                'position' => 'top'
            ]);
        }
    }
}
