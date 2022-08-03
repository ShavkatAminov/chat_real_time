<?php

namespace App\Tests\Entity\Basic;

use App\Entity\Basic\BasicEntity;
use PHPUnit\Framework\TestCase;

class BasicEntityTest extends TestCase
{
    public function testUpdatedTimestamps() {
        $basic = new BasicEntity();
        $basic->updatedTimestamps();
        $this->assertEquals($basic->getCreatedAt(), time());
        $this->assertEquals($basic->getUpdatedAt(), time());
    }
}
