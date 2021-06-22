<?php
namespace Eddy\Framework\Http\Controllers;

use Eddy\Framework\Filesystem\Filesystem;
use Eddy\Framework\Http\Messages\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use React\Filesystem\Node\FileInterface;
use React\Filesystem\Stream\ReadableStream;
use React\Http\Message\Response;
use React\Promise\PromiseInterface;

class StaticFileController
{
    public function __construct(
        private Filesystem $fs,
        private string $path
    ) {
        if (!is_dir($path)) {
            throw new \Exception(
                'Could not locate ' . $path
            );
        }
    }

    private function responseWithFile(FileInterface $file): PromiseInterface
    {
        return $file->open('r')->then(
            fn(ReadableStream $stream) => new Response(
                200,
                ['Content-Type' => 'image/png'],
                $stream
            ),
            fn(\Exception $exception) => JsonResponse::internalServerError(
                $exception->getMessage()
            )
        );
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $filepath = $this->path . '/' . $request->getUri()->getPath();

        $file = $this->fs->file($filepath);

        $file->exists()->then(
            fn() => $this->responseWithFile($file),
            fn(\Throwable $e) => throw $e
        );
    }
}
