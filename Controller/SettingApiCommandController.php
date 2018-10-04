<?php

namespace Erp\Bundle\SettingBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Setting Api Controller
 *
 * @Rest\Version("1.0")
 * @Rest\Route("/api/setting")
 */
class SettingApiCommandController extends SettingApiCommand
{
    /**
     * @var \Erp\Bundle\SettingBundle\Authorization\SettingAuthorization
     */
    protected $authorization;

    /** @required */
    public function setAuthorization(\Erp\Bundle\SettingBundle\Authorization\SettingAuthorization $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * @var \Erp\Bundle\SettingBundle\Domain\CQRS\SettingQuery
     */
    protected $domainQuery;

    /** @required */
    public function setDomainQuery(\Erp\Bundle\SettingBundle\Domain\CQRS\SettingQuery $domainQuery)
    {
        $this->domainQuery = $domainQuery;
    }
}
