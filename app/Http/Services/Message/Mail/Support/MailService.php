<?php
namespace App\Http\Services\Message\Mail\Support;

use Illuminate\Support\Facades\Mail as LaravelMail;
use App\Http\Services\Message\Contract\ContractToSendMessage;

class MailService implements DetailsMail,ContractToSendMessage
{
    protected $to;
    protected $from = [
        ['address' => null, 'name' => null,]
    ];
    protected $subject;
    protected $text;
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    public function from($address,$name)
    {
        $this->from = [
            [
                'address' => $address,
                'name' => $name,
            ]
        ];
        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function text($text)
    {
        $this->text = $text;
        return $this;
    }

    public function fire():bool
    {
        LaravelMail::to($this->to)->send(new MailViewProvider($this->text,$this->subject,$this->from));
        return true;
    }
}
