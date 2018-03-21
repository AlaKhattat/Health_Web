<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity
 */
class Admin
{
    /**
     * @var string
     *
     * @ORM\Column(name="LOGIN_ADMIN", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $loginAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="PASSWORD_ADMIN", type="string", length=255, nullable=false)
     */
    private $passwordAdmin;


}

