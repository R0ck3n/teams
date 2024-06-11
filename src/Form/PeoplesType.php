<?php
namespace App\Form;

use App\Entity\Peoples;
use App\Entity\Teams;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeoplesType extends AbstractType
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $teams = $this->entityManager->getRepository(Teams::class)->findAll();
        $newTeam = new Teams();
        $newTeam -> setName( "Pas d'équipe") ;
        

        $builder
            ->add('firstname', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>'Manu...'
                    ]
            ])
            ->add('lastname', null, [
                'attr' => ['class' => 'form-control',
                'placeholder'=>'LaPointe...'
                ]
            ])
            ->add('teamnumber', null, [
                'attr' => ['class' => 'form-control',
                'placeholder'=>'12...'
                ]
            ])
            ->add('email', null, [
                'attr' => ['class' => 'form-control',
                'placeholder'=>'manu33@carmail.fr'
                ]
            ])
            ->add('teams', EntityType::class, [
                'class' => Teams::class,
                'choices' =>  [$newTeam,...$teams],
                'choice_value' => static function (?Teams $team) {
                    return $team === null ? null : $team->getId();
                },
                'choice_label' => 'name',
                'multiple' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Peoples::class,
        ]);
    }
}
