<?php


namespace App\Logger;


use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class CreateEventProcession
 * @package App\Logger
 */
class CreateEventProcession extends EntityLogEventProcession
{

    public const EVENT = 'create';

    /**
     * @return string
     */
    public function getClassAnnotationInstance(): string
    {
        return LoggingClass::class;
    }

    /**
     * @return string
     */
    public function getPropertyAnnotationInstance(): string
    {
        return LoggingField::class;
    }

    /**
     * @param ClassInfo $classInfo
     * @param LifecycleEventArgs $args
     * @return bool
     */
    protected function needToLog(ClassInfo $classInfo, LifecycleEventArgs $args): bool
    {
        /** @var LoggingClass $annotation */
        $annotation = $classInfo->getAnnotation();
        if ($annotation === null) {
            return false;
        }

        if (!in_array(self::EVENT, $annotation->events)) {
            return false;
        }

        return true;
    }

    /**
     * @param ClassInfo $classInfo
     * @param LifecycleEventArgs $args
     * @return string
     */
    protected function doCompose(ClassInfo $classInfo, LifecycleEventArgs $args): string
    {
        /** @var LoggingClass $annotation */
        $annotation = $classInfo->getAnnotation();
        $className = $annotation->name === null ? get_class($classInfo->getEntityObject()) : $annotation->name;

        $primaryKeyItems = [];
        foreach ($classInfo->getPrimaryKeys() as $keyName => $keyValue) {
            $primaryKeyItems[] = $keyName.' = '.$keyValue;
        }

        $fields = [];
        /** @var FieldInfo $fieldInfo */
        foreach ($classInfo->getFieldsInfo() as $fieldName => $fieldInfo) {
            $fields[] = $fieldName.': '.$fieldInfo->getValue();
        }

        return str_replace(
        ['{{entityName}}', '{{pk}}', '{{fields}}'],
        [$className, implode(', ', $primaryKeyItems), implode(', ', $fields)],
        $annotation->messageCreate
    );
    }
}