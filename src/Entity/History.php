<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class History
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="history")
 */
class History
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * History constructor.
     * @param string $message
     * @throws \Exception
     */
    public function __construct(string $message)
    {
        $this->message = $message;
        $this->createdAt = new \DateTime();
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
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}