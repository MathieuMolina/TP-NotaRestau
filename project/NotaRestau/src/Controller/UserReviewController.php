<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserReview;
use App\Form\UserReviewType;
use App\Repository\UserReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/review')]
class UserReviewController extends AbstractController
{
    #[Route('/', name: 'app_user_review_index', methods: ['GET'])]
    public function index(UserReviewRepository $userReviewRepository): Response
    {
        return $this->render('user_review/index.html.twig', [
            'user_reviews' => $userReviewRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_review_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserReviewRepository $userReviewRepository): Response
    {
        $userReview = new UserReview();
        $form = $this->createForm(UserReviewType::class, $userReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userReviewRepository->save($userReview, true);

            return $this->redirectToRoute('app_user_review_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_review/new.html.twig', [
            'user_review' => $userReview,
            'form' => $form,
        ]);
    }

    #[Route('/{user}/reviews', name: 'app_user_review_show', methods: ['GET'])]
    public function show(UserReviewRepository $userReviewRepository, User $user): Response
    {
        $userReviews = $userReviewRepository->findBy(['user_id' => $user->getId()]);
        dump($userReviews);
        return $this->render('user_review/show.html.twig', [
            'user_reviews' => $userReviews
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_review_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserReview $userReview, UserReviewRepository $userReviewRepository): Response
    {
        $form = $this->createForm(UserReviewType::class, $userReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userReviewRepository->save($userReview, true);

            return $this->redirectToRoute('app_user_review_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_review/edit.html.twig', [
            'user_review' => $userReview,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_review_delete', methods: ['POST'])]
    public function delete(Request $request, UserReview $userReview, UserReviewRepository $userReviewRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userReview->getId(), $request->request->get('_token'))) {
            $userReviewRepository->remove($userReview, true);
        }

        return $this->redirectToRoute('app_user_review_index', [], Response::HTTP_SEE_OTHER);
    }


}
