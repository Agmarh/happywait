<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use CoopTilleuls\UrlSignerBundle\UrlSigner\UrlSignerInterface;

class APIController extends AbstractController
{
    public function __construct(UrlSignerInterface $urlSigner) {
        $this->urlSigner = $urlSigner;
    }

    /**
     * @Route("/api/send/{email}", name="api_send_email")
     */
    public function SendEmail(string $email, \Swift_Mailer $mailer): JsonResponse
    {
        $url = $this->generateUrl('api_link');
        // Le lien expirera après 10 minutes
        $expiration = (new \DateTime('now'))->add(new \DateInterval('PT10M'));

        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo($email)
        ->setBody($this->urlSigner->sign($url, $expiration));

        $mailer->send($message);

        return $this->json([
            'message' => 'Mail Send !'
        ]);
    }

    /**
     * @Route("/api/link", name="api_signed_link", defaults={"_signed": true})
     */
    public function SignedLink(): JsonResponse
    {
        return $this->json([
            'message' => 'Merci d\'avoir utilisé mon API !'
        ]);
    }
}
