<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('telescope:prune --hours=24')->daily();
