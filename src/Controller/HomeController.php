<?php


namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/books", name="books")
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
     * @Route("/book/{id}", name="book")
     */
    public function book (BookRepository $bookRepository, $id) {
        $book = $bookRepository->find($id);

        return $this->render('book.html.twig',
        [
            'book' => $book
        ]);
    }

}