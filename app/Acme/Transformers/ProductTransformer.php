<?php

namespace App\Acme\Transformers;

class ProductTransformer extends Transformer
{
    public function transform($product)
    {
        return [
            'title'  => $product['title'],
            'body'   => $product['body'],
            'active' => (bool)$product['some-boolean'],
        ];
    }
}
