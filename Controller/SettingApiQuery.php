<?php

namespace Erp\Bundle\SettingBundle\Controller;

use Erp\Bundle\CoreBundle\Controller\ErpApiQuery;
use FOS\RestBundle\Controller\Annotations as Rest;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Setting Api Query
 */
abstract class SettingApiQuery extends ErpApiQuery
{
    /**
     * @var \Erp\Bundle\SettingBundle\Authorization\SettingAuthorization
     */
    protected $authorization;

    /**
     * @var \Erp\Bundle\SettingBundle\Domain\CQRS\SettingQuery
     */
    protected $domainQuery;

    /**
     * get action
     *
     * @Rest\Get("/{code}")
     *
     * @param string $code
     * @param ServerRequestInterface $request
     */
    public function getAction($code, ServerRequestInterface $request)
    {
        return $this->getQuery('get', $code, $request, function($code, $queryParams, &$context) {
            return $this->domainQuery->findOneByCode($code);
        });
    }
}
