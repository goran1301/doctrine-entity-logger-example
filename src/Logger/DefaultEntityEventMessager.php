<?php


namespace App\Logger;


use Doctrine\Common\Annotations\Reader;

/**
 * Class DefaultEntityEventMessager
 * @package App\Logger
 */
class DefaultEntityEventMessager extends EventMessageComposer
{
    /**
     * DefaultEntityEventMessager constructor.
     * @param Reader $annotationReader
     */
    public function __construct(Reader $annotationReader)
    {
        parent::__construct($annotationReader, [
            CreateEventProcession::EVENT => new CreateEventProcession(),
            UpdateEventProcession::EVENT => new UpdateEventProcession(),
        ]);
    }
}