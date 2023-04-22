<?php

namespace App\Form\TypeExtensions;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomEmailExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [EmailType::class];
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['symbol'] = $options['symbol'] ?? null;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'symbol' => '@'
        ]);
    }


}