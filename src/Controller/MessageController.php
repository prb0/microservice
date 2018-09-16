<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Subscriber;
use App\Entity\Messenger;
use App\Entity\Message;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function message()
    {
        /**
         * Generates page with form which creates the messages
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
         * Inserts message[s] in queue
         */
        $recipients     = $request->request->get('recipients');
        $messageText    = $request->request->get('message');
        $entityManager  = $this->getDoctrine()->getManager();

        if ($recipients && $messageText) {
            foreach ($recipients as $id) {
                $subscriberRepository = $this->getDoctrine()->getRepository(Subscriber::class);
                $recipient = $subscriberRepository->find($id);

                $message = new Message($recipient, $messageText);
                $entityManager->persist($message);
            }
            
            $entityManager->flush();
            
            $response = ['success' => true, 'message' => 'Сообщение успешно добавлено'];
        } else {
            $response = ['success' => false, 'message' => 'Введены некорректные данные'];
        }

        return $this->json($response);
    }
}
