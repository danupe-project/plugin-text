<?php

namespace Danupe\Plugin\Text\Models;

use Danupe\Plugin\Database\Classes\Model;

class Text extends Model
{
    protected $table = 'texts';

    protected $attributes = [
        'id' => null,
        'key' => null,
        'text' => null,
        'language' => null,
    ];

}