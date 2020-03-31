<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('resume', TextType::class, [
                'label' => 'Résumé'
            ])
            ->add('nbPages', TextType::class, [
                'label' => 'Nombre de pages'
            ])
            //pour rattacher les auteurs, je rajoute une champs 'author' qui est une relation vers une entité
            //je spécifie le nom de l'entité et le champs souhaité pour l'input
            ->add('author', EntityType::class,
                [
                    'class' => Author::class,
                    'choice_label' => 'name'
                ]
                )
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
