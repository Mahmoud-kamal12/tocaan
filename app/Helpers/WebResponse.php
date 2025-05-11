<?php

namespace App\Helpers;
use Illuminate\Http\Response;

class WebResponse
{
    public static function renderMessage(string $title, string $message, int $status = 200): Response
    {
        return response()->view('layouts.message', [
            'title'   => $title,
            'message' => $message,
        ], $status);
    }
}
