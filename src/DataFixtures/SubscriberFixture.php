<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Messenger;
use App\Entity\Subscriber;

class SubscriberFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	$subscriberNames = [
    		'John Doe',
    		'Vladimir Putin',
    		'Bill Gates',
    		'Artem Dzyuba',
    		'Fedor Smolov',
    		'Onion Chippolino',
    		'Rick Smith',
    		'Morty Smith',
    		'Donald Trump',
    		'Angela Merkel',
    		'Kim Chen Yr',
    		'Dmitry Medvedev',
    		'George Bush',
    		'Simple Homeless'
    	];
    	$messengerNames = ['WhatsApp', 'Viber', 'Telegram'];
    	$messengers = [];

    	foreach ($messengerNames as $index => $messengerName) {
    		$messengers[$index] = new Messenger();
    		$messengers[$index]->setName($messengerName);
    		$manager->persist($messengers[$index]);
    	}

    	foreach ($subscriberNames as $subscriberName) {
        	$subscriber = new Subscriber();
        	$subscriber->setName($subscriberName);
        	$subscriber->setMessenger($messengers[mt_rand(0, count($messengerNames) - 1)]);
        	$subscriber->setMessengerSubscriberId(mt_rand(10101, 101010));
        	$manager->persist($subscriber);
    	}

        $manager->flush();
    }
}
