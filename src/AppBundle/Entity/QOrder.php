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
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="QMainOrder")
     */
    private $mainOrder;

    /**
     * @ORM\OneToOne(targetEntity="QProduct")
     */
    private $product;

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
     * Set state
     *
     * @param string $state
     *
     * @return QOrder
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set mainOrder
     *
     * @param \AppBundle\Entity\QMainOrder $mainOrder
     *
     * @return QOrder
     */
    public function setMainOrder(\AppBundle\Entity\QMainOrder $mainOrder)
    {
        $this->mainOrder = $mainOrder;

        return $this;
    }

    /**
     * Get mainOrder
     *
     * @return \AppBundle\Entity\QMainOrder
     */
    public function getMainOrder()
    {
        return $this->mainOrder;
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
}
