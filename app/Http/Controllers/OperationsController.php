<?php

namespace App\Http\Controllers;

use App\Models\clustersParams;
use App\Models\Clusters;
use App\Models\Emotions;
use App\Models\Operations;
use Illuminate\Http\Request;

class OperationsController extends Controller
{
    public function index() 
    {
        $data = Operations::get();

        return view('configOperations')->with('data', $data);
    }

    public function saveOperations(Request $request)
    {
        try {
            $data = $request->all();

            foreach ($data as $name => $operation) {
                $operationRecord = Operations::where('nombre', $name)->first();
                if ($operationRecord) {
                    $operationRecord->operacion = $operation['operationValue'];
                    $operationRecord->alto = $operation['altoValue'];
                    $operationRecord->bajo = $operation['bajoValue'];
                    $operationRecord->save();
                }
            }
            return response()->json([
                'status' => true,
                'msg' => 'Texto actualizado con éxito!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'Error al actualizar el texto: ' . $e->getMessage()
            ], 500);
        }
    }
}
