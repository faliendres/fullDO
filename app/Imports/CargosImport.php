<?php

namespace App\Imports;


use App\Cargo;
use App\Empresa;
use App\Gerencia;
use App\Holding;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CargosImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading
{
    use Importable, Queueable;

    public static $info = [];
    public static $creados = [];

    public function __construct()
    {
        static::$info = [];
        static::$creados = [];
    }

    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        $sw = true;
        foreach ([
                     "holding",
                     "empresa",
                     "gerencia",
                     "estado",
                     "area",
                     "nombre"
                 ] as $tipo) {
            if (!isset($row[$tipo])) {
                $sw = false;
                break;
            }
        }
        if (!$sw)
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

        $jefatura = (object)["id" => null];

        if (
            isset($row["gerencia_de_jefatura"]) &&
            isset($row["jefatura_directa"]) &&
            isset($row["rut_jefatura"])) {
            $gerencia_jefatura = isset(static::$info[json_encode([$row["gerencia_de_jefatura"] =>
                    ["nombre" => $row["gerencia_de_jefatura"], "id_empresa" => $empresa->id]
                ])]) ?
                static::$info[json_encode([$row["gerencia_de_jefatura"] =>
                    ["nombre" => $row["gerencia_de_jefatura"], "id_empresa" => $empresa->id]
                ])] : null;
            if (!$gerencia_jefatura) {
                $gerencia_jefatura = Gerencia::firstOrNew(["nombre" => $row["gerencia_de_jefatura"], "id_empresa" => $empresa->id]);
                if (!$gerencia_jefatura->exists)
                    return null;
                static::$info[json_encode([$row["gerencia_de_jefatura"] =>
                    ["nombre" => $row["gerencia_de_jefatura"], "id_empresa" => $empresa->id]
                ])] = ($gerencia_jefatura);
            }
            $jefe = isset(static::$info[json_encode([$row["rut_jefatura"] =>
                    ["rut" => $row["rut_jefatura"]]
                ])]) ?
                static::$info[json_encode([$row["rut_jefatura"] =>
                    ["rut" => $row["rut_jefatura"]]
                ])] : null;
            if (!$jefe) {
                $jefe = User::firstOrNew(["rut" => $row["rut_jefatura"]]);
                static::$info[json_encode([$row["rut_jefatura"] =>
                    ["rut" => $row["rut_jefatura"]]
                ])] = ($jefe);
            }
            if ($gerencia_jefatura->id && $jefe->id) {
                $jefatura =
                    isset(static::$info[json_encode([$row["jefatura_directa"] =>
                            ["nombre" => $row["jefatura_directa"], "id_gerencia" => $gerencia_jefatura->id, "id_funcionario" => $jefe->id]
                        ])]) ?
                        static::$info[json_encode([$row["jefatura_directa"] =>
                            ["nombre" => $row["jefatura_directa"], "id_gerencia" => $gerencia_jefatura->id, "id_funcionario" => $jefe->id]
                        ])] : null;
                if (!$jefatura) {
                    $jefatura = Cargo::firstOrNew(
                        ["nombre" => $row["jefatura_directa"], "id_gerencia" => $gerencia_jefatura->id, "id_funcionario" => $jefe->id]);

                    if (!$jefatura->id) {
                        $list = collect(static::$creados)->filter(
                            function ($item) use ($jefe, $row, $gerencia_jefatura) {
                                if (
                                    $item->id_funcionario === $jefe->id &&
                                    strtolower($item->nombre) === strtolower($row["jefatura_directa"])) {
                                    return true;
                                }
                                return false;
                            }
                        );
                        if (!$list->isEmpty()) {
                            $jefatura = $list->first();
                        }
                    }
                    static::$info[json_encode([$row["jefatura_directa"] =>
                        ["nombre" => $row["jefatura_directa"], "id_gerencia" => $gerencia_jefatura->id, "id_jefatura" => $jefe->id]
                    ])] = $jefatura;
                }
            }
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
            "area" => $row["area"],
            "estado" => $row["estado"],
            "id_gerencia" => $gerencia->id,
            "id_jefatura" => $jefatura->id ?? null,
            "id_funcionario" => $funcionario->id ?? null
        ]);
        if (!$cargo->exists) {
            $cargo->save();
            static::$creados[] = $cargo;
            return $cargo;
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