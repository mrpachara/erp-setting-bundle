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

    // /**
    //  * @var \Erp\Bundle\SettingBundle\Domain\CQRS\SettingCommandHandler
    //  */
    // protected $commandHandler;
    //
    // /** @required */
    // public function setCommandHandler(\Erp\Bundle\SettingBundle\Domain\CQRS\SettingCommandHandler $commandHandler)
    // {
    //     $this->commandHandler = $commandHandler;
    // }

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
        return $this->deleteCommand($code, $request, [
            'delete' => function ($code) {
                return $this->domainQuery->findOneBy($code);
            },
        ]);
    }
}
