<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF; 

class dataController extends Controller
{
    public function analizarVideo(Request $request) {
        $video = $request->file('video');
        $instruction = $request->instruction;
        if (!$video || !$instruction) {
            return response()->json(['error' => 'Error, debe enviar todos los parámetros'], 403);
        }
        $client = new \GuzzleHttp\Client();
        $endpointUrl = config('app.process_video_url');
        try {
            $response = $client->request('POST', $endpointUrl, [
                'multipart' => [
                    [
                        'name'     => 'video',
                        'contents' => fopen($video->getPathname(), 'r'),
                    ],
                    [
                        'name'     => 'instruction',
                        'contents' => $instruction,
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar el video: "' . $e->getMessage() . '"'], 500);
        }

        $data = json_decode($response->getBody()->getContents(), true);
        return response()->json($data);
    }

    public function exportarPDF(Request $request) {
        $htmlContent = $request->input('text');

        // Generar el PDF a partir del contenido HTML
        $pdf = PDF::loadHTML($htmlContent);
        
        // Guardar el PDF en el servidor o devolverlo directamente
        return $pdf->download('documento.pdf'); // Cambia esto si deseas guardar en el servidor
    }
}
