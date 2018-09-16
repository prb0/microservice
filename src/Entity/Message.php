<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subscriber")
     */
    private $subscriber;

    /**
     * Construct method
     */

    public function __construct(Subscriber $subscriber, string $text)
    {
        $this->subscriber = $subscriber;
        $this->text = $text;
    }

    /**
     * Getters and setters
     */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
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

    public function getSubscriber(): ?Subscriber
    {
        return $this->subscriber;
    }

    public function setSubscriber(Subscriber $subscriber): self
    {
        $this->subscriber = $subscriber;

        return $this;
    }
}
