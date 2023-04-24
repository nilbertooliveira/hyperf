<?php

namespace App\Helpers;

use Swoole\Http\Status;

class Helper
{
    /**
     * @param bool $success
     * @param mixed|string $response
     * @return array
     */
    public static function getResponse(bool $success, mixed $response): array
    {
        return [
            'success'     => $success,
            'message'     => !$success ? $response : null,
            'data'        => $success ? $response : null,
            'status_code' => $success ? Status::OK : Status::UNPROCESSABLE_ENTITY
        ];
    }
}