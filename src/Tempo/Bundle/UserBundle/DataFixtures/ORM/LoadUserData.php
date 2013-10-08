<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tempo\Bundle\UserBundle\Entity\User;

/**
 *
 */
class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {

        $userManager = $this->container->get('fos_user.user_manager');


        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setUsernameCanonical('admin');
        $admin->setEmail('admin@admin.com');
        $admin->setEmailCanonical('admin@admin.com');
        $admin->setLastName('test');
        $admin->setFirstName('test');
        $admin->setPlainPassword('admin');
        $admin->setPassword('admin');
        $admin->addRole(User::ROLE_DEFAULT);
        $admin->addRole(User::ROLE_SUPER_ADMIN);
        $admin->setEnabled(true);

        $userManager->updateUser($admin, true);

        $this->addReference('admin', $admin);

        $user = $userManager->createUser();
        $user->setUsername('test');
        $user->setUsernameCanonical('test');
        $user->setLastName('test');
        $user->setFirstName('test');
        $user->setEmail('test@test.com');
        $user->setEmailCanonical('test@test.com');
        $user->setPlainPassword('test');
        $user->setPassword('test');
        $user->addRole(User::ROLE_DEFAULT);
        $user->setEnabled(true);
        $this->addReference('test', $admin);

        $userManager->updateUser($user, true);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}