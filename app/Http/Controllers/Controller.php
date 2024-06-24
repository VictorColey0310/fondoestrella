<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $consulta = Informacion::first();
        $consultaApariencia = Apariencia::first();
    
        if ($consulta) {
            $rutaLogo = asset($consulta->logo);
            $nombreApp = $consulta->nombre;
            $colorBoton = $consultaApariencia->color_boton;
            $colorMenu = $consultaApariencia->color_menu;
        }
    
        $consultaModulos = auth()->user();
        dd($consultaModulos);
    
        config([
            'app.logo' => $rutaLogo,
            'app.nombre' => $nombreApp,
            'app.colorBoton' => $colorBoton,
            'app.colorMenu' => $colorMenu,
            'app.modulosActivos' => $consultaModulos,
        ]);
    
        // Resto de la lógica del controlador...
    }
    
}
