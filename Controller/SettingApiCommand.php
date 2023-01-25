<?php

namespace Erp\Bundle\SettingBundle\Controller;

use Erp\Bundle\CoreBundle\Controller\ErpApiCommand;
use FOS\RestBundle\Controller\Annotations as Rest;

use Symfony\Component\HttpFoundation\Request;

/**
 * Setting Api Command
 */
class SettingApiCommand extends ErpApiCommand
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
     * create action
     *
     * @Rest\Put("")
     *
     * @param Request $request
     */
    public function createAction(Request $request)
    {
        throw new \Exception("Not allowed");
    }

    /**
     * update action
     *
     * @Rest\Put("/{code}")
     *
     * @param string $code
     * @param Request $request
     */
    public function updateByCodeAction($code, Request $request)
    {
        return $this->updateCommand($code, $request, [
            'edit' => function ($code, &$data) {
                $data = [
                    'dtype' => $data['dtype'],
                    'value' => $data['value'],
                ];
                return $this->domainQuery->findOneByCode($code);
            },
        ]);
    }

    /**
     * delete action
     *
     * @Rest\Delete("/{code}")
     *
     * @param string $code
     * @param Request $request
     */
    public function deleteByCodeAction($code, Request $request)
    {
        throw new \Exception("Not allowed");
        // return $this->deleteCommand($code, $request, [
        //     'delete' => function ($code) {
        //         return $this->domainQuery->findOneBy($code);
        //     },
        // ]);
    }
}
