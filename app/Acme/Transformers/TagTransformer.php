<?php

namespace App\Acme\Transformers;

class TagTransformer extends Transformer
{
    public function transform($tag)
    {
        return [
            'name' => $tag['name']
        ];
    }
}
