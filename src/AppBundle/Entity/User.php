<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="my_custom_server", type="string", length=255, nullable=true)
     */
    private $myCustomServer;

    /**
     * @ORM\Column(name="my_custom_server_access_token", type="string", length=255, nullable=true)
     */
    private $myCustomServerAccessToken;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set myCustomServer
     *
     * @param string $myCustomServer
     *
     * @return User
     */
    public function setMyCustomServer($myCustomServer)
    {
        $this->myCustomServer = $myCustomServer;

        return $this;
    }

    /**
     * Get myCustomServer
     *
     * @return string
     */
    public function getMyCustomServer()
    {
        return $this->myCustomServer;
    }

    /**
     * Set myCustomServerAccessToken
     *
     * @param string $myCustomServerAccessToken
     *
     * @return User
     */
    public function setMyCustomServerAccessToken($myCustomServerAccessToken)
    {
        $this->myCustomServerAccessToken = $myCustomServerAccessToken;

        return $this;
    }

    /**
     * Get myCustomServerAccessToken
     *
     * @return string
     */
    public function getMyCustomServerAccessToken()
    {
        return $this->myCustomServerAccessToken;
    }
}
