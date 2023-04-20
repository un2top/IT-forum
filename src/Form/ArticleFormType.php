<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ArticleFormType extends AbstractType
{

    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType:: class, [
                'label' => 'Название статьи',
                'constraints'=>[
                    new Length([
                        'min' => 3,
                        'minMessage' => 'название стетьи должено быть длиной не меньше 3-х символов',
                    ]),
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Описание статьи',
                'attr' => ['rows' => '3'],
                'constraints'=>[
                    new Length([
                        'max' => 100,
                        'minMessage' => 'описание стетьи должено быть длиной не больше 100 символов',
                    ]),
                ]
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Содержимое статьи',
                'attr' => ['rows' => '10']
            ])
            ->add('publishedAt', null, [
                'widget' => 'single_text',
                'label' => 'Дата публикации статьи'
            ])
            ->add('keywords', TextType:: class, [
                'label' => 'Ключевые слова статьи',
                'required'=>false,
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return sprintf('%s', $user->getFirstName());
                },
                'placeholder'=>'Выберите автора статьи',
                'choices'=>$this->repository->findAllSortedByNAme(),
                'label' => 'Автор статьи',
                'invalid_message'=>'Такого автора не существует',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
