<?php


namespace App\Controller\front;


use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home (BookRepository $bookRepository, AuthorRepository $authorRepository) {
        //je fais appel à la méthode findBy en passant par un tableau vide, puis en changeant l'ordre,
        //puis limitant à 3 éléments en partant du début
        //$lastBooks = $bookRepository->findBy([], ['id' => 'DESC'], 3, 0);
        $lastBooks = $bookRepository->findAll();
        $lastAuthors = $authorRepository->findBy([], ['id' => 'DESC'], 3, 0);

        // AUTRE METHODE (pas optimisée)
        // je récupére uniquement les deux derniers éléments de mon array de $books (2 derniers livres)
        //$books = $bookRepository->findAll();
        //$lastBooks = array_slice($books, -2, 2);

        return $this->render('front/home.html.twig',
            [
                'books' => $lastBooks,
                'authors' => $lastAuthors
            ]
            );
    }

}