<?php

namespace Erp\Bundle\SettingBundle\Authorization;

use Erp\Bundle\CoreBundle\Authorization\AbstractErpAuthorization as Authorization;

class SettingAuthorization extends Authorization
{
    use \Erp\Bundle\CoreBundle\Authorization\ErpUncreatableAuthorizationTrait;
    use \Erp\Bundle\CoreBundle\Authorization\ErpUndeletableAuthorizationTrait;

    public function list(...$args)
    {
        return parent::list(...$args) && $this->grantByCode('ROLE_SETTING_%CODE%_LIST', ...$args);
    }

    public function get(...$args)
    {
        return parent::get(...$args) && $this->grantByCode('ROLE_SETTING_%CODE%_VIEW', ...$args);
    }

    public function edit(...$args)
    {
        return parent::edit(...$args) && $this->grantByCode('ROLE_SETTING_%CODE%_EDIT', ...$args);
    }

    protected function grantByCode($pattern, $item = null)
    {
        if (empty($item)) {
            return true;
        }

        $code = strtoupper($item->getCode());
        $role = str_replace('%CODE%', $code, $pattern);
        return $this->authorizationChecker->isGranted($role);
    }
}
