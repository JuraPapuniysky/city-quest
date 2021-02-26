<?php

declare(strict_types=1);

namespace Quest\Factories\Entity\Request;

use App\Entities\Request\QuestQuestionRequestEntity;
use App\Entities\Request\RequestEntityInterface;
use App\Factories\Entity\Request\RequestEntityFactoryInterface;
use Karriere\JsonDecoder\Bindings\ArrayBinding;
use Karriere\JsonDecoder\JsonDecoder;
use Psr\Http\Message\ServerRequestInterface;

class QuestRequestEntityFactory implements RequestEntityFactoryInterface
{
    public function create(ServerRequestInterface $request, string $className): RequestEntityInterface
    {
        $jsonDecoder = new JsonDecoder();
        $jsonDecoder->register(new QuestRequestEntityTransformer());

        return $jsonDecoder->decode($request->getBody()->getContents(), $className);
    }
}
