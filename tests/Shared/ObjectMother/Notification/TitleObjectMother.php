<?php
declare(strict_types=1);

namespace App\Tests\Shared\ObjectMother\Notification;

use App\Notification\Notification\Domain\Model\Title;

class TitleObjectMother
{
    public static function validTitle(): Title
    {
        return Title::create('testtest');
    }
}