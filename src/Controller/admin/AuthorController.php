<?php


//je note le chemin de ma classe pour que symfony autoloade sans faire de require ou d'import (App=src)
namespace App\Controller\admin;

//je fais un use de l'entité author pour pouvoir l'utiliser
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//je crée la classe du même nom que mon fichier et je fais appel à AbstractController pour pouvoir utiliser des services de symfony
class AuthorController extends AbstractController
{
    //je crée la route et la méthode en faisant appel à l'autowire de symfony pour instancier le Repository
    /**
     * @Route("/admin/authors/list", name="admin_authors_list")
     */
    public function authors (AuthorRepository $authorRepository) {
        //je récupère les auteurs en utilisant le Repository qui me permet de faire un select
        $authors = $authorRepository->findAll();

        //je retourne le résultat vers une page html twig
        return $this->render('admin/author/authors.html.twig',
            [
                'authors' => $authors
            ]
        );
    }

    //ici je fais de même mais en incluant une wildcard id : dans la route, en paramètre de la méthode et dans le find
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

        //pour insérer, je fais appel à la classe Request pour récupérer les champs
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

        //j'utlise l'EntityManagerInterface pour enregistrer et envoyer la variable $author
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
    //je fais appel au Repository pour accéder à la méthode getByWordInBiography spécialement créée pour cette méthode
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