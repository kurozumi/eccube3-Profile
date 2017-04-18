<?php

namespace Plugin\Profile\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 */
class Profile extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var integer
     */
    private $customer_id;

    /**
     * @var \Eccube\Entity\Customer
     */
    private $Customer;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nickname
     *
     * @param string $nickame
     * @return Profile
     */
    public function setNickname($shopName)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string 
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set customer_id
     *
     * @param integer $customerId
     * @return Profile
     */
    public function setCustomerId($customerId)
    {
        $this->customer_id = $customerId;

        return $this;
    }

    /**
     * Get customer_id
     *
     * @return integer 
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Set Customer
     *
     * @param \Eccube\Entity\Customer $customer
     * @return Profile
     */
    public function setCustomer(\Eccube\Entity\Customer $customer)
    {
        $this->Customer = $customer;

        return $this;
    }

    /**
     * Get Customer
     *
     * @return \Eccube\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->Customer;
    }
}
