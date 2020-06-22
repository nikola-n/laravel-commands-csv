<?php

namespace App\Http\Controllers;

use App\Acme\Transformers\ProductTransformer;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ProductController extends ApiController
{
    /**
     * @var \App\Acme\Transformers\ProductTransformer
     */
    protected $productTransformer;

    public function __construct(ProductTransformer $productTransformer)
    {
        $this->productTransformer = $productTransformer;
        $this->middleware('auth.basic', ['only' => 'post']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $limit    = request()->get('limit') ?: 3;
        $products = Product::paginate($limit);
        //dd(get_class_methods($products));
        return $this->respondsWithPagination($products, [
            'data' => $this->productTransformer->transformCollection($products->all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ( ! $request->get('title') || $request->get('body')) {
            return $this->setStatusCode(422)
                ->respondWithError('Parameters failed validation for product');
        }
        Product::create($request->all());
        return $this->respondCreated('Product successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ( ! $product) {
            return $this->respondNotFound('Product does not exists.');
        }

        return $this->respond(['data' => $this->productTransformer->transform($product)]);
    }
}
