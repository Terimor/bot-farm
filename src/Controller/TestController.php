<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    #[Route('/test', methods: ['GET'])]
    public function test(): JsonResponse
    {
        return new JsonResponse(['result' => 1, 'message' => 'ok']);
    }
}