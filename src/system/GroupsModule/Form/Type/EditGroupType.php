<?php

declare(strict_types=1);

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\GroupsModule\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\GroupsModule\Entity\GroupEntity;
use Zikula\GroupsModule\Helper\CommonHelper;
use Zikula\GroupsModule\Validator\Constraints\ValidGroupName;

/**
 * Group editing form type class.
 */
class EditGroupType extends AbstractType
{
    use TranslatorTrait;

    public function __construct(TranslatorInterface $translator)
    {
        $this->setTranslator($translator);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groupsCommon = new CommonHelper($this->translator);
        $typeChoices = array_flip($groupsCommon->gtypeLabels());
        $stateChoices = array_flip($groupsCommon->stateLabels());

        $builder
            ->add('gid', HiddenType::class)
            ->add('name', TextType::class, [
                'label' => $this->trans('Name'),
                'attr' => [
                    'maxlength' => 30
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('gtype', ChoiceType::class, [
                'label' => $this->trans('Type'),
                'choices' => $typeChoices,
                'expanded' => false,
                'multiple' => false
            ])
            ->add('state', ChoiceType::class, [
                'label' => $this->trans('State'),
                'choices' => $stateChoices,
                'expanded' => false,
                'multiple' => false
            ])
            ->add('nbumax', IntegerType::class, [
                'label' => $this->trans('Maximum membership'),
                'attr' => [
                    'maxlength' => 10,
                    'min' => 0
                ],
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => $this->trans('Description'),
            ])
            ->add('save', SubmitType::class, [
                'label' => $this->trans('Save'),
                'icon' => 'fa-check',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            ->add('cancel', SubmitType::class, [
                'label' => $this->trans('Cancel'),
                'icon' => 'fa-times',
                'attr' => [
                    'class' => 'btn btn-default'
                ]
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'zikulagroupsmodule_editgroup';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupEntity::class,
            'constraints' => [
                new ValidGroupName()
            ]
        ]);
    }
}
