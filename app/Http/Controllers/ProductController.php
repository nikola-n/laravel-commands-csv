<?php

namespace App\Http\Controllers;

use App\Acme\Transformers\ProductTransformer;
use App\Product;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class ProductController extends ApiController
{
    /**
     * @var \App\Acme\Transformers\ProductTransformer
     */
    protected $productTransformer;

    public function __construct(ProductTransformer $productTransformer)
    {
        $this->productTransformer = $productTransformer;
        $this->middleware('auth.basic',['only' => 'post']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::all();

        return $this->respond([
            'data' => $this->productTransformer->transformCollection($products->all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
