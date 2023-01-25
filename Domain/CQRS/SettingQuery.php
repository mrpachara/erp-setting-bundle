<?php

namespace Erp\Bundle\SettingBundle\Domain\CQRS;

use Erp\Bundle\CoreBundle\Domain\CQRS\ErpQuery;
use Erp\Bundle\SettingBundle\Entity\Setting;

/**
 * Setting Query (CQRS)
 */
interface SettingQuery extends ErpQuery
{
    function findOneByCode(string $code): ?Setting;
}
