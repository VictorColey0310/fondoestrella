<?php
namespace App\Http\Livewire;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowOrganigrama extends Component
{    
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Organigrama';
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $buscar;
    public $user_id;
    public $empresa_id;
    public $eliminarItem = ['1'];
    public $persona = [
        "nombre" => "Bisabuelo",
        "relaciones" => [
            [
                "nombre" => "Padre",
                "relaciones" => [
                    [
                        "nombre" => "Abuelo Paterno",
                    ],
                    [
                        "nombre" => "Abuela Paterna",
                    ]
                ]
            ],
            [
                "nombre" => "Madre",
                "relaciones" => [
                    [
                        "nombre" => "Abuelo Materno",
                    ],
                    [
                        "nombre" => "Abuela Materna",
                    ],
                    [
                        "nombre" => "Padrastro",
                        "relaciones" => [
                            [
                                "nombre" => "Abuelo Paterno",
                            ],
                            [
                                "nombre" => "Abuela Paterna",
                                "relaciones" => [
                                    [
                                        "nombre" => "Hija peli roja",
                                        "relaciones" => [
                                            [
                                                "nombre" => "Perro negro",
                                            ],
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ],
                ]
            ],
            [
                "nombre" => "Hermano/a",
                "relaciones" => [
                    [
                        "nombre" => "Abuelo Paterno",
                        "relaciones" => [
                            [
                                "nombre" => "Abuelo Paterno",
                            ],
                            [
                                "nombre" => "Abuela Paterna",
                            ]
                        ]
                    ],
                    [
                        "nombre" => "Abuela Paterna",
                    ]
                ],

            ],
            [
                "nombre" => "Cónyuge",
            ],
            [
                "nombre" => "Hijo/a",
            ]
        ]
    ];

    public function getListeners()
    {
        return [
            'confirmed',
            'mensajeEnviado'
        ];
    }

    public function mensajeEnviado($empresa_id)
    {           
        $this->empresa_id= $empresa_id->id;
    }
    public function render()
    {        
        if(empty($this->empresa_id)){
            $this->empresa_id = config('app.empresa')->id;
        }
        
        return view('livewire.show-organigrama');
    }
}