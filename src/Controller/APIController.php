<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    /**
     * @Route("/api/{email}", name="api")
     */
    public function SendEmail(string $email, \Swift_Mailer $mailer): JsonResponse
    {
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo($email)
        ->setBody("Bonjour");

        $mailer->send($message);

        return $this->json([
            'email' => $email
        ]);
    }
}
