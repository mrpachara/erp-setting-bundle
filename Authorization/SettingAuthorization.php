<?php

namespace Erp\Bundle\SettingBundle\Authorization;

use Erp\Bundle\CoreBundle\Authorization\AbstractErpAuthorization as Authorization;

class SettingAuthorization extends Authorization
{
    use \Erp\Bundle\CoreBundle\Authorization\ErpUncreatableAuthorizationTrait;
    use \Erp\Bundle\CoreBundle\Authorization\ErpUndeletableAuthorizationTrait;

    const sensitiveSetting = ['bankaccount'];
    const rootSetting = ['allowedroles'];

    public function list(...$args)
    {
        return parent::list(...$args) && $this->grantByCode('ROLE_SETTING_%CODE%_LIST', ...$args);
    }

    public function get(...$args)
    {
        return parent::get(...$args) &&
            (
                (!$this->isSensitiveSetting(...$args)) ||
                $this->grantByCode('ROLE_SETTING_%CODE%_VIEW', ...$args)
            );
    }

    public function edit(...$args)
    {
        // NOTE: may be not required but for preventing to mistake setting.
        if ($this->isRootSetting(...$args)) {
            return parent::edit(...$args) && $this->authorizationChecker->isGranted('ROLE_ROOT');
        }

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

    protected function isSensitiveSetting($item = null): bool
    {
        if (empty($item)) {
            return false;
        }

        return \in_array($item->getCode(), self::sensitiveSetting);
    }

    protected function isRootSetting($item = null): bool
    {
        if (empty($item)) {
            return false;
        }

        return \in_array($item->getCode(), self::rootSetting);
    }
}
