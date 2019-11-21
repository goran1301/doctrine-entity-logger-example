<?php


namespace App\Logger;


use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping\Id;

/**
 * Class EventMessageComposer
 * @package App\Logger
 */
class EventMessageComposer
{
    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @var EntityLogEventProcession[]
     */
    private $logEventProcessions;

    /**
     * EventMessageComposer constructor.
     * @param Reader $annotationReader
     * @param EntityLogEventProcession[] $logEventProcessions
     */
    public function __construct(Reader $annotationReader, array $logEventProcessions)
    {
        $this->annotationReader = $annotationReader;
        $this->logEventProcessions = $logEventProcessions;
    }

    /**
     * @param object $entityObject
     * @param string $eventName
     * @param LifecycleEventArgs $args
     * @return string|null
     *
     * @throws \ReflectionException
     */
    public function compose($entityObject, string $eventName, LifecycleEventArgs $args): ?string
    {
        if (empty($this->logEventProcessions[$eventName])) {
            return null;
        }
        $class = get_class($entityObject);
        $reflectionClass = new \ReflectionClass($class);
        $classInfo = $this->collectClassInfo($entityObject, $reflectionClass, $eventName);

        return $this->logEventProcessions[$eventName]->compose($classInfo, $args);
    }

    /**
     * @param object $entityObject
     * @param string $eventName
     * @param \ReflectionClass $reflectionClass
     * @return FieldInfo[]
     */
    private function collectFieldInfo($entityObject, string $eventName, \ReflectionClass $reflectionClass): array
    {
        $annotations = [];
        foreach ($reflectionClass->getProperties() as $property) {

            $annotation = $this->annotationReader->getPropertyAnnotation(
                $property,
                $this->logEventProcessions[$eventName]->getPropertyAnnotationInstance()
            );

            if ($annotation == null) {
                continue;
            }
            $property->setAccessible(true);

            $isPrimary = !empty($this->annotationReader->getPropertyAnnotation(
                $property,
                Id::class
            ));
            $annotations[$property->getName()] = new FieldInfo($annotation, $property->getValue($entityObject), $isPrimary);
        }

        return $annotations;
    }

    /**
     * @param object $entityObject
     * @param \ReflectionClass $reflectionClass
     * @return array
     */
    private function collectPK($entityObject, \ReflectionClass $reflectionClass): array
    {
        $pk = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            if (!empty($this->annotationReader->getPropertyAnnotation(
                $property,
                Id::class
            ))) {
               $pk[$property->getName()] = $property->getValue($entityObject);
            }
        }
        return $pk;
    }

    /**
     * @param $entityObject
     * @param \ReflectionClass $reflectionClass
     * @param string $eventName
     * @return ClassInfo
     */
    private function collectClassInfo($entityObject, \ReflectionClass $reflectionClass, string $eventName): ClassInfo
    {
        $annotation = $this->annotationReader->getClassAnnotation(
            $reflectionClass,
            $this->logEventProcessions[$eventName]->getClassAnnotationInstance()
        );

        return new ClassInfo(
            $entityObject,
            $annotation,
            $this->collectPK($entityObject, $reflectionClass),
            $this->collectFieldInfo($entityObject, $eventName, $reflectionClass)
        );
    }

}