<?php

namespace Erp\Bundle\SettingBundle\Entity;

use Erp\Bundle\CoreBundle\Entity\StatusPresentable;

/**
 * Setting Entity
 */
class Setting implements StatusPresentable
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $priority;

    /**
     * @var array
     */
    protected $value;

    /**
     * ConstructorTest
     */
    public function __construct()
    {
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return static
     */
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set priority
     *
     * @param int $priority
     *
     * @return static
     */
    public function setPriority(int $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set value
     *
     * @param array $value
     *
     * @return static
     */
    public function setValue(?array $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return array
     */
    public function getValue()
    {
        return $this->value;
    }

    public function updatable()
    {
        // TODO: must checks ative but allows save when change active value
        return true;
    }

    public function deletable()
    {
        return true;
    }
}
