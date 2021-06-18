<?php
namespace Eddy\Framework\Http\Response;

use React\Http\Message\Response;

final class JsonResponse extends Response
{
    public function __construct(int $statusCode, $data = null)
    {
        $data = $data === null ? null : json_encode($data); parent::__construct(
            $statusCode,
            ['Content-type' => 'application/json'],
            $data
        );
    }

    public static function ok($data): self
    {
        return new self(200, $data);
    }

    public static function internalServerError(string $reason): self
    {
        return new self(500, ['message' => $reason]);
    }
}
