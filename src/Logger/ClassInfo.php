<?php


namespace App\Logger;


/**
 * Class ClassInfo
 * @package App\Logger
 */
class ClassInfo
{
    /**
     * @var object
     */
    private $annotation;

    /**
     * @var array
     */
    private $primaryKeys = [];

    /**
     * @var FieldInfo[]
     */
    private $fieldsInfo;

    /**
     * @var object
     */
    private $entityObject;

    /**
     * ClassInfo constructor.
     * @param object $entityObject
     * @param object $annotation
     * @param $primaryKeys
     * @param FieldInfo[] $fieldsInfo
     */
    public function __construct($entityObject, $annotation, $primaryKeys, array $fieldsInfo)
    {
        $this->entityObject = $entityObject;
        $this->annotation = $annotation;
        $this->primaryKeys = $primaryKeys;
        $this->fieldsInfo = $fieldsInfo;
    }

    /**
     * @return object
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * @return array
     */
    public function getPrimaryKeys(): array
    {
        return $this->primaryKeys;
    }

    /**
     * @return FieldInfo[]
     */
    public function getFieldsInfo(): array
    {
        return $this->fieldsInfo;
    }

    /**
     * @return object
     */
    public function getEntityObject()
    {
        return $this->entityObject;
    }
}