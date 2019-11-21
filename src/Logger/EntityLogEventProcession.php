<?php


namespace App\Logger;


use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class EntityLogEventProcession
 * @package App\Logger
 */
abstract class EntityLogEventProcession
{

    /**
     * @param ClassInfo $classInfo
     * @param LifecycleEventArgs $args
     * @return string|null
     */
    public function compose(ClassInfo $classInfo, LifecycleEventArgs $args): ?string
    {
        $classAnnotationInstance = $this->getClassAnnotationInstance();
        if (!$classInfo->getAnnotation() instanceof $classAnnotationInstance) {
            return null;
        }
        if (!$this->needToLog($classInfo, $args)) {
            return null;
        }

        return $this->doCompose($classInfo, $args);
    }

    /**
     * @return string
     */
    abstract public function getClassAnnotationInstance(): string;

    /**
     * @return string
     */
    abstract public function getPropertyAnnotationInstance(): string;

    /**
     * @param ClassInfo $classInfo
     * @param LifecycleEventArgs $args
     * @return bool
     */
    abstract protected function needToLog(ClassInfo $classInfo, LifecycleEventArgs $args): bool;

    /**
     * @param ClassInfo $classInfo
     * @param LifecycleEventArgs $args
     * @return string
     */
    abstract protected function doCompose(ClassInfo $classInfo, LifecycleEventArgs $args): string;
}