<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Employment extends Pivot
{
    protected $table = 'employments';
}
