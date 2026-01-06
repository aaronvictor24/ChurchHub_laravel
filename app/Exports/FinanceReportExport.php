<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FinanceReportExport implements FromView
{
    protected $tithes;
    protected $offerings;
    protected $from;
    protected $to;

    public function __construct($tithes, $offerings, $from, $to)
    {
        $this->tithes = $tithes;
        $this->offerings = $offerings;
        $this->from = $from;
        $this->to = $to;
    }

    public function view(): View
    {
        return view('secretary.reports.excel', [
            'tithes' => $this->tithes,
            'offerings' => $this->offerings,
            'from' => $this->from,
            'to' => $this->to,
        ]);
    }
}
