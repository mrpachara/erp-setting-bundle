<?php

namespace Erp\Bundle\SettingBundle\Infrastructure\ORM\Service;

class SettingQueryService extends SettingQuery
{
    /** @required */
    public function setRepository(\Symfony\Bridge\Doctrine\RegistryInterface $doctrine)
    {
        $this->repository = $doctrine->getRepository('ErpSettingBundle:Setting');
    }
}
