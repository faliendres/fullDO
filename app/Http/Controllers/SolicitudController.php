<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solicitud;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\SolicitudEmail;
use Log;


class SolicitudController extends Controller
{
    protected $clazz = Solicitud::class;
    protected $resource = "solicitudes";

    public function __construct()
    {
        $this->rules = [
            "tipo" => ["required", Rule::in(Solicitud::TIPOS)],
            "destinatario_id" => "required|exists:users,id",
            "asunto" => "required|max:190",
            "descripcion" => "required|max:255",
        ];
    }

    public function update($id, Request $request)
    {
        $rules = collect($this->rules)->map(function ($item) use ($id) {
            return str_replace("{id}", $id, $item);
        })->all();
        $this->validate($request, $rules);
        $this->uploadFile($request);
        $instance = $this->clazz::find($id);
        if ($instance) {
            if ($instance instanceof Solicitud)
                $data = collect($request->only($instance->getFillable()))->filter(function ($item) {
                    return isset($item);
                })->all();
            foreach ($data as $field => $value)
                if ($instance->$field != $value){
                    if($field=='estado'){
                        //Enviar email
                    }
                    $instance->$field = $value;
                }
            $instance->update();
            if ($request->ajax())
                return response()->json($instance, 200);
            return redirect()->route("$this->resource.show", ["id" => $instance->id]);
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }

    public function store(Request $request)
    {

        $result = parent::store($request);
        $solicitud = Solicitud::findOrFail($request->get("new_id"));

        try{
                Mail::to(User::findOrFail($solicitud->destinatario_id)->email)
                ->cc($request->user())
                ->send(new SolicitudEmail($solicitud));
                \Log::info('Envio correctamente el email');
            }
            catch(\Exception $e){ 
                \Log::info('-------Error Sending Mail: '.$e->getMessage());
            }

        return $result;

    }

}
