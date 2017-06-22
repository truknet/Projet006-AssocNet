<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Associations;
use AppBundle\Entity\Showcase;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;



class LoadAssociationsData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $association1 = new Associations();
        $association1->setName('SOS CHATONS');
        $association1->setSearchaddress('279 Route de Clisson, 44230 Saint-Sébastien-sur-Loire, France');
        $association1->setNumstreet('279');
        $association1->setAddress1('Route de Clisson');
        $association1->setAddress2(null);
        $association1->setPostalcode('44230');
        $association1->setCity('Saint-Sébastien-sur-Loire');
        $association1->setDepartment('Loire-Atlantique');
        $association1->setRegion('Pays de la Loire');
        $association1->setCountry('France');
        $association1->setPlaceId('ChIJcfYv3cDoBUgRhO0Dwm9avro');
        $association1->setObject('Recueil, socialisation et protection des chats errants, perdus, abandonnés ou blessés en vue de leur stérilisation et de leur adoption ainsi que toute action visant à sensibiliser la population et les élus sur le sort des chats errants');
        $association1->setPhoneNumber(null);
        $association1->setUrl(null);
        $association1->setHits(0);
        $association1->setLogo(null);
        $association1->setRna('W442010649');
        $association1->setDateCreation(new \DateTime('2012-05-12'));
        $association1->setDateApproval(new \DateTime());
        $association1->setApprouvedBy($this->getReference('user.admin'));
        $association1->setStatus("validated");
        $association1->setCategorie($this->getReference('categories3'));
        $association1->setAuthor($this->getReference('user.admin'));
        $showcase = new Showcase();
        $showcase->setTheme('css/Bootswatch3/bootstrap/bootstrap.min.css');
        $association1->setShowcase($showcase);
        $manager->persist($association1);

        $association1 = new Associations();
        $association1->setName('VIE DE FAMILLE');
        $association1->setSearchaddress('2 Rue de la Roche Arnaud, 43000 Le Puy-en-Velay, France');
        $association1->setNumstreet('2');
        $association1->setAddress1('Rue de la Roche Arnaud');
        $association1->setAddress2(null);
        $association1->setPostalcode('43000');
        $association1->setCity('Le Puy-en-Velaye');
        $association1->setDepartment('Haute-Loire');
        $association1->setRegion('Auvergne-Rhône-Alpes');
        $association1->setCountry('France');
        $association1->setPlaceId('ChIJRd5zjFD69UcR041J4b9OQis');
        $association1->setObject('Entreprendre toutes les initiatives possibles pour l\'épanouissement de la vie de famille ; l\'association se veut un soutien aux familles');
        $association1->setPhoneNumber(null);
        $association1->setUrl(null);
        $association1->setHits(0);
        $association1->setLogo(null);
        $association1->setRna('W432003800');
        $association1->setDateCreation(new \DateTime('2013-09-12'));
        $association1->setDateApproval(new \DateTime());
        $association1->setApprouvedBy($this->getReference('user.admin'));
        $association1->setStatus("validated");
        $association1->setCategorie($this->getReference('categories17'));
        $association1->setAuthor($this->getReference('user.admin'));
        $showcase = new Showcase();
        $showcase->setTheme('css/Bootswatch3/bootstrap/bootstrap.min.css');
        $association1->setShowcase($showcase);
        $manager->persist($association1);


        $association1 = new Associations();
        $association1->setName('LA FORET ENVIRONNEMENT');
        $association1->setSearchaddress('Coat Beuz, La Forêt-Fouesnant, France');
        $association1->setNumstreet(null);
        $association1->setAddress1('Coat Beuz');
        $association1->setAddress2(null);
        $association1->setPostalcode('29940');
        $association1->setCity('La Forêt-Fouesnant');
        $association1->setDepartment('Finistère');
        $association1->setRegion('Bretagne');
        $association1->setCountry('France');
        $association1->setPlaceId('ChIJSZIsDKXQEEgR0GSpv8-lDAo');
        $association1->setObject('Préservation de l\'environnement du point de vue territorial, son champ de compétence porte sur le territoire de la commune de la Forêt-Fouesnant ou sur tout ou partie du territoire des communes limitrophes de la commune citée, lorsque se trouvent en cause les continuités écologiques qui se poursuivent au-delà du territoire communal, ou le même bassin versant que les communes limitrophes ; sur les espaces littoraux et maritimes de la Baie de la Forêt ; d\'un point de vue matériel : protection de l\'environnement notamment : la protection des espaces naturels côtiers, littoraux, rétro-littoraux et ruraux, la lutte contre l\'étalement urbain et l\'urbanisation diffuse, la préservation des espaces agricoles et forestiers et du bocage, la préservation des paysages naturels et bâtis,la préservation des zones humides et de la qualité des eaux maritimes et terrestres, la lutte contre les pollutions de l\'air, de l\'eau, des sols, les pollutions sonores et lumineuses et la préservation des espèces, de la faune, la flore et de leur habitat');
        $association1->setPhoneNumber(null);
        $association1->setUrl(null);
        $association1->setHits(0);
        $association1->setLogo(null);
        $association1->setRna('W294002728');
        $association1->setDateCreation(new \DateTime('1970-03-11'));
        $association1->setDateApproval(new \DateTime());
        $association1->setApprouvedBy($this->getReference('user.admin'));
        $association1->setStatus("validated");
        $association1->setCategorie($this->getReference('categories16'));
        $association1->setAuthor($this->getReference('user.admin'));
        $showcase = new Showcase();
        $showcase->setTheme('css/Bootswatch3/bootstrap/bootstrap.min.css');
        $association1->setShowcase($showcase);
        $manager->persist($association1);


        $association1 = new Associations();
        $association1->setName('SOLEIL LEVANT');
        $association1->setSearchaddress('97 Avenue du Sport, 34400 Lunel-Viel, France');
        $association1->setNumstreet('97');
        $association1->setAddress1('Avenue du Sport');
        $association1->setAddress2(null);
        $association1->setPostalcode('34400');
        $association1->setCity('Lunel-Viel');
        $association1->setDepartment('Hérault');
        $association1->setRegion('Occitanie');
        $association1->setCountry('France');
        $association1->setPlaceId('ChIJjZWd9HSfthIRLH9j15HyPTs');
        $association1->setObject('Promouvoir toute activité liée à l\'étude et à la pratique du yoga, discipline physique composée de postures, respirations et relaxation');
        $association1->setPhoneNumber(null);
        $association1->setUrl(null);
        $association1->setHits(0);
        $association1->setLogo(null);
        $association1->setRna('W343010990');
        $association1->setDateCreation(new \DateTime('2010-04-29'));
        $association1->setDateApproval(null);
        $association1->setApprouvedBy(null);
        $association1->setStatus("waiting");
        $association1->setCategorie($this->getReference('categories36'));
        $association1->setAuthor($this->getReference('user.manon'));
        $showcase = new Showcase();
        $showcase->setTheme('css/Bootswatch3/bootstrap/bootstrap.min.css');
        $association1->setShowcase($showcase);
        $manager->persist($association1);



        $association1 = new Associations();
        $association1->setName('LES PECHEURS DE PENHARS');
        $association1->setSearchaddress('2 Rue du Dauphiné, 29000 Quimper, France');
        $association1->setNumstreet('2');
        $association1->setAddress1('Rue du Dauphiné');
        $association1->setAddress2(null);
        $association1->setPostalcode('29000');
        $association1->setCity('Quimper');
        $association1->setDepartment('Finistère');
        $association1->setRegion('Bretagne');
        $association1->setCountry('Fr');
        $association1->setPlaceId('EikyIFJ1ZSBkdSBEYXVwaGluw6ksIDI5MDAwIFF1aW1wZXIsIEZyYW5jZQ');
        $association1->setObject("Favoriser la pratique de la pêche loisirs ; promouvoir la pêche sur le quartier de Penhars ; sensibiliser les jeunes au respect de l'environnement ; oeuvrer aux liens intergénérationnels sur le quartier de Penhars");
        $association1->setPhoneNumber(null);
        $association1->setUrl(null);
        $association1->setHits(0);
        $association1->setLogo(null);
        $association1->setRna('W294003206');
        $association1->setDateCreation(new \DateTime('2009-01-31'));
        $association1->setDateApproval(new \DateTime());
        $association1->setApprouvedBy($this->getReference('user.admin'));
        $association1->setStatus("validated");
        $association1->setCategorie($this->getReference('categories8'));
        $association1->setAuthor($this->getReference('user.admin'));
        $showcase = new Showcase();
        $showcase->setTheme('css/Bootswatch3/bootstrap/bootstrap.min.css');
        $association1->setShowcase($showcase);
        $manager->persist($association1);

        $association1 = new Associations();
        $association1->setName('PARIS-THEMES');
        $association1->setSearchaddress('18 Rue du Charolais, 75012 Paris, France');
        $association1->setNumstreet("18");
        $association1->setAddress1('Rue du Charolais');
        $association1->setAddress2(null);
        $association1->setPostalcode('75012');
        $association1->setCity('Paris');
        $association1->setDepartment('Paris');
        $association1->setRegion('Île-de-France');
        $association1->setCountry('Fr');
        $association1->setPlaceId('ChIJ5zK1pxRy5kcR-NWJKyJ68FU');
        $association1->setObject("Proposer des manifestations culturelles ouvertes à tous (associations, établissements scolaires, jeunes, familles...) permettant de découvrir Paris et ses environs. Paris-Thèmes a pour but de favoriser l'accès à l'Art et à la Culture du Monde à travers la connaissance de Paris et des collections de ses Musées, elle pourra organiser des sorties, visites guidées, expositions, cours, formations, salons, conférences, ateliers, jeux, séjours et voyages et autres rencontres");
        $association1->setPhoneNumber(null);
        $association1->setUrl(null);
        $association1->setHits(0);
        $association1->setLogo(null);
        $association1->setRna('W301001563');
        $association1->setDateCreation(new \DateTime('2008-01-26'));
        $association1->setDateApproval(null);
        $association1->setApprouvedBy(null);
        $association1->setStatus("waiting");
        $association1->setCategorie($this->getReference('categories5'));
        $association1->setAuthor($this->getReference('user.manon'));
        $showcase = new Showcase();
        $showcase->setTheme('css/Bootswatch3/bootstrap/bootstrap.min.css');
        $association1->setShowcase($showcase);
        $manager->persist($association1);

        $manager->flush();

    }


    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 4;
    }

}
