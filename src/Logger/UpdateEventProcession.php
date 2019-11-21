<?php


namespace App\Logger;


use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class UpdateEventProcession
 * @package App\Logger
 */
class UpdateEventProcession extends EntityLogEventProcession
{
    /**
     * Event name
     */
    public const EVENT = 'update';

    /**
     * @param ClassInfo $classInfo
     * @param LifecycleEventArgs $args
     * @return bool
     */
    protected function needToLog(ClassInfo $classInfo, LifecycleEventArgs $args): bool
    {
        if ($classInfo->getAnnotation() === null) {
            return false;
        }
        /** @var LoggingClass $classAnnotation */
        $classAnnotation = $classInfo->getAnnotation();

        if (!in_array(self::EVENT, $classAnnotation->events)) {
            return false;
        }

        $changes = $this->getFieldChanges($classInfo->getEntityObject(), $args);

        if (empty($changes)) {
            return false;
        }

        foreach ($classInfo->getFieldsInfo() as $fieldName => $fieldInfo) {
            if (isset($changes[$fieldName]) && count($changes[$fieldName]) === 2) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param object $entityObject
     * @param LifecycleEventArgs $args
     * @return array
     */
    private function getFieldChanges($entityObject, LifecycleEventArgs $args): array
    {
        return $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($entityObject);
    }

    /**
     * @param ClassInfo $classInfo
     * @param LifecycleEventArgs $args
     * @return string
     */
    protected function doCompose(ClassInfo $classInfo, LifecycleEventArgs $args): string
    {
        /** @var LoggingClass $classAnnotation */
        $classAnnotation = $classInfo->getAnnotation();
        $className = $classAnnotation->name !== null
            ? $classAnnotation->name
            : get_class($args->getEntity());

        $primaryKeyItems = [];
        foreach ($classInfo->getPrimaryKeys() as $keyName => $keyValue) {
            $primaryKeyItems[] = $keyName.' = '.$keyValue;
        }

        $changesItems = $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($classInfo->getEntityObject());

        $loggingChangesItems = [];
        foreach ($classInfo->getFieldsInfo() as $fieldName => $fieldInfo) {
            if (empty($changesItems[$fieldName])) {
                continue;
            }
            /** @var LoggingField $fieldAnnotation */
            $fieldAnnotation = $fieldInfo->getAnnotation();
            if (!$fieldAnnotation->logChanges) {
                continue;
            }
            $loggingChangesItems[] = $this->getFieldName($fieldName, $fieldAnnotation)
                . ' from '
                . $changesItems[$fieldName][0]
                . ' to '
                . $changesItems[$fieldName][1];
        }

        return str_replace(
            ['{{entityName}}', '{{pk}}', '{{changes}}'],
            [$className, implode(', ', $primaryKeyItems), implode(', ', $loggingChangesItems)],
            $classAnnotation->messageUpdate
        );
    }

    /**
     * @param string $fieldName
     * @param LoggingField $annotation
     * @return string
     */
    private function getFieldName(string $fieldName, LoggingField $annotation): string
    {
        if ($annotation->name === null) {
            return $fieldName;
        }

        return $annotation->name;
    }

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
}