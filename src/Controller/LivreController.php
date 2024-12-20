<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/livre')]
final class LivreController extends AbstractController
{
    // 
    #[Route(name: 'app_livre_index', methods: ['GET'])]
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }

    // Ajouter un nouveau livre + couverture
    #[Route('/new', name: 'app_livre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livre->setUser($user);
            $livre->setCouvertureFile($form->get('couvertureFile')->getData());
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    //  Afficher livre
    #[Route('/{id}', name: 'app_livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    // Modifier un livre
    #[Route('/{id}/edit', name: 'app_livre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'le livre a bien été modifié');
            return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    // Supprimer le livre
    #[Route('/{id}', name: 'app_livre_delete', methods: ['POST'])]
    public function delete(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $livre->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_livre_index', [], Response::HTTP_SEE_OTHER);
    }

    // Gérer la recherche
    #[Route('/livre/search', name: 'app_livre_search', methods: ['GET'])]
    public function search(Request $request, LivreRepository $livreRepository): Response
    {
        $query = $request->query->get('q');

        $livres = $livreRepository->searchLivres($query);

        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
            'query' => $query,
        ]);
    }

    // Commenter un livre
    #[Route('/{id}/comment', name: 'app_livre_comment', methods: ['POST'])]
    public function comment(Request $request, Livre $livre, EntityManagerInterface $entityManager, UserInterface $user): Response
    {
        // Récupérer le livre
        $book = $livreRepository->find($id);

        if (!$livre) {
            throw $this->createNotFoundException('Le livre n\'existe pas.');
        }

        // Vérifier si l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');  // Rediriger vers la page de login si non connecté
        }

        // Créer un commentaire vide et associer le livre et l'utilisateur
        $comment = new Comment();
        $comment->setLivre($livre);
        $comment->setUser($this->getUser());
        
        // Créer et traiter le formulaire
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder le commentaire dans la base de données
            $em->persist($comment);
            $em->flush();

            // Rediriger vers la page du livre avec un message de succès
            return $this->redirectToRoute('book_show', ['id' => $id]);
        }

        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->render('book/comment.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }



}
