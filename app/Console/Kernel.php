<?php

namespace App\Console;

use App\Models\Empresas;
use App\Models\Log;
use App\Models\Roles;
use App\Models\User;
use App\Notifications\backup;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            //Log::info('La tarea programada se ejecutó correctamente.');

            $roles = Roles::where('rol_administrador', true)->get();
        //dd($roles);
        foreach ($roles as $rol) {
            
            foreach ($rol->usuarios as $usuario) {
                foreach ($usuario->empresas as $empresa) {
                    $backup = json_encode($empresa->usuarios, JSON_PRETTY_PRINT);
        
                    // Genera un nombre de archivo único (puedes personalizar esto según tus necesidades)
                    $nombreArchivo = 'backup_' . uniqid() . '.json';
        
                    // Almacena el JSON en el almacenamiento local
                    Storage::put('storage/' . $nombreArchivo, $backup);
        
                    // Verifica la URL del archivo almacenado
                    $urlArchivo = Storage::url($nombreArchivo);
        
                    // Envía una notificación al usuario (descomenta esta línea si deseas activar las notificaciones)
                    $usuario->notify(new backup($usuario->name, $empresa->nombre, $urlArchivo));
        
                    // Registra un log de la operación
                    $logTraslado = new Log([
                        'user_id' => $usuario->id,
                        'usuario_actualizador' => $usuario->id,
                        'empresa_id' => $empresa->id,
                        'detalle' => 'Envío de backup a ' . $empresa->nombre, // Corregido el formato del detalle
                    ]);
        
                    $logTraslado->save();
                }
            }
        }
            //dd($usuarios_id);
        })->twiceDailyAt(12, 18, 24);
    }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
