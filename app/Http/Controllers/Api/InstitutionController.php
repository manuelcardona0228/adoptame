<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Facade\FlareClient\Http\Response;

class InstitutionController extends BaseAPIController
{
    public function index()
    {
        $institutions = Institution::orderBy('id', 'asc')->get();

        return $this->sendResponse(
            $institutions, 'Se han obtenido correctamente todas las instituciones.'
        );
    }

    public function store(Request $request)
    {
        // Creamos las reglas de validación
        $rules = [
            'name'      => 'required|min:5|max:120',
            'phone'  => 'required|numeric',
            'email'     => 'required|email',
        ];

        try {
            // Ejecutamos el validador y en caso de que falle devolvemos la respuesta
            // con los errores
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return [
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ];
            }
            // Si el validador pasa, almacenamos el usuario
            $institution = Institution::create($request->all());
            return $this->sendResponse(
                $institution, 'La institutición se creo con exito.'
            );
        } catch (Exception $e) {
            // Si algo sale mal devolvemos un error.
            return $this->sendError(
                $institution, 'Error, no se ha podido crear la institución.'
            );
        }
    }

    public function show(Institution $institution)
    {
        return $this->sendResponse(
            $institution, 'Información obtenida de la institución.'
        );
    }

    public function update(Request $request, Institution $institution)
    {
        $rules = [
            'name'      => 'min:5|max:120',
            'phone'  => 'numeric',
            'email'     => 'email',
        ];

        try {
            // Ejecutamos el validador y en caso de que falle devolvemos la respuesta
            // con los errores
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return [
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ];
            }
            // Si el validador pasa, almacenamos el usuario
            $institution->fill($request->all());
            $institution->save();
            return $this->sendResponse(
                $institution, 'La institutición se actualizo con exito.'
            );
        } catch (Exception $e) {
            // Si algo sale mal devolvemos un error.
            return $this->sendError(
                $institution, 'Error, no se ha podido actualizar la institución.'
            );
        }
    }

    public function destroy(Institution $institution)
    {
        $institution->delete();

        return $this->sendResponse(
            $institution, 'La institutición se elimino con exito.'
        );
    }
}
