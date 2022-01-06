<?php

namespace App\Exceptions;

use Sentry\Event;

class Sentry
{
    public static function beforeSend(Event $event): Event
    {
        $event->setRequest([
            'url' => 'http://network.manager'.request()->getRequestUri(),
            'method' => request()->method(),
            'headers' => collect(request()->headers)->only([
                'connection',
                'cache-control',
                'user-agent',
                'accept',
                'accept-encoding',
                'accept-language',
            ])->toArray(),
        ]);

        return $event;
    }
}
