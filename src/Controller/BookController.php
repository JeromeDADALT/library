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
    public function insertBook (EntityManagerInterface $entityManager) {
        $book = new Book();

        $book -> setTitle('nouveau titre');
        $book -> setResume('résumé du livre');
        $book -> setAuthor('auteur du livre ajouté');
        $book -> setNbPages(103);

        $entityManager -> persist($book);
        $entityManager -> flush();

        return new Response('Le livre est bien enregistré'); die;
    }


}