<?php

namespace Erp\Bundle\SettingBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Erp\Bundle\CoreBundle\Controller\ErpContextTrait;
use Psr\Http\Message\ServerRequestInterface;
use Erp\Bundle\CoreBundle\Controller\ErpApiQuery;
use Erp\Bundle\SettingBundle\Entity\Setting;

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
     * {@inheritDoc}
     */
    protected function reduceListData($data)
    {
        /**
         * @var Setting $setting
         */
        foreach ($data as $setting) {
            $setting->setValue(null);
        }

        return $data;
    }

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
        return $this->getQuery($code, $request, [
            'get' => function ($code, $queryParams, &$context) {
                return $this->domainQuery->findOneByCode($code);
            },
        ]);
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

        $context = $this->extendListContext($context);

        $context['actions'] = $this->prepareActions($context['actions'], $data);
        $context['data'] = $this->reduceListData($data);

        return $context;
    }

    protected function listQuery(ServerRequestInterface $request, $callbacks)
    {
        foreach ($callbacks as $grantText => $callback) {
            $grants = preg_split('/\s+/', $grantText);
            if (!$this->grant($grants, [])) continue;

            $queryParams = $request->getQueryParams();
            $items = [];
            $context = [];

            $items = $callback($queryParams, $context);

            return $this->view($this->listResponse($items, $context), 200);
        }

        throw new AccessDeniedException("List is not allowed.");
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
        return $this->listQuery($request, [
            'list' => function ($queryParams, &$context) {
                if (!empty($queryParams)) {
                    return $this->domainQuery->search($queryParams, $context);
                } else {
                    return $this->domainQuery->findAll();
                }
            },
        ]);
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

    protected function getQuery($code, ServerRequestInterface $request, $callbacks)
    {
        foreach ($callbacks as $grantText => $callback) {
            $grants = preg_split('/\s+/', $grantText);
            if (!$this->grant($grants, [])) continue;

            $queryParams = $request->getQueryParams();
            $item = null;
            $context = [];

            $item = $callback($code, $queryParams, $context);

            if (!$this->grant($grants, [$item])) continue;

            return $this->view($this->getResponse($item, $context), 200);
        }

        throw new AccessDeniedException("Get is not allowed.");
    }
}
