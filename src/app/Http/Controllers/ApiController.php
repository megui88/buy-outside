<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function financeAction(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);
    }
}
