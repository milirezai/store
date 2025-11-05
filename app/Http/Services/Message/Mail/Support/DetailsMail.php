<?php
namespace App\Http\Services\Message\Mail\Support;

interface DetailsMail
{
    public function to($to);
    public function from($address, $name);
    public function subject($subject);
    public function text($text);

}
