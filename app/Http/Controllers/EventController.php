<?php

namespace App\Http\Controllers;

class EventController extends ProgramController
{
    protected function collection(): string
    {
        return 'events';
    }
}
