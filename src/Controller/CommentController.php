namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    //Modifier un commentaire
    #[Route("/comment/{id}/edit", name="comment_edit")]
    public function edit(Comment $comment, Request $request, EntityManagerInterface $em): Response
    {
        // Vérifier si l'utilisateur est un administrateur
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        // Créer le formulaire de modification le commentaire
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les changements dans la base de données
            $em->flush();

            // Rediriger vers la page du livre avec un message de succès
            $this->addFlash('success', 'Commentaire mis à jour avec succès.');
            return $this->redirectToRoute('livre_show', ['id' => $comment->getlivre()->getId()]);
        }

        // Rendu du formulaire de modification
        return $this->render('comment/edit.html.twig', [
            'form' => $form->createView(),
            'comment' => $comment
        ]);
    }

    // Supprimer un commentaire
    #[Route("/comment/{id}/delete", name="comment_delete")]
    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        // Vérifier si l'utilisateur est un administrateur
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        // Récupérer le livre auquel appartient le commentaire
        $book = $comment->getBook();

        // Supprimer le commentaire de la base de données
        $em->remove($comment);
        $em->flush();

        // Message flash de succès et redirection vers la page du livre
        $this->addFlash('success', 'Commentaire supprimé avec succès.');
        return $this->redirectToRoute('livre_show', ['id' => $livre->getId()]);
    }





}