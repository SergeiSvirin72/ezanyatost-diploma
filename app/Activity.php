<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Activity extends Pivot
{
    protected $table = 'activities';
}
