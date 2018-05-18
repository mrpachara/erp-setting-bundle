<?php

namespace Erp\Bundle\SettingBundle\Infrastructure\ORM\Service;

use Erp\Bundle\SettingBundle\Domain\CQRS\SettingQuery as QueryInterface;
use Erp\Bundle\CoreBundle\Infrastructure\ORM\Service\CoreAccountQuery as ParentQuery;

abstract class SettingQuery extends ParentQuery implements QueryInterface
{
}
