<?php

namespace App\Http\Livewire;

use App\Models\Seo;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowSeo extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    public $titulo;
    public $descripcion;
    public $keyword;
    public $favicon;
    public $imagen_seo;
    public $file_favicon;
    public $file_imagen_seo;
    public $usuario_actualizador;

    public function render()
    {
        $consulta = Seo::query()->first();

        //poner el $null de logo cuando se suba la imagen
        if ($consulta != null  && $this->titulo == null && $this->descripcion == null && $this->keyword == null) {
            // && $this->favicon == null && $this->imagen_seo == null
            $this->titulo = $consulta->titulo;
            $this->descripcion = $consulta->descripcion;
            $this->keyword = $consulta->keyword;
            $this->favicon = $consulta->favicon;
            $this->imagen_seo = $consulta->imagen_seo;
        }

        return view('livewire.show-seo', [
            'consulta' => $consulta,
        ]);
    }

    //CREAR 
    public function guardar()
    {
        if ($this->file_imagen_seo) {
            $this->imagen_seo = $this->file_imagen_seo->store('storage');
        }

        if ($this->file_favicon) {
            $this->favicon = $this->file_favicon->store('storage');
        }

        $this->usuario_actualizador = Auth::user()->id;
        
        $validatedData = $this->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'keyword' => 'required',
            'favicon' => 'required',
            'imagen_seo' => 'required',
        ]);

        $seo = Seo::first();

        if ($seo) {
            $seo->update($validatedData);
            $this->alert('success', 'Actualizado correctamente!', [
                'position' => 'top'
            ]);
        } else {
            Seo::create($validatedData);
            $this->alert('success', 'Creado correctamente!', [
                'position' => 'top'
            ]);
        }
    }
}
