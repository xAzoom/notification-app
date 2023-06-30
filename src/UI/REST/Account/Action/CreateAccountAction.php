<?php
declare(strict_types=1);

namespace App\UI\REST\Account\Action;

use App\Message\Account\Application\Command\CreateAccount\CreateAccountCommand;
use App\Shared\Application\Bus\CommandBus\CommandBusInterface;
use App\UI\REST\Account\DTO\AccountDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class CreateAccountAction
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/accounts", methods={"POST"}, name="account_create")
     */
    public function __invoke(AccountDTO $accountDTO): Response
    {
        $id = Uuid::v4();
        $this->commandBus->handle(new CreateAccountCommand($id, $accountDTO->getName()));

        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }
}