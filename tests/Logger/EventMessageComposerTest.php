<?php


namespace App\Tests\Logger;


use App\Entity\Address;
use App\Logger\DefaultEntityEventMessager;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\UnitOfWork;
use PHPUnit\Framework\TestCase;

class EventMessageComposerTest extends TestCase
{
    public function testUpdate()
    {

        //  $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($classInfo->getEntityObject());
        $address = new Address('Russia', 'Volgograd', 'Lenina', '1a', '20');

        $unitOfWork = $this->createMock(UnitOfWork::class);
            $unitOfWork->expects($this->any())
            ->method('getEntityChangeSet')
            ->willReturn([
                'flat' => [5, 20]
            ]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->any())
            ->method('getUnitOfWork')
            ->willReturn($unitOfWork);

        $args = new LifecycleEventArgs($address, $entityManager);

        $entityEventMessager = new DefaultEntityEventMessager(new AnnotationReader());
        $message = $entityEventMessager->compose($address, 'update', $args);
        $this->assertTrue($message !== null, 'The message after entity update logging is null');
    }
}