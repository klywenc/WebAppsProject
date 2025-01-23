<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccessibilityController extends Controller
{
    public function toggleFontSize(Request $request)
    {
        $fontSize = $request->session()->get('font_size', 'normal');
        $newSize = $fontSize === 'normal' ? 'large' : 'normal';
        $request->session()->put('font_size', $newSize);
        return response()->json(['success' => true, 'size' => $newSize]);
    }

    public function toggleContrast(Request $request)
    {
        $contrast = $request->session()->get('high_contrast', false);
        $request->session()->put('high_contrast', !$contrast);
        return response()->json(['success' => true, 'contrast' => !$contrast]);
    }
}