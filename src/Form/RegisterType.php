<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use function Sodium\add;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => new Length(2,2),
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre nom'
                ]
            ])// fin input

            ->add('lastname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => new Length(2,2),
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre prénom'
                ]
            ])// fin input

            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'constraints' => new Length(2,8),
                'attr' => [
                    'placeholder' => 'exemple@mail.com'
                ]
            ]) // fin input

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'label' => 'Votre mort de passe',
                'constraints' => new Length(8,8),
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez votre mot de passe.'],
                'invalid_message' => 'Le mot de passe et le mot de passe de confirmation doivent être identiques.'
            ]) // fin input


            ->add('submit', SubmitType::class,[
                'label' =>"S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
