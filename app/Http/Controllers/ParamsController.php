<?php

namespace App\Http\Controllers;

use App\Models\clustersParams;
use App\Models\Clusters;
use App\Models\Emotions;
use Illuminate\Http\Request;

class ParamsController extends Controller
{
    public function index() 
    {
        $data = [];
        $params = clustersParams::join('clusters', 'clusters.id', '=', 'cluster')
            ->join('emotions', 'emotions.id', '=', 'emotion')
            ->get();
        /* ORDER DATA WITH EMOTION AND CLUSTER INDEX */
        foreach($params as $value) {
            $data[$value['emotion_name']][$value['cluster_name']]['limit'] = intval($value->limit);
            $data[$value['emotion_name']][$value['cluster_name']]['peaks'] = intval($value->peaks);
        }

        return view('configParams')->with('data', $data);
    }

    public function saveParams(Request $request) 
    {
        $data = $request->all();
        // TODO: Update BD with $data values (to remember: json_decode)
        foreach ($data as $key => $value) {
            $param = json_decode($value);
            $emotion = Emotions::where('emotion_name', $param->emotion)->first();
            $cluster = Clusters::where('cluster_name', $param->cluster)->first();
            $config = clustersParams::where('emotion', $emotion['id'])
                ->where('cluster', $cluster['id'])
                ->first();
            if ($config) {
                $config->limit = $param->limit;
                $config->peaks = $param->peaks;
                $config->save();
            }
        }
        return response()->json([
            'status' => true,
            'msg' => 'Parámetros actualizados con éxito!'
        ], 200);
    }
}
