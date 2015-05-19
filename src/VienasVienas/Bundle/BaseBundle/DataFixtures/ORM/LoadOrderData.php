<?php

namespace VienasVienas\Bundle\BaseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VienasVienas\Bundle\BaseBundle\Entity\Order;

class LoadOrderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $order = new Order();
        $order->setBook($this->getReference('book1'));
        $order->setUser($this->getReference('admin'));
        $order->setPickupDate(new \DateTime('2015-05-13'));
        $order->setStatus('active');

        $order2 = new Order();
        $order2->setBook($this->getReference('book3'));
        $order2->setUser($this->getReference('user1'));
        $order2->setPickupDate(new \DateTime('2015-05-13'));
        $order2->setStatus('active');

        $order3 = new Order();
        $order3->setBook($this->getReference('book10'));
        $order3->setUser($this->getReference('user3'));
        $order3->setPickupDate(new \DateTime('now'));
        $order3->setStatus('active');

        $order4 = new Order();
        $order4->setBook($this->getReference('book5'));
        $order4->setUser($this->getReference('user2'));
        $order4->setPickupDate(new \DateTime('2015-05-13'));
        $order4->setStatus('active');

        $order5 = new Order();
        $order5->setBook($this->getReference('book4'));
        $order5->setUser($this->getReference('admin'));
        $order5->setPickupDate(new \DateTime('2015-05-10'));
        $order5->setStatus('done');

        $manager->persist($order);
        $manager->persist($order2);
        $manager->persist($order3);
        $manager->persist($order4);
        $manager->persist($order5);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }
}