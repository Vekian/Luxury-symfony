<?php

namespace App\Form;

use App\Entity\Candidate;
use App\Entity\JobCategory;
use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\JobCategoryRepository;
use App\Repository\ExperienceRepository;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateType extends AbstractType
{
    private $entityManager;
    private $jobCategoryRepository;
    private $experienceRepository;

    public function __construct(EntityManagerInterface $entityManager, JobCategoryRepository $jobCategoryRepository, ExperienceRepository $experienceRepository)
    {
        $this->entityManager = $entityManager;
        $this->jobCategoryRepository = $jobCategoryRepository;
        $this->experienceRepository = $experienceRepository;

    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $jobCategories = $this->jobCategoryRepository->findAll();
        $experiences = $this->experienceRepository->findAll();
        

        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'required' => false,
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                    'Transgender' => 'Transgender',
                ],
                'expanded' => false, // Définissez-le sur true si vous voulez un groupe de boutons radio au lieu d'une liste déroulante.
                'multiple' => false, // Définissez-le sur true si vous voulez permettre plusieurs sélections.
                'placeholder' => 'Choose an option...', // Optionnel : ajoutez un élément de sélection vide.
            ])
            ->add('country')
            ->add('nationality')
            ->add('current_location')
            ->add('birthdate', BirthdayType::class, [
                'required' => false,
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ]
                ,])
            ->add('birthplace')
            ->add('description')
            ->add('passport_file', FileType::class, [
                'label' => 'Passport',
                'mapped' => false, // Important : indique que ce champ ne doit pas être mappé à une propriété de l'entité.
                'required' => false, // Facultatif : indique si le champ est requis ou non.
            ])
            ->add('cv', FileType::class, [
                'label' => 'CV',
                'mapped' => false, // Important : indique que ce champ ne doit pas être mappé à une propriété de l'entité.
                'required' => false, // Facultatif : indique si le champ est requis ou non.
            ])
            ->add('profil_picture', FileType::class, [
                'label' => 'Photo de profil',
                'mapped' => false, // Important : indique que ce champ ne doit pas être mappé à une propriété de l'entité.
                'required' => false, // Facultatif : indique si le champ est requis ou non.
            ])
            ->add('job_category', ChoiceType::class, [
                'required' => false,
                'choices' => $jobCategories,
                'choice_label' => function (?JobCategory $category): string {
                    return $category ? ucfirst($category->getCategory()) : '';
                },
                'expanded' => false, // Définissez-le sur true si vous voulez un groupe de boutons radio au lieu d'une liste déroulante.
                'multiple' => false, // Définissez-le sur true si vous voulez permettre plusieurs sélections.
                'placeholder' => 'Choose an option...', // Optionnel : ajoutez un élément de sélection vide.
            ])
            ->add('experience', ChoiceType::class, [
                'required' => false,
                'choices' => $experiences,
                'choice_label' => function (?Experience $experience): string {
                    return $experience ? ucfirst($experience->getDuration()) : '';
                },
                'expanded' => false, // Définissez-le sur true si vous voulez un groupe de boutons radio au lieu d'une liste déroulante.
                'multiple' => false, // Définissez-le sur true si vous voulez permettre plusieurs sélections.
                'placeholder' => 'Choose an option...', // Optionnel : ajoutez un élément de sélection vide.
            ])
            ->add('adress')
            ->add('user', RegistrationFormTypeChild::Class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
