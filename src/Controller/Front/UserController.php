<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploadService;
use App\Form\AvatarType;

/**
 * @Route("/users", name="front_user_")
 */
class UserController extends AbstractController
{
    // /**
    //  * @Route("/", name="index", methods={"GET"})
    //  */
    // public function index(UserRepository $userRepository): Response
    // {
    //     return $this->render('front/user/index.html.twig', [
    //         'users' => $userRepository->findAll(),
    //     ]);
    // }

    // /**
    //  * @Route("/new", name="new", methods={"GET","POST"})
    //  */
    // public function new(Request $request): Response
    // {
    //     $user = new User();
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($user);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('front_user_index');
    //     }

    //     return $this->render('front/user/new.html.twig', [
    //         'user' => $user,
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}", name="show", methods={"GET"})
    //  */
    // public function show(User $user): Response
    // {
    //     return $this->render('front/user/show.html.twig', [
    //         'user' => $user,
    //     ]);
    // }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, FileUploadService $fileUploadService): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $profileForm = $this->createForm(UserType::class, $user);
        $profileForm->handleRequest($request);

        $avatarForm = $this->createForm(AvatarType::class);
        $avatarForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front_user_edit', [
                'id' => $user->getId(),
            ]);
        }

        if ($avatarForm->isSubmitted() && $avatarForm->isValid()) {
            $file = $avatarForm->get('avatar')->getData();
            $path = $fileUploadService->uploadFile($file,'images/users/');
            $user->setAvatar($path);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front_user_edit', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('front/user/edit.html.twig', [
            // 'controller_name' => 'UserController',
            'user' => $user,
            'profileForm' => $profileForm->createView(),
            'avatarForm' => $avatarForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('front_user_index');
    }
}
