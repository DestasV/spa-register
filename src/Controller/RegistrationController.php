<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     *
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return JsonResponse
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse([
                'status' => 'error'
            ], 400);
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('user_registration'),
            'method' => 'POST',
            'validation_groups' => [
                'registration',
                'Default'
            ],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse([
                'redirect' => null,
                'status' => 'ok',
            ]);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $response = new JsonResponse([
                'form' => $this->renderView('registration/register.html.twig', [
                    'form' => $form->createView(),
                ])
            ], 400);

            return $response;
        }

        return new JsonResponse([
            'form' => $this->renderView('registration/register.html.twig',
                array(
                    'form' => $form->createView(),
                ))
        ], 200);
    }
}
