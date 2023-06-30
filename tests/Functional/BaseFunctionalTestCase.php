<?php
declare(strict_types=1);

namespace App\Tests\Functional;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseFunctionalTestCase extends WebTestCase
{
    protected function getEntityManager(): EntityManagerInterface
    {
        return static::getContainer()->get(EntityManagerInterface::class);
    }
}