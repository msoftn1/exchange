<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rate
 *
 * @ORM\Table(name="rate")
 * @ORM\Entity
 */
class Rate
{
    const TYPE_USD_RUB = 1;
    const TYPE_EUR_RUB = 2;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="sell", type="float", precision=5, scale=2, nullable=false)
     */
    private $sell;

    /**
     * @var float
     *
     * @ORM\Column(name="buy", type="float", precision=5, scale=2, nullable=false)
     */
    private $buy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added_at", type="datetime", nullable=false)
     */
    private $addedAt;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getType(): ?int
    {
        return $this->int;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSell(): ?float
    {
        return $this->sell;
    }

    public function setSell(float $sell): self
    {
        $this->sell = $sell;

        return $this;
    }

    public function getBuy(): ?float
    {
        return $this->buy;
    }

    public function setBuy(float $buy): self
    {
        $this->buy = $buy;

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeInterface $addedAt): self
    {
        $this->addedAt = $addedAt;

        return $this;
    }


}
