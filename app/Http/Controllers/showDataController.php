<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class showDataController extends Controller
{
    public function index() {

        /* $client = new \GuzzleHttp\Client();
        $request = $client->get('http://localhost:8100');
        $response = $request->getBody()->getContents();
        $data = json_decode($response, true); */

        return view('emotionsIndex')
            ->with('data', $data);
    }
}
