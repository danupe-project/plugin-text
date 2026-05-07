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

    public function getAllText(): array
    {
        $texts = danupe()
            ->plugin('database', 'database')
            ->table('texts')
            ->all(['`key`', 'text']);

        $data = [];
        foreach ($texts as $key => $value) {
            $data[danupe()->data()->get($value, 'key')] = danupe()->data()->get($value, 'text');
        }

        return $data;
    }

    public function getByLanguageAsArray(string $language = ""): array
    {
        $texts = danupe()
            ->plugin('database', 'database')
            ->table('texts')
            ->where([
                'language',
                '=',
                $language
            ])->all(['`key`', 'text']);

        $data = [];
        foreach ($texts as $key => $value) {
            $data[danupe()->data()->get($value, 'key')] = danupe()->data()->get($value, 'text');
        }

        return $data;
    }
}
