<?php
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Post extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{

    /** @var ContainerInterface */
    private $container;


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var \Faker\ORM\Doctrine\Populator $fakerPopulator */
        $fakerPopulator = $this->container->get('faker.populator');

        $fakerPopulator->addEntity('AppBundle\Entity\Post', 10);
        $ids = $fakerPopulator->execute();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}