<?php

namespace App\Http\Controllers;

use App\Acme\Transformers\TagTransformer;
use App\Product;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends ApiController
{
    protected $tagTransformer;

    /**
     * @param \App\Acme\Transformers\TagTransformer $tagTransformer
     */
    public function __construct(TagTransformer $tagTransformer)
    {
        $this->tagTransformer = $tagTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $productId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($productId = null)
    {
        $tags = $this->getTags($productId);
        return $this->respond([
            'data' => $this->tagTransformer->transformCollection($tags->all()),
        ]);
    }

    public function show($id)
    {
        //
    }

    /**
     * @param $productId
     *
     * @return \App\Tag[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function getTags($productId)
    {
        return $productId ? Product::findOrFail($productId)->tags : Tag::all();
    }

}
