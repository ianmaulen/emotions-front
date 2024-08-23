<?php

namespace App\Http\Controllers;

use App\Models\clustersTexts;
use Illuminate\Http\Request;

class OutputsController extends Controller
{
    /**
     * Funcion que inicializa la vista
     */
    public function index() 
    {
        $data = [];
        $params = clustersTexts::where('status', 1)->get();
        /* ORDER DATA WITH CLUSTER INDEX AND LEVEL */
        foreach($params as $value) {
            $data[$value->cluster_name][$value->level][] = ['id' => $value->id, 'text' => $value->text];
        }

        return view('configOutputs')->with('data', $data);
    }

    /**
     * Función que guarda un nuevo text
     */
    public function saveOutput(Request $request) 
    {
        $data = $request->all();
        $config = clustersTexts::find($data['id']);
        
        if ($config) {
            $config->text = $data['text'];            
            $config->save();
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'No se encontró el texto para actualizar.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'msg' => 'Texto actualizado con éxito!',
            'newText' => $data['text']
        ], 200);
    }

    /**
     * Nuevo output si se desea añadir
     */
    public function newOutput(Request $request) 
    {
        $data = $request->all();
        $newOutput = clustersTexts::create([
            'cluster_name' => $data['cluster'],
            'level' => $data['level'],
            'text' => $data['text'],
        ]);

        if ($newOutput) {
            return response()->json([
                'status' => true,
                'msg' => 'Nuevo output agregado con éxito!',
                'newOutput' => $newOutput
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Error al agregar el nuevo output.',
            ], 500);
        }
    }

    public function deleteOutput(Request $request)
    {
        $data = $request->all();
        $config = clustersTexts::find($data['id']);
        if ($config) {
            $config->status = 0;            
            $config->save();
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'No se encontró el texto a eliminar.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'msg' => 'Texto eliminado con éxito.',
            'id' => $data['id']
        ], 200);
    }
}
