<?php
declare(strict_types=1);

namespace App\UI\REST\Core;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class JsonResponseFactory implements JsonResponseFactoryInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function create($data, int $status = 200): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($data, 'json', [
                'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
            ]),
            $status,
            [],
            true
        );
    }
}