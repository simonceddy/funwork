<?php
namespace Eddy\Framework\Http\Messages;

use RingCentral\Psr7\Response as Psr7Response;

final class JsonResponse extends Psr7Response
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
