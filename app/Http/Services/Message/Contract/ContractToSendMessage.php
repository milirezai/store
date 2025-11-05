<?php
namespace App\Http\Services\Message\Contract;

interface ContractToSendMessage
{
    public function fire():bool;
}
