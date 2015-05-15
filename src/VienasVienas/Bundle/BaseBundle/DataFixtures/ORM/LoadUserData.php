<?php
/**
 * Created by PhpStorm.
 * User: destas
 * Date: 5/14/15
 * Time: 5:21 PM
 */

namespace VienasVienas\Bundle\BaseBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VienasVienas\Bundle\BaseBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setEmail('valdemar.karasevic@gmail.com');
        $user1->setPlainPassword('destas');
        $user1->setEnabled(true);
        $user1->setRoles(array('ROLE_ADMIN'));

        $user2 = new User();
        $user2->setEmail('petras@petras.lt');
        $user2->setPlainPassword('petras');
        $user2->setEnabled(true);

        $user3 = new User();
        $user3->setEmail('jonas@jonas.lt');
        $user3->setPassword('jonas');
        $user3->setEnabled(true);

        $user4 = new User();
        $user4->setEmail('tomas@tomas.lt');
        $user4->setPlainPassword('tomas');
        $user4->setEnabled(true);

        $user5 = new User();
        $user5->setEmail('gena@gena.lt');
        $user5->setPlainPassword('genagena');
        $user5->setEnabled(true);





        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);
        $manager->flush();

        $this->addReference('admin', $user1);
        $this->addReference('user1', $user2);
        $this->addReference('user2', $user3);
        $this->addReference('user3', $user4);
        $this->addReference('user4', $user5);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }
}