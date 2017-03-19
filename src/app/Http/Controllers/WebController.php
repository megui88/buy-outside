<?php

namespace App\Http\Controllers;

use App\Services\Finance;
use Illuminate\Http\Request;

class WebController extends Controller
{

    /**
     * WebController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function homeAction(Request $request)
    {
        $finance = new Finance();
        $from = $request->get('from', 'ARG');
        $to = $request->get('to', 'CHI');
        return view('home',[
            'dollar' => Finance::DOLLAR_CURRENCY,
            'from' => [
                'code' => $from,
                'country' => $finance->getCountry($from),
                'currency' => $finance->getCurrency($from),
                'value' => $finance->getConverter($from)
                ],
            'to' => [
                'code' => $to,
                'country' => $finance->getCountry($to),
                'currency' => $finance->getCurrency($to),
                'value' => $finance->getConverter($to),
                ],
            'selectFrom' => $finance->renderSelect('from', $from),
            'selectTo' => $finance->renderSelect('to', $to),
        ]);
    }
}
