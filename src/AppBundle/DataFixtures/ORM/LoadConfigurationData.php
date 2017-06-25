<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Configuration;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadConfigurationData extends AbstractFixture implements OrderedFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $config = new Configuration();
        $config->setName('config1');
        $config->setThemeFront('css/Bootswatch3/bootstrap-flatly/bootstrap.min.css');
        $config->setThemeAdmin('css/Bootswatch3/bootstrap-slate/bootstrap.min.css');
        $config->setFrontSidebarLastAssocNb(5);
        $config->setFrontListAssocNb(5);
        $config->setAdminValidAutoSubmissionAssoc(false);

        $manager->persist($config);
        $manager->flush();

    }


    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }

}
