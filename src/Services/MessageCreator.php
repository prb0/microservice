<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Registry;
use App\Entity\Subscriber;
use App\Entity\Message;

class MessageCreator
{
    public static function create(Request $request, Registry $doctrine)
    {
        /**
         * Inserts message[s] in queue
         * if user send wrong data - notifying him
         */

        $recipients     = $request->request->get('recipients');
        $messageText    = $request->request->get('message');
        $entityManager  = $doctrine->getManager();

        if (is_array($recipients) && strlen($messageText) > 0) {
            foreach ($recipients as $id) {
                $subscriberRepository = $doctrine->getRepository(Subscriber::class);
                $recipient = $subscriberRepository->find($id);

                $message = new Message($recipient, $messageText);
                $entityManager->persist($message);
            }
            
            $entityManager->flush();
            
            $response = ['success' => true, 'message' => 'Сообщение успешно добавлено в очередь'];
        } else if (strlen($messageText) == 0) {
            $response = ['success' => false, 'message' => 'Введите сообщение'];
        } else if (!is_array($recipients)) {
            $response = ['success' => false, 'message' => 'Выберите получателей'];
        } else {
            $response = ['success' => false, 'message' => 'Введены некорректные данные'];
        }

        return $response;
    }
}
