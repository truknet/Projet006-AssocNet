<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Categories;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadCategoriesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $categories = new Categories();
        $categories->setName('Addiction');
        $this->addReference('categories1', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Agriculture');
        $this->addReference('categories2', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Animaux');
        $this->addReference('categories3', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Architecture et urbanisme');
        $this->addReference('categories4', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Art et culture');
        $this->addReference('categories5', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Athéisme');
        $this->addReference('categories6', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Caritatif et bénévolat');
        $this->addReference('categories7', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Chasse et pêche');
        $this->addReference('categories8', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Cryptologie');
        $this->addReference('categories9', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Culture sourde');
        $this->addReference('categories10', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Défense des droits');
        $this->addReference('categories11', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Économie');
        $this->addReference('categories12', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Éducation et formation');
        $this->addReference('categories13', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Énergie');
        $this->addReference('categories14', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Enfance et jeunesse');
        $this->addReference('categories15', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Environnement');
        $this->addReference('categories16', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Famille');
        $this->addReference('categories17', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Fédération');
        $this->addReference('categories18', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Handicap');
        $this->addReference('categories19', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Humanitaire');
        $this->addReference('categories20', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Informatique');
        $this->addReference('categories21', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Journalisme');
        $this->addReference('categories22', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Logement');
        $this->addReference('categories23', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Loisirs');
        $this->addReference('categories24', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Médias');
        $this->addReference('categories25', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Métier et social');
        $this->addReference('categories26', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Multi-activités');
        $this->addReference('categories27', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Musique');
        $this->addReference('categories28', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Patrimoine');
        $this->addReference('categories29', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Politique');
        $this->addReference('categories30', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Santé et maladie');
        $this->addReference('categories31', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Science et recherche');
        $this->addReference('categories32', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Sécurité');
        $this->addReference('categories33', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Séjour et tourisme');
        $this->addReference('categories34', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Service à la personne');
        $this->addReference('categories35', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Sport');
        $this->addReference('categories36', $categories);
        $manager->persist($categories);

        $categories = new Categories();
        $categories->setName('Vie locale');
        $this->addReference('categories37', $categories);
        $manager->persist($categories);

        $manager->flush();

    }


    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

}
