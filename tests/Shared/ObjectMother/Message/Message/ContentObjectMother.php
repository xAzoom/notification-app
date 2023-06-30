<?php
declare(strict_types=1);

namespace App\Tests\Shared\ObjectMother\Message\Message;

use App\Message\Message\Domain\Model\Content;

class ContentObjectMother
{
    public static function validContent(): Content
    {
        return Content::create('testtest');
    }
}