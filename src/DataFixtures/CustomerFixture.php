<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CustomerFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $customer1 = new Customer();
        $customer1->setEmail('customer1@customer.dev');
        $customer1->setName('Customer1 Customer1');
        $customer1->setPhone('1111111');

        $address11 = new Address('Russia', 'Volgograd', 'Lenina', '12a', '21');
        $address12 = new Address('Russia', 'Volgograd', 'Zhukova', '1б', '42');
        $address13 = new Address('Russia', 'Volgograd', 'Dvinskaya', '12f', '4');

        $customer1->addAddress($address11);
        $customer1->addAddress($address12);
        $customer1->addAddress($address13);

        $customer2 = new Customer();
        $customer2->setEmail('customer2@customer.dev');
        $customer2->setName('Customer2 Customer2');
        $customer2->setPhone('2222222');

        $address21 = new Address('Russia', 'Volgograd', 'Lenina', '212a', '221');
        $address22 = new Address('Russia', 'Volgograd', 'Zhukova', '21б', '242');
        $address23 = new Address('Russia', 'Volgograd', 'Dvinskaya', '212f', '24');

        $customer2->addAddress($address21);
        $customer2->addAddress($address22);
        $customer2->addAddress($address23);

        $customer3 = new Customer();
        $customer3->setEmail('customer3@customer.dev');
        $customer3->setName('Customer3 Customer3');
        $customer3->setPhone('333333');

        $address31 = new Address('Russia', 'Volgograd', 'Lenina', '312a', '321');
        $address32 = new Address('Russia', 'Volgograd', 'Zhukova', '31б', '342');
        $address33 = new Address('Russia', 'Volgograd', 'Dvinskaya', '312f', '34');

        $customer3->addAddress($address31);
        $customer3->addAddress($address32);
        $customer3->addAddress($address33);


        $manager->persist($customer1);
        $manager->persist($customer2);
        $manager->persist($customer3);
        $manager->flush();
    }
}
