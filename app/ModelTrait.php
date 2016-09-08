<?php

namespace App;

use Jedrzej\Pimpable\PimpableTrait;

trait ModelTrait
{
    use PimpableTrait;

    public $notSearchable = ['recommended', 'popular', 'sort', 'authorization'];
}
