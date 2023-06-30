<?php
declare(strict_types=1);

namespace App\UI\REST\Message\Action;

use App\Message\Message\Application\Query\ListDirectsMessagesQuery;
use App\UI\REST\Core\JsonResponseFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class ListDirectMessagesAction
{
    private ListDirectsMessagesQuery $listMessagesBySenderAndRecipientQuery;

    private JsonResponseFactoryInterface $jsonResponseFactory;

    public function __construct(
        ListDirectsMessagesQuery $listMessagesBySenderAndRecipientQuery,
        JsonResponseFactoryInterface $jsonResponseFactory
    )
    {
        $this->listMessagesBySenderAndRecipientQuery = $listMessagesBySenderAndRecipientQuery;
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    /**
     * @Route("/messages", methods={"GET"}, name="message_list")
     */
    public function listDirectMessages(Request $request): Response
    {
        $firstAccount = $request->query->get('firstAccount');
        $secondAccount = $request->query->get('secondAccount');

        $models = $this->listMessagesBySenderAndRecipientQuery
            ->listDirectMessages(Uuid::fromString($firstAccount), Uuid::fromString($secondAccount));

        return $this->jsonResponseFactory->create($models);
    }
}