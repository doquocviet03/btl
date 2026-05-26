<?php

namespace App\Mail;

use App\Models\LichHen;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class XacNhanLichHenMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public LichHen $lichHen)
    {
    }

    public function build()
    {
        return $this->subject('Xác nhận lịch hẹn cắt tóc')
            ->view('emails.xac_nhan_lich_hen');
    }
}