<?php

namespace App;

use Jedrzej\Pimpable\PimpableTrait;

trait ModelTrait
{
    use PimpableTrait;

    public $notSearchable = ['page', 'recommended', 'popular', 'sort', 'token'];
}
