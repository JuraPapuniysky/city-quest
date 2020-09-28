<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\QuestService;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class QuestController
{
    private QuestService $questService;

    public function __construct(QuestService $questService)
    {
        $this->questService = $questService;
    }

    public function index(RequestInterface $request): ResponseInterface
    {

    }

    public function create(RequestInterface $request): ResponseInterface
    {

    }
}