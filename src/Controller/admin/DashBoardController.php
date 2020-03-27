<?php


namespace App\Controller\admin;


use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashBoardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function adminDashBoard (BookRepository $bookRepository, AuthorRepository $authorRepository) {
        $lastBooks = $bookRepository->findBy([], ['id' => 'DESC'], 3, 0);
        $lastAuthors = $authorRepository->findBy([], ['id' => 'DESC'], 3, 0);

        return $this->render('admin/dashboard.html.twig',
            [
                'books' => $lastBooks,
                'authors' => $lastAuthors
            ]
            );
    }

}