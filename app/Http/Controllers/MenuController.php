<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function settings()
    {
        return view('menu/settings');
    }
    public function modules()
    {
        return view('menu/modules');
    }
    public function roles()
    {
        return view('menu/roles');
    }
    public function users()
    {
        return view('menu/users');
    }
    public function enterprises()
    {
        return view('menu/enterprises');
    }
    public function submodules()
    {
        return view('menu/submodules');
    }
    public function categories()
    {
        return view('menu/categories');
    }

    public function admon()
    {
        //dd($slug);
        return view('menu/admon');
    }

    public function subroles()
    {
        return view('menu/subroles');
    }

    public function subusers()
    {
        return view('menu/subusers');
    }

    public function cv($user_id = null)
    {
        if (!$user_id) {
            $user_id = Auth::user()->id;
        }
        return view('menu/cv', [
            'user_id' => $user_id
        ]);
    }
    public function ficha($user_id = null)
    {
        if (!$user_id) {
            $user_id = Auth::user()->id;
        }
        return view('menu/ficha', [
            'user_id' => $user_id
        ]);
    }

    public function formato()
    {
        return view('menu/formato');
    }

    public function editarcv($user_id = null)
    {
        if (!$user_id) {
            $user_id = Auth::user()->id;
        }
        return view('menu/editarcv', [
            'user_id' => $user_id
        ]);
    }
    public function cargos()
    {
        return view('menu/cargos');
    }

    public function upload_formatos()
    {
        return view('menu/upload_formatos');
    }

    public function solicitudes()
    {
        return view('menu/solicitudes');
    }


    public function gestionar_solicitudes()
    {
        return view('menu/gestionar_solicitudes');
    }


    public function organigrama()
    {
        return view('menu.organigrama');
    }

    public function importarusuarios()
    {
        return view('menu.importarusuarios');
    }

    public function trasladarusuarios()
    {
        return view('menu.trasladarusuarios');
    }

    public function log()
    {
        return view('menu.log');
    }

    public function tratamientodatos()
    {
        return view('menu.tratamientodatos');
    }

    public function perfilempresa()
    {
        return view('menu.perfilempresa');
    }

    public function slider()
    {
        return view('menu.slider');
    }

    public function tarjetas()
    {
        return view('menu.tarjetas');
    }

    public function beneficios()
    {
        return view('menu.beneficios');
    }

    public function galeria()
    {
        return view('menu.galeria');
    }


    public function convenios()
    {
        return view('menu.convenios');
    }

    public function redessociales()
    {
        return view('menu.redessociales');
    }

    public function contacto()
    {
        return view('menu.contacto');
    }

    public function header()
    {
        return view('menu.header');
    }

    public function footer()
    {
        return view('menu.footer');
    }

    public function asociacion()
    {
        return view('menu.asociacion');
    }

    public function quienes_somos()
    {
        return view('menu.quienes_somos');
    }

    public function quienessomos()
    {
        return view('menu.quienes-somos');
    }

    public function ComoAsociarse()
    {
        return view('menu.como-asociarse');
    }

    public function ahorro()
    {
        return view('menu.ahorro');
    }

    public function credito()
    {
        return view('menu.credito');
    }

    public function creditos()
    {
        return view('menu.creditos');
    }

    public function eventos()
    {
        return view('menu.eventos');
    }

    public function auxilios()
    {
        return view('menu.auxilios');
    }

    public function convenio()
    {
        return view('menu.convenio');
    }

    public function grupo_convenios()
    {
        return view('menu.grupo_convenios');
    }

    public function contactos()
    {
        return view('menu.contactos');

    }

    public function descargadocumentos()
    {
        return view('menu.descarga-documentos');
    }

    public function vistagaleria()
    {
        return view('menu.vista-galeria');
    }

    public function normatividad()
    {
        return view('menu.normatividad');
    }

    public function clasificados()
    {
        return view('menu.clasificados');
    }

    public function gestionar_clasificados()
    {
        return view('menu.gestionar_clasificados');
    }
    public function estructura()
    {
        return view('menu/estructura');
    }
    public function organigramas()
    {
        return view('menu/organigramas');
    }
}
