<?php
declare(strict_types=1);

namespace App\UI\REST\Notification\Action;

use App\Notification\Notification\Application\Query\ListNotificationByAccountQuery;
use App\UI\REST\Core\JsonResponseFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class ListNotificationByAccount
{
    private ListNotificationByAccountQuery $listNotificationByAccountQuery;

    private JsonResponseFactoryInterface $jsonResponseFactory;

    public function __construct(
        ListNotificationByAccountQuery $listNotificationByAccountQuery,
        JsonResponseFactoryInterface $jsonResponseFactory
    ) {
        $this->listNotificationByAccountQuery = $listNotificationByAccountQuery;
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    /**
     * @Route("/notifications", methods={"GET"}, name="notification_list")
     */
    public function listNotificationByAccount(Request $request): Response
    {
        $accountId = $request->query->get('accountId');

        $models = $this->listNotificationByAccountQuery->listNotificationByAccount(Uuid::fromString($accountId));

        return $this->jsonResponseFactory->create($models);
    }
}