<?php
declare(strict_types=1);

namespace App\UI\REST\Core;

use App\UI\REST\Core\Exception\InvalidContentJsonObjectException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;

class RequestDTOArgumentResolver implements ArgumentValueResolverInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), RequestDTOInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ('json' !== $request->getContentType()) {
            throw new \InvalidArgumentException('Only request with content-type: application/json supported RequestDTO');
        }

        $payload = json_decode($request->getContent() ?? '', true) ?? [];
        try {
            $request = $this->serializer->denormalize($payload, $argument->getType(), null, [
//            AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true
            ]);
        } catch (\Throwable $e) {
            throw new InvalidContentJsonObjectException(sprintf('Json "%s" cannot be convert to RequestDTO', json_encode($payload)));
        }

        yield $request;
    }
}