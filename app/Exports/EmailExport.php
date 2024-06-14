<?php

namespace App\Exports;

use App\Http\Resources\EmailExportResource;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Newsletter\Entities\Email;

class EmailExport implements FromCollection, WithHeadings
{
    protected $amount;

    protected $from;

    public function __construct($amount, $from)
    {
        $this->amount = $amount;
        $this->from = $from;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->from == 'latest') {

            $emails = Email::latest()->limit($this->amount)->get();

            return EmailExportResource::collection($emails);
        } else {

            $emails = Email::oldest()->limit($this->amount)->get();

            return EmailExportResource::collection($emails);
        }
    }

    public function headings(): array
    {
        return [
            'SL', 'Email',
        ];
    }
}
