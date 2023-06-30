<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Message\Account\Domain\Model\Account;
use App\Message\Account\Domain\Model\Name;
use App\Message\Account\Domain\Specification\CheckNameUniqueSpecificationInterface;
use App\Message\Message\Domain\Model\Content;
use App\Message\Message\Domain\Model\Message;
use App\Notification\Account\Domain\Model\Account as NotificationAccount;
use App\Notification\Notification\Domain\Model\Notification;
use App\Notification\Notification\Domain\Model\Title;
use App\Notification\Notification\Domain\Model\Type\MessageReceivedNotificationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Psr\Clock\ClockInterface;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    private CheckNameUniqueSpecificationInterface $checkNameUniqueSpecification;

    private ClockInterface $clock;

    public function __construct(
        CheckNameUniqueSpecificationInterface $checkNameUniqueSpecification,
        ClockInterface $clock
    )
    {
        $this->checkNameUniqueSpecification = $checkNameUniqueSpecification;
        $this->clock = $clock;
    }

    public function load(ObjectManager $manager): void
    {
        $firstAccount = new Account(Uuid::v4(), Name::create('TEST1'), $this->checkNameUniqueSpecification);
        $secondAccount = new Account(Uuid::v4(), Name::create('TEST2'), $this->checkNameUniqueSpecification);
        $firstMessage = new Message(Uuid::v4(), $firstAccount->getId(), [$secondAccount->getId()], Content::create('Cześć'), $this->clock);
        $secondMessage = new Message(Uuid::v4(), $secondAccount->getId(), [$firstAccount->getId()], Content::create('Witam'), $this->clock);
        $firstNotification = new Notification(Uuid::v4(), Title::create('Otrzymałeś wiadomość'), [$secondAccount->getId()], new MessageReceivedNotificationType(
            'Cześć',
            $firstMessage->getId(),
            $firstAccount->getId(),
            $firstAccount->getName()
        ), $this->clock);
        $secondNotification = new Notification(Uuid::v4(), Title::create('Otrzymałeś wiadomość'), [$firstAccount->getId()], new MessageReceivedNotificationType(
            'Witam',
            $secondMessage->getId(),
            $secondAccount->getId(),
            $secondAccount->getName()
        ), $this->clock);

        $manager->persist($firstAccount);
        $manager->persist($secondAccount);
        $manager->persist(new NotificationAccount($firstAccount->getId()));
        $manager->persist(new NotificationAccount($secondAccount->getId()));
        $manager->persist($firstMessage);
        $manager->persist($secondMessage);
        $manager->persist($firstNotification);
        $manager->persist($secondNotification);
        $manager->flush();
    }
}