<?php


namespace App\Controller\admin;

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
     * @Route("/admin/authors/list", name="admin_authors_list")
     */
    public function authors (AuthorRepository $authorRepository) {
        $authors = $authorRepository->findAll();

        return $this->render('admin/author/authors.html.twig',
            [
                'authors' => $authors
            ]
        );
    }

    /**
     * @Route("/admin/author/show/{id}", name="admin_author_show")
     */
    public function author (AuthorRepository $authorRepository, $id) {
        $author = $authorRepository->find($id);

        return $this->render('admin/author/author.html.twig',
            [
                'author' => $author
            ]);
    }

    /**
     * @Route("/admin/author/insert", name="admin_insert_author")
     */
    public function insertAuthor (EntityManagerInterface $entityManager, Request $request) {
        $author = new Author();

        $name = $request->query->get('name');
        $firstName = $request->query->get('firstName');
        $birthDate = $request->query->get('birthDate');
        $deathDate = $request->query->get('deathDate');
        $biography = $request->query->get('biography');

        $author->setName($name);
        $author->setFirstName($firstName);
        $author->setBirthDate($birthDate);
        $author->setDeathDate($deathDate);
        $author->setBiography($biography);

        $entityManager -> persist($author);
        $entityManager -> flush();

        return new Response("L'auteur est bien enregistré");
    }

    /**
     * @Route("/admin/author/delete/{id}", name="admin_delete_author")
     */
    public function deleteAuthor (AuthorRepository $authorRepository, EntityManagerInterface $entityManager, $id ) {
        $author = $authorRepository->find($id);

        $entityManager->remove($author);
        $entityManager->flush();

        return $this->render('admin/author/delete.html.twig');
    }

    /**
     * @Route("/admin/author/update/{id}", name="admin_update_author")
     */
    public function updateAuthor (AuthorRepository $authorRepository, EntityManagerInterface $entityManager, $id) {
        $author = $authorRepository->find($id);

        $author->setName('nom modifié');

        $entityManager->persist($author);
        $entityManager->flush();

        return $this->render('admin/author/update.html.twig');
    }

    /**
     * @Route("/admin/author/search", name="admin_author_search")
     */
    public function searchByBiography (AuthorRepository $authorRepository, Request $request) {
        $word = $request->query->get('word');
        $authors = $authorRepository->getByWordInBiography($word);

        return $this->render('admin/author/search.html.twig',
            [
                'authors' => $authors,
                'word' => $word
            ]);
    }

}