<?php

namespace App\Controller;

use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="user_profile")
     *
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profile(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('user_profile'),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPlainPassword()) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse([
                'redirect' => null,
                'status' => 'ok'
            ], 200);
        }

        if ($request->isXmlHttpRequest() && $form->isSubmitted() && !$form->isValid()) {
            $response = new JsonResponse([
                'form' => $this->renderView('profile/profile.html.twig', [
                    'form' => $form->createView(),
                ])
            ], 400);

            return $response;
        }

        return $this->render('profile/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
