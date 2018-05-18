<?php

namespace Erp\Bundle\SettingBundle\Authorization;

use Erp\Bundle\CoreBundle\Authorization\AbstractErpAuthorization as Authorization;

class SettingAuthorization extends Authorization
{
    use \Erp\Bundle\CoreBundle\Authorization\ErpUncreatableAuthorizationTrait;
    use \Erp\Bundle\CoreBundle\Authorization\ErpUndeletableAuthorizationTrait;

    public function list(...$args)
    {
        return parent::list(...$args) && $this->grantByCode('ROLE_LIST_SETTING', ...$args);
    }

    public function get(...$args)
    {
        return parent::get(...$args) && $this->grantByCode('ROLE_VIEW_SETTING', ...$args);
    }

    public function edit(...$args)
    {
        return parent::edit(...$args) && $this->grantByCode('ROLE_EDIT_SETTING', ...$args);
    }

    protected function grantByCode($prefix, $item = null)
    {
        if (empty($item)) {
            return true;
        }

        $code = strtoupper($item->getCode());
        return $this->authorizationChecker->isGranted("{$prefix}_{$code}");
    }
}
