<?php

use App\Exceptions\Handler;

function reportException($e)
{
    if (app()->environment('local')) {
        throw $e;
    }

    app(Handler::class)->report($e);
}

function messageException($e,$message){
    reportException($e);

    return response()->error($message);
}
