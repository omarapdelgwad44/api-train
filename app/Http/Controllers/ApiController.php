<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function include(string $relationship): bool
    {
        $params = request()->get('include');

        if (empty($params)) {
            return false;
        }

        return in_array($relationship, explode(',', strtolower($params)));
    }
}
