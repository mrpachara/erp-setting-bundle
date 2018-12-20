<?php

namespace Erp\Bundle\SettingBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Erp\Bundle\CoreBundle\Controller\ErpContextTrait;
use Psr\Http\Message\ServerRequestInterface;
use Erp\Bundle\CoreBundle\Controller\ErpApiQuery;

/**
 * Setting Api Query
 */
abstract class SettingApiQuery extends ErpApiQuery
{
    use ErpContextTrait;
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

    protected function listResponse($data, $context)
    {
        $context = $this->prepareContext($context);

        if (!isset($context['searchable'])) {
            $context['searchable'] = true;
        }

        foreach (['add'] as $action) {
            if (!in_array($action, $context['actions'])) {
                $context['actions'][] = $action;
            }
        }

        $context['actions'] = $this->prepareActions($context['actions'], $data);
        $context['data'] = $data;

        return $context;
    }

    protected function listQuery($grant, ServerRequestInterface $request, $callback)
    {
        if (!$this->grant($grant, [])) {
            throw new UnprocessableEntityHttpException("List is not allowed.");
        }

        $queryParams = $request->getQueryParams();
        $items = [];
        $context = [];

        $items = $callback($queryParams, $context);

        return $this->view($this->listResponse($items, $context), 200);
    }

    /**
     * list action
     *
     * @Rest\Get("")
     *
     * @param ServerRequestInterface $request
     */
    public function listAction(ServerRequestInterface $request)
    {
        return $this->listQuery('list', $request, function($queryParams, &$context) {
            if (!empty($queryParams)) {
                return $this->domainQuery->search($queryParams, $context);
            } else {
                return $this->domainQuery->findAll();
            }
        });
    }

    protected function getResponse($data, $context)
    {
        $context = $this->prepareContext($context);

        $context['actions'][] = 'edit';
        $context['actions'][] = 'delete';

        $context['actions'] = $this->prepareActions($context['actions'], $data);
        $context['data'] = $data;

        return $context;
    }

    protected function getQuery($grant, $code, ServerRequestInterface $request, $callback)
    {
        if (!$this->grant($grant, [])) {
            throw new UnprocessableEntityHttpException("Get is not allowed.");
        }

        $queryParams = $request->getQueryParams();
        $item = null;
        $context = [];

        $item = $callback($code, $queryParams, $context);

        if (!$this->grant($grant, [$item])) {
            throw new UnprocessableEntityHttpException("Get is not allowed.");
        }

        return $this->view($this->getResponse($item, $context), 200);
    }
}
