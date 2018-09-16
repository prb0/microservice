<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessengerRepository")
 */
class Messenger
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subscriber", mappedBy="messenger")
     */
    private $subscribers;

    /**
     * Getters and setters
     */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSubscribers(): ?Subscriber
    {
        return $this->subscribers;
    }

    public function setSubscribers(Subscriber $subscribers): self
    {
        $this->subscribers = $subscribers;

        return $this;
    }
}
