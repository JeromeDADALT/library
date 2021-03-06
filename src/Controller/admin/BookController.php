<?php


namespace App\Controller\admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class BookController extends AbstractController
{
    /**
     * @Route("/admin/books/list", name="admin_books_list")
     */
    public function books (BookRepository $bookRepository) {
        $books = $bookRepository->findAll();

        return $this->render('admin/book/books.html.twig',
            [
                'books' => $books
            ]
            );
    }

    /**
     * @Route("/admin/book/show/{id}", name="admin_book_show")
     */
    public function book (BookRepository $bookRepository, $id) {
        $book = $bookRepository->find($id);

        return $this->render('admin/book/book.html.twig',
        [
            'book' => $book
        ]);
    }

    /**
     * @Route("/admin/book/insert", name="admin_insert_book")
     */
    public  function insertBook (Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger) {
        //je crée une nouvelle instance de Book et je la mets dans une variable
        $book = new Book();
        //je crée une un formulaire en faisant appel au gabarit de formulaire BookType et je le mets dans un variable
        //je rajoute la variable $book en paramètre de createForm pour relier l'instance avec le formulaire
        $formBook = $this->createForm(BookType::class, $book);
        //handelrequest permet de dire au formulaire de récupérer les données du POST
        $formBook->handleRequest($request);
        //je rajoute une condition pour vérifier si le formulaire a été envoyé et est valide vis à vis des contraintes de la bdd
        if ($formBook->isSubmitted() && $formBook->isValid()) {

            //je déclare une variable qui récupère les données de mon champs 'cover' du formulaire
            $cover = $formBook->get('cover')->getData();
            //je mets une condition if pour faire apparaitre l'image que quand il y a une image upoladée
            if ($cover) {
                $originalFilename = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
                //aprés avoir récupéré le nom du fichier, je m'assure que le nom soit sécurisé
                $safeFilename = $slugger->slug($originalFilename);
                //je rajoute un numéro à chaque nom d'image pour ne pas avoir de doublon
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $cover->guessExtension();
                //je déplace l'image vers le dossier 'img' qui stocke les images
                $cover->move(
                    $this->getParameter('img'),
                    $newFilename
                );
                //je mets à jour le cover de l'entité Book avec ce nouveau nom de fichier
                $book->setCover($newFilename);
            }

            //si c'est ok je persiste et flush mon instance $book
            $entityManager->persist($book);
            $entityManager->flush();
            //j'ajoute un message flash
            $this->addFlash('success', 'Le livre a bien été ajouté');
        }
        //je renvoie le formulaire créé dans le fichier twig tout en créant la vue
        return $this->render('admin/book/insert.html.twig',
            [
                'formBook' => $formBook->createView()
            ]
            );
    }
    /*public function insertBook (
        EntityManagerInterface $entityManager,
        Request $request,
        AuthorRepository $authorRepository
    )
    {
        $book = new Book();

        $title = $request->query->get('title');
        $resume = $request->query->get('resume');
        //je récupère la variable author via le find du Repository (3 est un id)
        $author = $authorRepository->find(3);
        $nbPages = $request->query->get('nbPages');

        $book->setTitle($title);
        $book->setResume($resume);
        $book->setAuthor($author);
        $book->setNbPages($nbPages);

        $entityManager -> persist($book);
        $entityManager -> flush();

        return new Response('Le livre est bien enregistré');
    }*/

    /**
     * @Route("/admin/book/delete/{id}", name="admin_delete_book")
     */
    public function deleteBook (BookRepository $bookRepository, EntityManagerInterface $entityManager, $id ) {
        $book = $bookRepository->find($id);

        $entityManager->remove($book);
        $entityManager->flush();
        $this->addFlash('success', 'Le livre a bien été supprimé');

        //return new Response('Le livre a bien été supprimé');
        return $this->render('admin/book/delete.html.twig');
    }

    /**
     * @Route("/admin/book/update/{id}", name="admin_update_book")
     */
    public  function updateBook (Request $request,
                                 EntityManagerInterface $entityManager,
                                 BookRepository $bookRepository,
                                 $id)
    {
        //je récupère un livre existant via son id
        $book = $bookRepository->find($id);
        //je crée une un formulaire en faisant appel au gabarit de formulaire BookType et je le mets dans un variable
        //je rajoute la variable $book en paramètre de createForm pour relier l'instance avec le formulaire
        $formBook = $this->createForm(BookType::class, $book);
        //handelrequest permet de dire au formulaire de récupérer les données du POST
        $formBook->handleRequest($request);
        //je rajoute une condition pour vérifier si le formulaire a été envoyé et est valide vis à vis des contraintes de la bdd
        if ($formBook->isSubmitted() && $formBook->isValid()) {
            //si c'est ok je persiste et flush mon instance $book
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('success', 'Le livre a bien été mis à jour');
        }
        //je renvoie le formulaire créé dans le fichier twig tout en créant la vue
        return $this->render('admin/book/update.html.twig',
            [
                'formBook' => $formBook->createView()
            ]
        );
    }

    /*public function updateBook (BookRepository $bookRepository, EntityManagerInterface $entityManager, $id) {
        $book = $bookRepository->find($id);

        $book->setTitle('titre encore modifié');

        $entityManager->persist($book);
        $entityManager->flush();

        //return new Response('La modification a bien été effectuée');
        return $this->render('admin/book/update.html.twig');
    }*/

    /**
     * @Route("/admin/book/search", name="admin_book_search")
     */
    public function searchByResume (BookRepository $bookRepository, Request $request) {
        $word = $request->query->get('word');
        $books = $bookRepository->getByWordInResume($word);

        return $this->render('admin/book/search.html.twig',
            [
                'books' => $books,
                'word' => $word
            ]);
    }


}