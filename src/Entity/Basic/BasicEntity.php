<?php

namespace App\Entity\Basic;

use Doctrine\ORM\Mapping as ORM;

class BasicEntity
{
    /**
     * @ORM\Column(type="integer")
     * @Orm\V
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     * @Orm\V
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     * @Orm\V
     */
}
