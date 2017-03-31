<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QOrder
 *
 * @ORM\Table(name="q_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QOrderRepository")
 */
class QOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="shipping_state", type="string", length=255)
     */
    private $shippingState;

    /**
     * @ORM\OneToOne(targetEntity="QProduct")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="QUser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\QProduct $product
     *
     * @return QOrder
     */
    public function setProduct(\AppBundle\Entity\QProduct $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\QProduct
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set shippingState
     *
     * @param string $shippingState
     *
     * @return QOrder
     */
    public function setShippingState($shippingState)
    {
        $this->shippingState = $shippingState;

        return $this;
    }

    /**
     * Get shippingState
     *
     * @return string
     */
    public function getShippingState()
    {
        return $this->shippingState;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\QUser $customer
     *
     * @return QOrder
     */
    public function setCustomer(\AppBundle\Entity\QUser $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\QUser
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
