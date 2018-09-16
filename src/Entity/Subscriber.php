<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriberRepository")
 */
class Subscriber
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Messenger", inversedBy="subscribers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $messenger;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $messenger_subscriber_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Getters and setters
     */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessenger(): ?Messenger
    {
        return $this->messenger;
    }

    public function setMessenger(Messenger $messenger): self
    {
        $this->messenger = $messenger;

        return $this;
    }

    public function getMessengerSubscriberId(): ?string
    {
        return $this->messenger_subscriber_id;
    }

    public function setMessengerSubscriberId(string $messenger_subscriber_id): self
    {
        $this->messenger_subscriber_id = $messenger_subscriber_id;

        return $this;
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
}
