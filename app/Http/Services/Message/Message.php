<?php
namespace App\Http\Services\Message;
use App\Http\Services\Message\Contract\Contract;
use Error;
class Message
{
    public function create($type)
    {
        $services = config('app.messagingـservices');
        foreach ($services as $serviceType => $service){
            if ($type === $serviceType){
                return new $service();
            }else{
                throw new Error('service not found');
            }
        }
    }
}
