<?php
declare(strict_types=1);

namespace App\UI\REST\Core;

use Symfony\Component\HttpFoundation\JsonResponse;

interface JsonResponseFactoryInterface
{
    public function create($data, int $status = 200): JsonResponse;
}