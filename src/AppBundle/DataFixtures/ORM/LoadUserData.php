<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the container.
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEmail('admin@admin.com');
        $user->setUsername('admin');
        $user->setName('Bruno HARE');
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $user->addRole('ROLE_SUPER_ADMIN');
        $userManager->updateUser($user);
        $this->addReference('user.admin', $user);

        $user = $userManager->createUser();
        $user->setEmail('info@trukotop.com');
        $user->setUsername('Manon');
        $user->setName('Manon Koude');
        $user->setPlainPassword('123');
        $user->setEnabled(true);
        $user->addRole('ROLE_USER');
        $userManager->updateUser($user);
        $this->addReference('user.manon', $user);

        $user = $userManager->createUser();
        $user->setEmail('info@truknet.com');
        $user->setUsername('Jeannot');
        $user->setName('Jean Voye');
        $user->setPlainPassword('123');
        $user->setEnabled(true);
        $user->addRole('ROLE_USER');
        $userManager->updateUser($user);
        $this->addReference('user.jeannot', $user);

        $user = $userManager->createUser();
        $user->setEmail('info@truksatrok.com');
        $user->setUsername('Nathalie');
        $user->setName('Nathalie Sync');
        $user->setPlainPassword('123');
        $user->setEnabled(true);
        $user->addRole('ROLE_USER');
        $userManager->updateUser($user);
        $this->addReference('user.nathalie', $user);
    }



    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }

}
