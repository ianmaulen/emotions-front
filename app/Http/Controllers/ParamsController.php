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
        $params = clustersParams::join('clusters', 'clusters.id', '=', 'cluster_id')
            ->join('emotions', 'emotions.id', '=', 'emotion_id')
            ->get();
        /* ORDER DATA WITH EMOTION AND CLUSTER INDEX */
        foreach($params as $value) {
            $data[$value['cluster_name']][$value['level']][$value['emotion_name']]['value_limit'] = intval($value->value_limit);
            $data[$value['cluster_name']][$value['level']][$value['emotion_name']]['peak_limits'] = intval($value->peak_limits);
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
            $config = clustersParams::where('emotion_id', $emotion['id'])
                ->where('cluster_id', $cluster['id'])
                ->where('level', $param->level)
                ->first();
            if ($config) {
                $config->value_limit = $param->limit;
                $config->peak_limits = $param->peaks;
                $config->save();
            }
        }
        return response()->json([
            'status' => true,
            'msg' => 'Parámetros actualizados con éxito!'
        ], 200);
    }
}
