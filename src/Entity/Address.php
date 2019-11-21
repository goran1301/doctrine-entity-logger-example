<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Logger;

/**
 * Class Address
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="addresses")
 *
 * @Logger\LoggingClass(events={"create", "update"})
 */
class Address
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Logger\LoggingField(logChanges=true)
     *
     * @ORM\Column(type="string")
     */
    private $country;

    /**
     * @var string
     *
     * @Logger\LoggingField(logChanges=true)
     *
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @var string
     *
     * @Logger\LoggingField(logChanges=true)
     *
     * @ORM\Column(type="string")
     */
    private $street;

    /**
     * @var string
     *
     * @Logger\LoggingField(logChanges=true)
     *
     * @ORM\Column(type="string")
     */
    private $house;

    /**
     * @var string
     *
     * @Logger\LoggingField(logChanges=true)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $flat;

    /**
     * @var Customer
     *
     * @Logger\LoggingField(logChanges=true)
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * Address constructor.
     * @param string $country
     * @param string $city
     * @param string $street
     * @param string $house
     * @param string|null $flat
     */
    public function __construct(string $country, string $city, string $street, string $house, ?string $flat = null)
    {
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
        $this->flat = $flat;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getHouse(): string
    {
        return $this->house;
    }

    /**
     * @return string|null
     */
    public function getFlat(): ?string
    {
        return $this->flat;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @param string $house
     */
    public function setHouse(string $house): void
    {
        $this->house = $house;
    }

    /**
     * @param string $flat
     */
    public function setFlat(string $flat): void
    {
        $this->flat = $flat;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }
}