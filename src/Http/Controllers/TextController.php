<?php

namespace App\Http\Controllers;

class TextController
{
    public function resource()
    {
        echo json_encode(['text' => 'Usuário autenticado com previlegios de ver esse texto']);
    }
}