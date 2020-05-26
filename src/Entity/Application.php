<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity
 */
class Application
{
    const TYPE_BITCOINT = 1;
    const TYPE_WMZ = 2;
    const TYPE_OTHER = 3;

    const STATUS_NEW = 1;
    const STATUS_PROCESSED = 2;
    const STATUS_CANCELED = 3;

    private static array $types = [
      self::TYPE_BITCOINT,
      self::TYPE_WMZ,
      self::TYPE_OTHER
    ];

    public static array $typesText = [
      self::TYPE_BITCOINT => 'Bitcoin',
      self::TYPE_WMZ => 'WMZ',
      self::TYPE_OTHER => 'Other'
    ];

    public static array $statusesText = [
      self::STATUS_NEW => 'New',
      self::STATUS_PROCESSED => 'Processed',
      self::STATUS_CANCELED => 'Canceled'
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Range(min=0.01, max=999999.99)
     *
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=8, scale=2, nullable=false)
     */
    private $amount;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     * @var string
     *
     * @ORM\Column(name="wallet", type="string", length=255, nullable=false)
     */
    private $wallet;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices={1,2,3})
     * @var int
     *
     * @ORM\Column(name="type", type="smallint", nullable=false)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getWallet(): ?string
    {
        return $this->wallet;
    }

    public function setWallet(string $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatusText()
    {
        return self::$statusesText[$this->getStatus()];
    }

    public function getTypeText()
    {
        return self::$typesText[$this->getType()];
    }
}
