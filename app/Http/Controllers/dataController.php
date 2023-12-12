<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dataController extends Controller
{
    public function analizarVideo(Request $request) {
        $video = $request->file('video');
        $client = new \GuzzleHttp\Client();
        $endpointUrl = config('app.process_video_url');
        $response = $client->request('POST', $endpointUrl, [
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
