<?php

namespace AppBundle\Security\Core\User;


use AppBundle\Entity\User;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class MyCustomServerFOSUBUserProvider extends BaseFOSUBProvider
{

    /**
     * @var RegistryInterface
     */
    private $doctrine;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function __construct(UserManagerInterface $userManager, array $properties, RegistryInterface $doctrine)
    {
        parent::__construct($userManager, $properties);
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();

    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $username = $response->getUsername(); // get the unique user identifier

        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy([$property => $username]);
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            // ...

            $this->userManager->updateUser($existingUser);
        }
        // we connect current user, set current user id and token
        // ...
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        /** @var PathUserResponse $response */
        $userEmail = $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);

        // if null just create new user and set it properties
        if (null === $user) {
            $user = new User();
            $user->setUsername($response->getRealName());
            $user->setEmail($response->getEmail());
            $user->setMyCustomServer($response->getUsername());
            $user->setPassword('none');
            $user->setEnabled(true);
        }


        // else update access token of existing user
        $user->setMyCustomServerAccessToken($response->getAccessToken());//update access token
        $this->em->persist($user);
        $this->em->flush();


        return $user;
    }
}