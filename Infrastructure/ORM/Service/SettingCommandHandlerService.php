<?php

namespace Erp\Bundle\SettingBundle\Infrastructure\ORM\Service;

use Erp\Bundle\SettingBundle\Domain\CQRS\SettingCommandHandler as CommandHandlerInterface;
use Erp\Bundle\CoreBundle\Infrastructure\ORM\Service\SimpleCommandHandler as ParentCommandHandler;

class SettingCommandHandlerService extends ParentCommandHandler implements CommandHandlerInterface
{
}
