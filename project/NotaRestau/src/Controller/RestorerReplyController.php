<?php

namespace App\Controller;

use App\Entity\RestorerReply;
use App\Form\RestorerReplyType;
use App\Repository\RestorerReplyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/restorer/reply')]
class RestorerReplyController extends AbstractController
{
    #[Route('/', name: 'app_restorer_reply_index', methods: ['GET'])]
    public function index(RestorerReplyRepository $restorerReplyRepository): Response
    {
        return $this->render('restorer_reply/index.html.twig', [
            'restorer_replies' => $restorerReplyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_restorer_reply_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RestorerReplyRepository $restorerReplyRepository): Response
    {
        $restorerReply = new RestorerReply();
        $form = $this->createForm(RestorerReplyType::class, $restorerReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restorerReplyRepository->save($restorerReply, true);

            return $this->redirectToRoute('app_restorer_reply_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restorer_reply/new.html.twig', [
            'restorer_reply' => $restorerReply,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_restorer_reply_show', methods: ['GET'])]
    public function show(RestorerReply $restorerReply): Response
    {
        return $this->render('restorer_reply/show.html.twig', [
            'restorer_reply' => $restorerReply,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_restorer_reply_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RestorerReply $restorerReply, RestorerReplyRepository $restorerReplyRepository): Response
    {
        $form = $this->createForm(RestorerReplyType::class, $restorerReply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restorerReplyRepository->save($restorerReply, true);

            return $this->redirectToRoute('app_restorer_reply_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restorer_reply/edit.html.twig', [
            'restorer_reply' => $restorerReply,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_restorer_reply_delete', methods: ['POST'])]
    public function delete(Request $request, RestorerReply $restorerReply, RestorerReplyRepository $restorerReplyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restorerReply->getId(), $request->request->get('_token'))) {
            $restorerReplyRepository->remove($restorerReply, true);
        }

        return $this->redirectToRoute('app_restorer_reply_index', [], Response::HTTP_SEE_OTHER);
    }
}
