<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Response as IlluminateResponse;

class ApiController extends Controller
{

    /**
     * @param $products
     *
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondsWithPagination(Paginator $products, $data): \Illuminate\Http\JsonResponse
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count'  => $products->total(),
                'total_pages'  => ceil($products->total() / $products->perPage()),
                'current_page' => $products->currentPage(),
                'limit'        => $products->perPage(),
            ],
        ]);
        return $this->respond($data);
    }

    const HTTP_NOT_FOUND = 404;

    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     *
     * @return \App\Http\Controllers\ApiController
     */
    public function setStatusCode($statusCode): \App\Http\Controllers\ApiController
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }
    /**
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not found')
    {
        return $this->setStatusCode(self::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($message = 'Successfully created')
    {
        return $this->setStatusCode(201)->respondWithError($message);
    }

    /**
     * @param       $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }
}
