<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class LanguageController extends Controller
{
    public function getLanguageFile($language, $filename)
    {
        $response[$filename] = [];
        $langPath = resource_path('lang');

        $filePath = $langPath . '/' . $language . '/' . $filename . '.php';

        if (File::exists($filePath)) {
            $response[$filename] = require $filePath;
            return response()->json($response);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}
