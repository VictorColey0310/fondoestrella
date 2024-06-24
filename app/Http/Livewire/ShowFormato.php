<?php
namespace App\Http\Livewire;


use App\Models\Formatos;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use ZipArchive;



class ShowFormato extends Component
{

    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = "Formatos";
    public $nombre;
    public $descripcion;
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $consultaVer;
    public $buscar;
    public $archivo;
    public $upload_archivo;
    public $empresa_id;

    public $eliminarItem = ['1'];

    public function getListeners()
    {
        return [
            'mensajeEnviado'
        ];
    }

    public function mensajeEnviado($empresa_id)
    {

        $this->empresa_id = $empresa_id;

    }
    public function render()
    {

        $buscar = $this->buscar;
        if (empty($this->empresa_id)) {
            $this->empresa_id = config('app.empresa')->id;
        }
        $consulta = Formatos::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
            })
            ->where('empresa_id', $this->empresa_id)->paginate(20);

        return view('livewire.show-formato', [
            'consulta' => $consulta,

        ]);
    }




    //VER
    public function ver($id)
    {
        $this->consultaVer = Formatos::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->archivo = $this->consultaVer->archivo;
        $this->ver = true;

    }
    public function limpiarInput()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->archivo = '';
        $this->upload_archivo = '';


    }

    public function download()
    {
        $archivos = Formatos::whereIn('_id', $this->eliminarItem)->get();
        $tempFolderPath = storage_path('app/temp'); // Carpeta temporal donde se guardarán los archivos
    
        if (!file_exists($tempFolderPath)) {
            mkdir($tempFolderPath, 0777, true);
        }
    
        $zipFileName = 'archivos_descargados.zip';
        $zipFilePath = $tempFolderPath . '/' . $zipFileName;
    
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach ($archivos as $archivo) {
                $rutaArchivo = $archivo->archivo; // Suponiendo que el campo de la ruta del archivo se llama 'archivo'
    
                // Verificamos que el archivo exista antes de agregarlo al zip
                if (Storage::exists($rutaArchivo)) {
                    // Copiamos el archivo a la carpeta temporal
                    $archivoNombre = pathinfo($rutaArchivo, PATHINFO_BASENAME);
                    copy(Storage::path($rutaArchivo), $tempFolderPath . '/' . $archivoNombre);
    
                    // Agregamos el archivo a la compresión del zip
                    $zip->addFile($tempFolderPath . '/' . $archivoNombre, $archivoNombre);
                }
            }
            $zip->close();
    
            // Verificamos que el archivo zip se haya creado correctamente
            if (file_exists($zipFilePath)) {
                // Descargamos el archivo zip al usuario desde el directorio storage
                return response()->download($zipFilePath)->deleteFileAfterSend(true);
            } else {
                // Si no se puede crear el archivo zip, puedes devolver una respuesta de error o realizar otra acción
                return response()->json(['error' => 'No se pudo crear el archivo zip'], 500);
            }
        } else {
            // Si no se puede abrir el archivo zip, puedes devolver una respuesta de error o realizar otra acción
            return response()->json(['error' => 'No se pudo abrir el archivo zip'], 500);
        }
    }
    
}