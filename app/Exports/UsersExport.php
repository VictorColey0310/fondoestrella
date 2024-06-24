<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;


class UsersExport implements FromArray, WithHeadings
{
    private $userIds;

    public function __construct($eliminarItem)
    {
        $this->userIds = $eliminarItem;
    }

    public function array(): array
    {
        return User::whereIn('_id', $this->userIds)
            ->with('cargo') // Carga las relaciones 'cargo' y 'plan'
            ->select(
                '_id',
                'documento',
                'name',
                'segundo_name',
                'primer_apellido',
                'segundo_apellido',
                'cargoAspira_id',
                'codigo_interno',
                'telefono',
                'planes_ids',
                'email'
            )
            ->get()
            ->map(function ($usuario) {
                return [
                    'Codigo Trabajador' => $usuario->codigo_interno,
                    'documento' => $usuario->documento,
                    'name' => $usuario->name,
                    'segundo_nombre' => $usuario->segundo_name ?? '',
                    'primer_apellido' => $usuario->primer_apellido ?? '',
                    'segundo_apellido' => $usuario->segundo_apellido ?? '',
                    'cargo' => $usuario->cargo->nombre ?? '',
                    'telefono' => $usuario->telefono ?? '',
                    'planes' => $this->planes($usuario->planes) ?? '',
                    // Reemplaza 'cargoAspira_id' por 'nombre' de la relación 'cargo'
                    // 'plan' => $usuario->plan->nombre ?? '',
                    // Reemplaza 'plan_id' por 'nombre' de la relación 'plan'
                    'email' => $usuario->email,
                ];
            })
            ->toArray();

        //dd($usuarios);
    }


    public function headings(): array
    {
        return [
            'Codigo Trabajador',
            'Documento',
            'Nombre',
            'Segundo Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Cargo',
            'Telefono',
            'Planes',
            'Email',
        ];
    }

    public function planes($planes)
    {
        $nombre_planes = [];

        foreach ($planes as $plan) {
            $nombre_planes[] = $plan->nombre;
        }

        $planes_separados_por_comas = implode(', ', $nombre_planes);

        return $planes_separados_por_comas;

    }
}