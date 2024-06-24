<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Notifications\Contacto;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Contactos extends Component
{
    use LivewireAlert;
    public $descripcion;
    public $email;
    public $nombre;

    public function render()
    {
        return view('livewire.contactos');
    }

    public function enviarEmail()
    {

        $usuario = User::where('rol_id', '65c2889186ae85d77e058751')->first();
        //dd($usuario);
       $usuario->notify(new Contacto($this->email, $this->nombre, $this->descripcion));
       //dd($enviado);
        $this->alert('success', 'Mensaje enviado!', [
            'position' => 'top'
        ]);
    }
    public function limpiar()
    {
        $this->descripcion = '';
        $this->email = '';
        $this->nombre = '';
    }
}


