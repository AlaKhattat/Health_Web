<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 26/02/2018
 * Time: 12:29
 */

namespace HealthAdvisorBundle\Entity;



use JMS\Payment\CoreBundle\Plugin\AbstractPlugin;

class PaypalPlugin extends AbstractPlugin
{
    public function processes($name)
    {
        return 'paypal' === $name;
    }
}