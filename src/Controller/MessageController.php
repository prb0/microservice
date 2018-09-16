<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Services\MessageCreator;
use App\Entity\Messenger;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function message()
    {
        /**
         * Generates page with form which creates the messages
         * $messengers contains only messengers which has subscribers
         */
    	$repository = $this->getDoctrine()->getRepository(Messenger::class);
    	$messengers = $repository->findWhereHasSubscribers();

        return $this->render('message/page.html.twig', [
        	'messengers' => $messengers
        ]);
    }

    /**
     * @Route("/message/create", name="messageCreate", methods={"POST"})
     */
    public function create(Request $request)
    {
        /**
         * Inserts message[s] in queue.
         * Returns JSON string with succes or error data.
         */

        $doctrine = $this->getDoctrine();
        $response = MessageCreator::create($request, $doctrine);

        return $this->json($response);
    }
}
