<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    /** @return JsonResponse The JSON response indicating the result of the language file.*/
    public function getLanguageFile(string $language, string $filename): JsonResponse
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
