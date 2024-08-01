<?php

namespace App\Traits;

use App\Enums\RequestError;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait HasApiResponse
{
    protected $response = [
        'success' => true,
        'data' => [],
    ];

    private function response(int $status = 200): JsonResponse
    {
        return response()->json($this->response, $status);
    }

    public function success($data = null, ?string $message = null, int $status = 200): JsonResponse
    {
        $this->setBasicResponse($data, $message);

        return $this->response($status);
    }

    public function error(int $status, $error)
    {
        $this->response['success'] = false;
        $this->response['errors'] = $error;

        return $this->response($status);
    }

    private function setBasicResponse($data, ?string $message = null)
    {
        $this->response['success'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = $message;
    }
}
