<?php

namespace App\Helpers;

use GuzzleHttp\Exception\RequestException;
use JsonException;
use Swoole\Http\Status;
use Throwable;

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

    /**
     * @param string $data
     * @return bool
     */
    public static function jsonValidator(string $data): bool
    {
        if (!empty($data)) {
            @json_decode($data);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }


    /**
     * @param string $json
     * @return array
     * @throws JsonException
     */
    public static function jsonDecodeUTF8(string $json, $prettyPrint = true): array
    {
        return (array)json_decode(
            $json,
            true,
            512,
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES |
            JSON_THROW_ON_ERROR |
            ($prettyPrint ? JSON_PRETTY_PRINT : 0)
        );
    }

    /**
     * @param mixed $value
     * @return string
     * @throws JsonException
     */
    public static function jsonEncodeUTF8($value, $prettyPrint = true): string
    {
        return (string)json_encode(
            $value,
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES |
            JSON_THROW_ON_ERROR |
            ($prettyPrint ? JSON_PRETTY_PRINT : 0)
        );
    }

    /**
     * @param Throwable $e
     * @return array
     * @throws JsonException
     */
    public static function getError(Throwable $e): array
    {
        if ($e instanceof RequestException) {
            $msg = (!is_null($e->getResponse()) and $e->getResponse()->getBody()->getSize() > 0) ?
                stripslashes($e->getResponse()->getBody()->__toString()) :
                $e->getMessage();

            $msg = self::jsonValidator($msg) ? self::jsonDecodeUTF8($msg) : $msg;
        } else {
            $msg = $e->getMessage();
        }
        return [
            'File'    => $e->getFile(),
            'Line'    => $e->getLine(),
            'Message' => $msg,
            'Code'    => $e->getCode(),
        ];
    }
}