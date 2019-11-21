<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Logger;

/**
 * Class Customer
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="customers")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Logger\LoggingClass(events={"create", "update"}, name="Customer")
 */
class Customer
{

    /**
     * Customer constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Logger\LoggingField(logChanges=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var Address[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Address",
     *      mappedBy="customer",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     */
    private $addresses;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param Address $address
     */
    public function addAddress(Address $address): void
    {
        $address->setCustomer($this);
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
        }
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     * @throws \Exception
     */
    public function markUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Magic string converting
     *
     * @return string
     */
    public function __toString()
    {
        return 'id: '.$this->id.', phone: '.$this->phone.', email: '.$this->email;
    }
}