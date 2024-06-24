<?php

namespace App\Http\Middleware;

use App\Models\Apariencia;
use App\Models\empresa_seleccionada;
use App\Models\Informacion;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
    $consulta = Informacion::first(); // Realiza la consulta para obtener el logo
    $consultaApariencia = Apariencia::first();

    if ($consulta) {
        $rutaLogo = asset($consulta->logo); 
        $nombreApp = $consulta->nombre;
        $colorBoton = $consultaApariencia->color_boton ?? '';
        $colorMenu = $consultaApariencia->color_menu ?? '';
        $colorLetra = $consultaApariencia->color_letra ?? '';
        $colorLetraHover = $consultaApariencia->color_letra_hover ?? '';
    }
    
    
        if (Auth::check()) {

            $consultaModulos = Auth::user()->rol->modulos ?? null;  
            $consultaSubmodulos = Auth::user()->rol->submodulos ?? null; 
            $consultaEmpresas = Auth::user()->empresas ?? null;  

            $consultaEmpresa = Auth::user()->empresa_seleccionada;
           
            if(!empty($consultaEmpresa->first()->empresa)){
                $consultaEmpresa = Auth::user()->empresa_seleccionada->first()->empresa;
               //dd($consultaEmpresa);
            }else{
                empresa_seleccionada::create([
                    'user_id' => Auth::user()->id,
                    'empresa_id' => $consultaEmpresas->first()->id ?? ''
                ]);
                $consultaEmpresa= $consultaEmpresas->first();
            }
             
            $rol_super = Auth::user()->rol->rol_super ?? null;
           // dd($consultaEmpresa);

            config([
                'app.logo' => $rutaLogo ?? '',
                'app.nombre' => $nombreApp ?? 'U-site',
                'app.colorBoton' => $colorBoton ?? 'black',
                'app.colorMenu' => $colorMenu ?? 'white',
                'app.colorLetra' => $colorLetra ?? 'black',
                'app.colorLetraHover' => $colorLetraHover ?? 'black',
                'app.modulosActivos' => $consultaModulos ?? '',
                'app.submodulosActivos' => $consultaSubmodulos ?? '',
                'app.consultaEmpresas' => $consultaEmpresas ?? '',
                'app.empresa' => $consultaEmpresa  ,
                'app.rol_super' => $rol_super ?? '',
                
            ]);
        } else {
            config([
                'app.logo' => $rutaLogo ?? '',
                'app.nombre' => $nombreApp  ?? '',
                'app.colorBoton' => $colorBoton ?? '',
                'app.colorMenu' => $colorMenu ?? '',
        
            ]);
        }
    
        return $next($request);
    }
}
