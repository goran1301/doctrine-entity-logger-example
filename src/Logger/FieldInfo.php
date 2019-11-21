<?php


namespace App\Logger;

/**
 * Class FieldInfo
 * @package App\Logger
 */
class FieldInfo
{

    /**
     * @var object
     */
    private $annotation;

    /**
     * @var \DateTime|string|int|float|null
     */
    private $value;

    /**
     * @var bool
     */
    private $isPrimary;

    /**
     * FieldInfo constructor.
     * @param $annotation
     * @param $value
     * @param bool $isPrimary
     */
    public function __construct($annotation, $value, bool $isPrimary)
    {
        $this->annotation = $annotation;
        $this->value = $value;
        $this->isPrimary = $isPrimary;
    }

    /**
     * @return \DateTime|float|int|string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return object
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * @return bool
     */
    public function isPrimary(): bool
    {
        return $this->isPrimary;
    }

}