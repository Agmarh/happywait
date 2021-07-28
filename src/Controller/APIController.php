<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use CoopTilleuls\UrlSignerBundle\UrlSigner\UrlSignerInterface;
use Symfony\Component\HttpFoundation\Request;

class APIController extends AbstractController
{
    public function __construct(UrlSignerInterface $urlSigner) {
        $this->urlSigner = $urlSigner;
    }

    /**
     * @Route("/api/send/{email}", name="api_send_email", methods={"GET"})
     */
    public function SendEmail(string $email, \Swift_Mailer $mailer): JsonResponse
    {
        // Récupération de la Request
        $request = Request::createFromGlobals();
        
        // Création du lien signé
        $url = $this->generateUrl('api_signed_link');        
        $expiration = (new \DateTime('now'))->add(new \DateInterval('PT10M')); // Le lien expirera après 10 minutes

        // Création du mail
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo($email)
        ->setBody($request->getSchemeAndHttpHost() . $this->urlSigner->sign($url, $expiration));

        $mailer->send($message);

        return $this->json([
            'message' => 'Mail Send !'
        ]);
    }

    /**
     * @Route("/api/link", name="api_signed_link", defaults={"_signed": true})
     * 
     * _signed : paramètre de UrlSignerBundle pour sécuriser la route
     */
    public function SignedLink(): JsonResponse
    {
        return $this->json([
            'message' => 'Merci Happywait d\'avoir utilisé mon API !'
        ]);
    }
}
