<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Pet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PetController extends BaseAPIController
{
    public function index()
    {
        $pets = Pet::with(['species', 'breed', 'institution'])->orderBy('id', 'asc')->get();

        return $this->sendResponse(
            $pets, 'Se han obtenido correctamente todas mascotas.'
        );
    }

    public function store(Request $request)
    {
        // // Creamos las reglas de validación
        $rules = [
            'name' => 'required|min:3|max:100',
            'photo' => 'image|mimes:png,jpg,jpeg|max:1024',
            'species_id' => 'required',
            'breed_id' => 'required',
            'institution_id' => 'required'
        ];

        try {
            $input = $request->except('photo');
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
            if($request->hasFile('photo'))
            {
                $img = $request->file('photo')->store('public/pets');
                $path = Storage::url($img);
                $input['photo_url'] = $path;
            }
            $pet = Pet::create($input);
            return $this->sendResponse(
                $pet, 'La mascota se creo con exito.'
            );
        } catch (Exception $e) {
            // Si algo sale mal devolvemos un error.
            return $this->sendError(
                $pet, 'Error, no se ha podido crear la mascota.'
            );
        }
    }

    public function show(Pet $pet)
    {
        return $this->sendResponse(
            $pet, 'Se ha obtenido correctamente la información de la mascota.'
        );
    }

    public function updatePhoto(Request $request, Pet $pet)
    {
        $pet->photo_url ? $photo_exists = explode('/', $pet->photo_url) : $photo_exists = null;
        if($photo_exists != null)
        {
            if($request->hasFile('photo'))
            {
                if (Storage::disk('public')->exists($photo_exists[2].'/'.$photo_exists[3]))
                {
                    Storage::disk('public')->delete($photo_exists[2].'/'.$photo_exists[3]);
                }
                $img = $request->file('photo')->store('public/pets');
                $path = Storage::url($img);
                $pet->photo_url = $path;
                $pet->save();
                return $this->sendResponse(
                    $pet, 'La imagen de la mascota se actualizo con exito.'
                );
            }
        }else{
            $img = $request->file('photo')->store('public/pets');
            $path = Storage::url($img);
            $pet->photo_url = $path;
            $pet->save();
            return $this->sendResponse(
                $pet, 'La imagen de la mascota se actualizo con exito.'
            );
        }

    }

    public function update(Request $request, Pet $pet)
    {
        $rules = [
            'name' => 'min:3|max:100',
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
            $pet->fill($request->all());
            $pet->save();
            return $this->sendResponse(
                $pet, 'La mascota se actualizo con exito.'
            );
        } catch (Exception $e) {
            // Si algo sale mal devolvemos un error.
            return $this->sendError(
                $pet, 'Error, no se ha podido actualizar la mascota.'
            );
        }
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();

        return $this->sendResponse(
            $pet, 'La mascota se elimino con exito.'
        );
    }
}
