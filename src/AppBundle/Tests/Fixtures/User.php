<?php
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;

class User extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{

    /** @var ContainerInterface */
    private $container;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface $passwordEncoder */
        $passwordEncoder = $this->container->get('security.password_encoder');
        /** @var \Faker\Generator $fakerGenerator */
        $fakerGenerator = $this->container->get('faker.generator');

        $users = [];

        $user = new \AppBundle\Entity\User();
        $user->setPassword($passwordEncoder->encodePassword($user, $fakerGenerator->slug));
        $user->setEmail($fakerGenerator->email);
        $user->setUsername($fakerGenerator->userName);
        $users[] = $user;

        foreach ($users as $user) {
            $manager->persist($user);
            $this->addReference('user-' . $user->getUsername(), $user);
        }
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}