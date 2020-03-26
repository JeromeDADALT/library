<?php


namespace App\Controller\front;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("authors/list", name="authors_list")
     */
    public function authors (AuthorRepository $authorRepository) {
        $authors = $authorRepository->findAll();

        return $this->render('front/author/authors.html.twig',
            [
                'authors' => $authors
            ]
        );
    }

    /**
     * @Route("/author/show/{id}", name="author_show")
     */
    public function author (AuthorRepository $authorRepository, $id) {
        $author = $authorRepository->find($id);

        return $this->render('front/author/author.html.twig',
            [
                'author' => $author
            ]);
    }

    /**
     * @Route("author/search", name="author_search")
     */
    public function searchByBiography (AuthorRepository $authorRepository, Request $request) {
        $word = $request->query->get('word');
        $authors = $authorRepository->getByWordInBiography($word);

        return $this->render('front/author/search.html.twig',
            [
                'authors' => $authors,
                'word' => $word
            ]);
    }

}