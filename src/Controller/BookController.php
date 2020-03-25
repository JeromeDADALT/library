<?php


namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/books/list", name="books_list")
     */
    public function books (BookRepository $bookRepository) {
        $books = $bookRepository->findAll();

        return $this->render('books.html.twig',
            [
                'books' => $books
            ]
            );
    }

    /**
     * @Route("/book/show/{id}", name="book_show")
     */
    public function book (BookRepository $bookRepository, $id) {
        $book = $bookRepository->find($id);

        return $this->render('book.html.twig',
        [
            'book' => $book
        ]);
    }

    /**
     * @Route("/book/insert", name="insert_book")
     */
    public function insertBook (EntityManagerInterface $entityManager, Request $request) {
        $book = new Book();

        $title = $request->query->get('title');
        $resume = $request->query->get('resume');
        $author = $request->query->get('author');
        $nbPages = $request->query->get('nbPages');

        $book->setTitle($title);
        $book->setResume($resume);
        $book->setAuthor($author);
        $book->setNbPages($nbPages);

        $entityManager -> persist($book);
        $entityManager -> flush();

        return new Response('Le livre est bien enregistré');
    }

    /**
     * @Route("/book/delete/{id}", name="delete_book")
     */
    public function deleteBook (BookRepository $bookRepository, EntityManagerInterface $entityManager, $id ) {
        $book = $bookRepository->find($id);

        $entityManager->remove($book);
        $entityManager->flush();

        //return new Response('Le livre a bien été supprimé');
        return $this->render('delete.html.twig');
    }

    /**
     * @Route("/book/update/{id}", name="update_book")
     */
    public function updateBook (BookRepository $bookRepository, EntityManagerInterface $entityManager, $id) {
        $book = $bookRepository->find($id);

        $book->setTitle('titre encore modifié');

        $entityManager->persist($book);
        $entityManager->flush();

        //return new Response('La modification a bien été effectuée');
        return $this->render('update.html.twig');
    }

    /**
     * @Route("/book/search", name="book_search")
     */
    public function searchByResume (BookRepository $bookRepository, Request $request) {
        $word = $request->query->get('word');
        $books = $bookRepository->getByWordInResume($word);

        return $this->render('books.html.twig',
            [
                'books' => $books
            ]);
    }


}