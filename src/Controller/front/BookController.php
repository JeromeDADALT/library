<?php


namespace App\Controller\front;

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

        return $this->render('front/book/books.html.twig',
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

        return $this->render('front/book/book.html.twig',
        [
            'book' => $book
        ]);
    }

    /**
     * @Route("/book/search", name="book_search")
     */
    public function searchByResume (BookRepository $bookRepository, Request $request) {
        $word = $request->query->get('word');
        $books = $bookRepository->getByWordInResume($word);

        return $this->render('front/book/search.html.twig',
            [
                'books' => $books,
                'word' => $word
            ]);
    }


}