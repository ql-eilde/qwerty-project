<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="q_user")
 */
class QUser extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $first_name;

    /**
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $last_name;

    /**
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    protected $phone_number;

    /**
     * @ORM\Column(name="shipping_street", type="string", length=255, nullable=true)
     */
    protected $shippingStreet;

    /**
     * @ORM\Column(name="shipping_city", type="string", length=255, nullable=true)
     */
    protected $shippingCity;

    /**
     * @ORM\Column(name="shipping_postcode", type="string", length=255, nullable=true)
     */
    protected $shipping_postcode;

    /**
     * @ORM\Column(name="billing_street", type="string", length=255, nullable=true)
     */
    protected $billingStreet;

    /**
     * @ORM\Column(name="billing_city", type="string", length=255, nullable=true)
     */
    protected $billingCity;

    /**
     * @ORM\Column(name="billing_postcode", type="string", length=255, nullable=true)
     */
    protected $billing_postcode;

    /**
     * @ORM\OneToOne(targetEntity="QIban")
     */
    protected $iban;

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return QUser
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return QUser
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return QUser
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->setUsername($email);
    }

    /**
     * Set iban
     *
     * @param \AppBundle\Entity\QIban $iban
     *
     * @return QUser
     */
    public function setIban(\AppBundle\Entity\QIban $iban = null)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get iban
     *
     * @return \AppBundle\Entity\QIban
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Set shippingStreet
     *
     * @param string $shippingStreet
     *
     * @return QUser
     */
    public function setShippingStreet($shippingStreet)
    {
        $this->shippingStreet = $shippingStreet;

        return $this;
    }

    /**
     * Get shippingStreet
     *
     * @return string
     */
    public function getShippingStreet()
    {
        return $this->shippingStreet;
    }

    /**
     * Set shippingCity
     *
     * @param string $shippingCity
     *
     * @return QUser
     */
    public function setShippingCity($shippingCity)
    {
        $this->shippingCity = $shippingCity;

        return $this;
    }

    /**
     * Get shippingCity
     *
     * @return string
     */
    public function getShippingCity()
    {
        return $this->shippingCity;
    }

    /**
     * Set shippingPostcode
     *
     * @param string $shippingPostcode
     *
     * @return QUser
     */
    public function setShippingPostcode($shippingPostcode)
    {
        $this->shipping_postcode = $shippingPostcode;

        return $this;
    }

    /**
     * Get shippingPostcode
     *
     * @return string
     */
    public function getShippingPostcode()
    {
        return $this->shipping_postcode;
    }

    /**
     * Set billingStreet
     *
     * @param string $billingStreet
     *
     * @return QUser
     */
    public function setBillingStreet($billingStreet)
    {
        $this->billingStreet = $billingStreet;

        return $this;
    }

    /**
     * Get billingStreet
     *
     * @return string
     */
    public function getBillingStreet()
    {
        return $this->billingStreet;
    }

    /**
     * Set billingCity
     *
     * @param string $billingCity
     *
     * @return QUser
     */
    public function setBillingCity($billingCity)
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    /**
     * Get billingCity
     *
     * @return string
     */
    public function getBillingCity()
    {
        return $this->billingCity;
    }

    /**
     * Set billingPostcode
     *
     * @param string $billingPostcode
     *
     * @return QUser
     */
    public function setBillingPostcode($billingPostcode)
    {
        $this->billing_postcode = $billingPostcode;

        return $this;
    }

    /**
     * Get billingPostcode
     *
     * @return string
     */
    public function getBillingPostcode()
    {
        return $this->billing_postcode;
    }
}
