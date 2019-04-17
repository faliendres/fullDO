<?php

namespace App\Imports;


use App\Cargo;
use App\Empresa;
use App\Gerencia;
use App\Holding;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsuariosImport implements ToArray, WithHeadingRow, ShouldQueue, WithChunkReading
{
    use Importable, Queueable;

    static $info = [];
    public $creados = [];

    /**
     * @param array $rows
     */
    public function array(array $rows)
    {
        foreach ($rows as $row) {
            $sw = true;
            foreach ([
                         "nombre",
                         "apellido",
                         "email",
                         "rut",
                         "password",
                         "perfil",
                         "estado",
                         "holding",
                         "empresa",
                         "gerencia",
                         "cargo"
                     ] as $tipo) {
                if (!isset($row[$tipo])) {
                    $sw = false;
                    break;
                }
            }
            if (!$sw)
                continue;

            $holding =
                isset(static::$info[json_encode([$row["holding"] => ["nombre" => $row["holding"]]])]) ?
                    static::$info[json_encode([$row["holding"] => ["nombre" => $row["holding"]]])] : null;
            if (!$holding) {
                $holding = Holding::firstOrNew(["nombre" => $row["holding"]]);
                if (!$holding->exists) {
                    continue;
                }
                static::$info[json_encode([$row["holding"] => ["nombre" => $row["holding"]]])] = $holding;
            }

            $empresa = isset(static::$info[json_encode([$row["empresa"] =>
                    ["nombre" => $row["empresa"], "id_holding" => $holding->id]
                ])]) ?
                static::$info[json_encode([$row["empresa"] =>
                    ["nombre" => $row["empresa"], "id_holding" => $holding->id]
                ])] : null;
            if (!$empresa) {
                $empresa = Empresa::firstOrNew(["nombre" => $row["empresa"], "id_holding" => $holding->id]);
                if (!$empresa->exists)
                    continue;
                static::$info[json_encode([$row["empresa"] =>
                    ["nombre" => $row["empresa"], "id_holding" => $holding->id]
                ])] = $empresa;
            }

            $gerencia = isset(static::$info[json_encode([$row["gerencia"] =>
                    ["nombre" => $row["gerencia"], "id_empresa" => $empresa->id]
                ])]) ?
                static::$info[json_encode([$row["gerencia"] =>
                    ["nombre" => $row["gerencia"], "id_empresa" => $empresa->id]
                ])] : null;
            if (!$gerencia) {
                $gerencia = Gerencia::query()->firstOrNew(["nombre" => $row["gerencia"], "id_empresa" => $empresa->id]);
                if (!$gerencia->exists)
                    continue;
                static::$info[json_encode([$row["gerencia"] =>
                    ["nombre" => $row["gerencia"], "id_empresa" => $empresa->id]
                ])] = $gerencia;
            }
            if(isset($row["fecha_nacimiento"])&&$row["fecha_nacimiento"])
                $fecha_nacimiento = Carbon::parse($row["fecha_nacimiento"]);
            else
                $fecha_nacimiento=null;
            $usuario = User::firstOrNew([
                "name" => $row["nombre"],
                "apellido" => $row["apellido"],
                "email" => $row["email"],
                "rut" => $row["rut"],
                "password" => Hash::make($row["password"]),
                "perfil" => $row["perfil"],
                "estado" => $row["estado"],
                "telefono" => $row["telefono"],
                "fecha_nacimiento" => $fecha_nacimiento,
                "holding_id" => $holding->id,
                "empresa_id" => $empresa->id,
                "gerencia_id" => $gerencia->id,
            ]);
            if (!$usuario->exists) {
                $usuario->save();
                $this->creados[] = $usuario;

                $cargo =
                    isset(static::$info[json_encode([$row["cargo"] =>
                            ["nombre" => $row["cargo"], "id_gerencia" => $gerencia->id]
                        ])]) ?
                        static::$info[json_encode([$row["cargo"] =>
                            ["nombre" => $row["cargo"], "id_gerencia" => $gerencia->id]
                        ])] : null;

                if (!$cargo && $row["cargo"]) {
                    $cargo = Cargo::firstOrNew(["nombre" => $row["cargo"], "id_gerencia" => $gerencia->id]);
                    static::$info[json_encode([$row["cargo"] =>
                        ["nombre" => $row["cargo"], "id_gerencia" => $gerencia->id]
                    ])] = $cargo;
                }


                if ($cargo->exists) {
                    $cargo->id_funcionario = $usuario->id;
                }
            }

        }
    }

    /**
     * @return int
     *
     */
    public function chunkSize(): int
    {
        return 100;
    }
}