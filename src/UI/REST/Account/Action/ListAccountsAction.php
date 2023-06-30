<?php
declare(strict_types=1);

namespace App\UI\REST\Account\Action;

use App\Message\Account\Application\Query\ListAccountsQuery;
use App\UI\REST\Core\JsonResponseFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListAccountsAction
{
    private ListAccountsQuery $listAccountsQuery;

    private JsonResponseFactoryInterface $jsonResponseFactory;

    public function __construct(
        ListAccountsQuery            $listAccountsQuery,
        JsonResponseFactoryInterface $jsonResponseFactory
    )
    {
        $this->listAccountsQuery = $listAccountsQuery;
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    /**
     * @Route("/accounts", methods={"GET"}, name="account_list")
     */
    public function list(): Response
    {
        $accounts = $this->listAccountsQuery->listAccounts();

        return $this->jsonResponseFactory->create($accounts);
    }
}