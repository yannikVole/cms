<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email")
            ->add("plainPassword", PasswordType::class,[
                "mapped" => false,
                "constraints" => [
                    new NotBlank([
                        "message" => "please enter a password"
                    ]),
                    new Length([
                        "min" => 6,
                        "minMessage" => "Your password should be at least {{limit}} chars long",
                        "max" => 4096
                    ]),
                ],
            ])
            ->add("save", SubmitType::class);
     }

     public function configureOptions(OptionsResolver $resolver)
     {
         $resolver->setDefaults([
             "data_class" => User::class
         ]);
     }
}
