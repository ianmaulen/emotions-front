<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class showDataController extends Controller
{
    public function analizarVideo(Request $request) {
        $video = $request->file('video');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://localhost:5000/procesar_video', [
            'multipart' => [
                [
                    'name'     => 'video',
                    'contents' => fopen($video->getPathname(), 'r'),
                ]
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        return response()->json($data);
    }
}
