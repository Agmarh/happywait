<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use CoopTilleuls\UrlSignerBundle\UrlSigner\UrlSignerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class APIController extends AbstractController
{
    public function __construct(UrlSignerInterface $urlSigner, UserRepository $userRepository) {
        $this->urlSigner = $urlSigner;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/send/{email}", name="api_send_email", methods={"GET"})
     */
    public function SendEmail(string $email, \Swift_Mailer $mailer): JsonResponse
    {   
        $user = $this->userRepository->findOneByEmail($email);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('Utilisateur inconnu');
        }

        // Récupération de la Request
        $request = Request::createFromGlobals();
        
        // Création du lien signé
        $url = $this->generateUrl('api_signed_link', ['email' => $email]);        
        $expiration = (new \DateTime('now'))->add(new \DateInterval('PT10M')); // Le lien expirera après 10 minutes

        // Création du mail
        $message = (new \Swift_Message('Authentification via Token'))
        ->setFrom('send@example.com')
        ->setTo($email)
        ->setBody($request->getSchemeAndHttpHost() . $this->urlSigner->sign($url, $expiration));

        $mailer->send($message);

        return $this->json([
            'message' => 'Mail Send !'
        ]);
    }

    /**
     * @Route("/link", name="api_signed_link", defaults={"_signed": true})
     * 
     * _signed : paramètre de UrlSignerBundle pour sécuriser la route
     */
    public function SignedLink(Request $request, JWTEncoderInterface $JWTEncoder): JsonResponse
    {      
        return $this->json([
            'token' => $JWTEncoder->encode([
                'username' => $request->query->get('email'),
                'exp' => time() + 7200 // 2 hour expiration
            ])
        ]);
    }

    /**
     * @Route("/api", name="api_test_token")
     * */
    public function API(): JsonResponse
    {      
        return $this->json([
            'message' => "Merci pour ce test ! Au plaisir !"
        ]);
    }
}
