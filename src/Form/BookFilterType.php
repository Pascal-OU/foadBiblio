namespace App\Controller;

use App\Form\BookFilterType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book/filter", name="book_filter")
     */
    public function filter(Request $request, BookRepository $bookRepository): Response
    {
        // Création du formulaire de filtrage
        $form = $this->createForm(BookFilterType::class);

        // Traitement du formulaire lors de la soumission
        $form->handleRequest($request);

        // Initialisation de la liste des livres
        $books = [];

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de la catégorie choisie par l'utilisateur
            $category = $form->get('category')->getData();

            // Si une catégorie a été sélectionnée, on filtre les livres par cette catégorie
            if ($category) {
                $books = $bookRepository->findBooksByCategory($category);
            }
        }

        // Rendu de la vue avec le formulaire et la liste des livres filtrés
        return $this->render('book/filter.html.twig', [
            'form' => $form->createView(),
            'books' => $books,
        ]);
    }
}