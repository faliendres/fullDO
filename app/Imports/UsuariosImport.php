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
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsuariosImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading
{
    use Importable, Queueable;

    static $info = [];
    public $creados = [];

    public function model(array $row)
    {
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
                     "gerencia"
                 ] as $tipo) {
            if (!isset($row[$tipo])) {
                $sw = false;
                break;
            }
        }
        if (!$sw)
            return null;

        $usuario = isset(static::$info[json_encode([$row["email"] => ["email" => $row["email"]]])]) ?
            static::$info[json_encode([$row["email"] => ["email" => $row["email"]]])] : null;

        if (!$usuario) {
            $usuario = User::where("email", $row["email"])->get()->first();
            if ($usuario) {
                static::$info[json_encode([$row["email"] => ["email" => $row["email"]]])] = $usuario;
                return null;
            }
        } else
            return null;

        $usuario = isset(static::$info[json_encode([$row["rut"] => ["rut" => $row["rut"]]])]) ?
            static::$info[json_encode([$row["rut"] => ["rut" => $row["rut"]]])] : null;

        if (!$usuario) {
            $usuario = User::where("rut", $row["rut"])->get()->first();
            if ($usuario) {
                static::$info[json_encode([$row["rut"] => ["rut" => $row["rut"]]])] = $usuario;
                return null;
            }
        } else
            return null;

        $holding =
            isset(static::$info[json_encode([$row["holding"] => ["nombre" => $row["holding"]]])]) ?
                static::$info[json_encode([$row["holding"] => ["nombre" => $row["holding"]]])] : null;
        if (!$holding) {
            $holding = Holding::firstOrNew(["nombre" => $row["holding"]]);
            if (!$holding->exists) {
                return null;
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
                return null;
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
                return null;
            static::$info[json_encode([$row["gerencia"] =>
                ["nombre" => $row["gerencia"], "id_empresa" => $empresa->id]
            ])] = $gerencia;
        }

        $fecha_nacimiento = null;
        if (isset($row["fecha_nacimiento"]) && $row["fecha_nacimiento"]) {

            if (is_numeric($row["fecha_nacimiento"])) {
                $int = intval($row["fecha_nacimiento"]) - 2;
                $date = Carbon::createFromDate(1900, 1, 1)->setTime(0, 0, 0);
                $date->addDays($int);
            } else {
                $date = Carbon::createFromFormat("d/m/Y", $row["fecha_nacimiento"]);
            }

            $fecha_nacimiento = $date;
        }

        $fecha_inicio = null;
        if (isset($row["fecha_inicio"]) && $row["fecha_inicio"]) {
            if (is_numeric($row["fecha_inicio"])) {
                $int = intval($row["fecha_inicio"]) - 2;
                $date = Carbon::createFromDate(1900, 1, 1)->setTime(0, 0, 0);
                $date->addDays($int);
            } else {
                $date = Carbon::createFromFormat("d/m/Y", $row["fecha_inicio"]);
            }

            $fecha_inicio = $date;
        }


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
            "fecha_inicio" => $fecha_inicio,
            "holding_id" => $holding->id,
            "empresa_id" => $empresa->id,
            "gerencia_id" => $gerencia->id,
        ]);
        if (!$usuario->exists) {
            $usuario->save();
            $this->creados[] = $usuario;

            if (isset($row["cargo"])) {
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
            return $usuario;
        }
        return null;
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