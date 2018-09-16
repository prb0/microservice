<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerBuilder;
use App\Entity\Subscriber;

class MessengerController extends AbstractController
{
	/**
	 * @Route("/messenger/get/subscribers", name="getSubscribersByMessengerId", methods={"POST"})
	 */
	public function getSubscribers(Request $request)
	{
		/**
		 * Get all subscribers by messenger id.
		 * Returns JSON string with subscribers or if not found them - throws an exception
		 */
		$repository = $this->getDoctrine()->getRepository(Subscriber::class);
		$subscriberObjects = $repository->findBy(['messenger' => $request->request->get('messengerId')]);

		if (!$subscriberObjects) {
			throw $this->createNotFoundException(
				'No subscribers found for this messenger'
			);
		}

		$serializer = SerializerBuilder::create()->build();
		$response = $serializer->serialize($subscriberObjects, 'json');

		return $this->json($response);
	}
}
