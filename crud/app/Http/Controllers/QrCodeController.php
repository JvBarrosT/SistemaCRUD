<?php

namespace App\Http\Controllers;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QRMarkupSVG;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function gerar(Request $request)
    {
        $url = $request->query('url', url('/'));

        $options = new QROptions([
            'outputInterface' => QRMarkupSVG::class, // formato SVG (v6)
            'outputBase64'    => false,               // retorna SVG bruto, não base64
            'svgAddXmlHeader' => false,               // sem cabeçalho XML
            'scale'           => 5,                   // tamanho
        ]);

        $svg = (new QRCode($options))->render($url);

        return response($svg, 200, ['Content-Type' => 'image/svg+xml']);
    }
}