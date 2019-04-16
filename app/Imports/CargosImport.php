<?php

namespace App\Imports;


use App\Cargo;
use App\Empresa;
use App\Gerencia;
use App\Holding;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CargosImport implements ToArray, WithHeadingRow, ShouldQueue,WithChunkReading
{
    use Importable,Queueable;

    static $info = [];
    public $creados=[];

    /**
     * @param array $array
     */
    public function array(array $rows)
    {


        foreach ($rows as $row) {
            $sw = true;
            foreach ([
                         "holding",
                         "empresa",
                         "gerencia",
                         "estado",
                         "color",
                         "area",
                         "descripcion",
                         "nombre"
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

            $gerencia_jefatura = isset(static::$info[json_encode([$row["gerencia_de_jefatura"] =>
                    ["nombre" => $row["gerencia_de_jefatura"], "id_empresa" => $empresa->id]
                ])]) ?
                static::$info[json_encode([$row["gerencia_de_jefatura"] =>
                    ["nombre" => $row["gerencia_de_jefatura"], "id_empresa" => $empresa->id]
                ])] : null;
            if (!$gerencia_jefatura) {
                $gerencia_jefatura = Gerencia::firstOrNew(["nombre" => $row["gerencia_de_jefatura"], "id_empresa" => $empresa->id]);
                if (!$gerencia_jefatura->exists)
                    continue;
                static::$info[json_encode([$row["gerencia_de_jefatura"] =>
                    ["nombre" => $row["gerencia_de_jefatura"], "id_empresa" => $empresa->id]
                ])] = ($gerencia_jefatura);
            }

            $jefatura =
                isset(static::$info[json_encode([$row["jefatura_directa"] =>
                        ["nombre" => $row["jefatura_directa"], "id_gerencia" => $gerencia_jefatura->id]
                    ])]) ?
                    static::$info[json_encode([$row["jefatura_directa"] =>
                        ["nombre" => $row["jefatura_directa"], "id_gerencia" => $gerencia_jefatura->id]
                    ])] : null;
            if (!$jefatura) {
                $jefatura = Cargo::firstOrNew(["nombre" => $row["jefatura_directa"], "id_gerencia" => $gerencia_jefatura->id]);
                static::$info[json_encode([$row["jefatura_directa"] =>
                    ["nombre" => $row["jefatura_directa"], "id_gerencia" => $gerencia_jefatura->id]
                ])] = $jefatura;
            }
            $funcionario = isset(static::$info[json_encode([$row["rut_funcionario"] =>
                    ["rut" => $row["rut_funcionario"]]
                ])]) ?
                static::$info[json_encode([$row["rut_funcionario"] =>
                    ["rut" => $row["rut_funcionario"]]
                ])] : null;
            if (!$funcionario) {
                $funcionario = User::firstOrNew(["rut" => $row["rut_funcionario"]]);
                static::$info[json_encode([$row["rut_funcionario"] =>
                    ["rut" => $row["rut_funcionario"]]
                ])] = ($funcionario);
            }

            $cargo = Cargo::firstOrNew([
                "nombre" => $row["nombre"],
                "descripcion" => $row["descripcion"],
                "area" => $row["area"],
                "estado" => $row["estado"],
                "id_gerencia" => $gerencia->id,
                "id_jefatura" => $jefatura->id ?? null,
                "id_funcionario" => $funcionario->id ?? null
            ]);
            if (!$cargo->exists) {
                $cargo->save();
                $this->creados[]=$cargo;
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