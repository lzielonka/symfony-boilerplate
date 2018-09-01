<?php

namespace AppBundle\Form;

use AppBundle\Database\Propel\Model\Product;
use AppBundle\Services\Product\CurrencyResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class ProductType extends AbstractType
{
    /** @var CurrencyResolver */
    private $currencyResolver;

    /**
     * ProductType constructor.
     * @param CurrencyResolver $currencyResolver
     */
    public function __construct(CurrencyResolver $currencyResolver)
    {
        $this->currencyResolver = $currencyResolver;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank],
            ])
            ->add('description', TextType::class, [
                'constraints' => [new Length(['min' => Product::MINIMUM_DESCRIPTION_LENGTH])],
            ])
            ->add('price', MoneyType::class, [
                'constraints' => [new Range(['min' => 0])],
                'scale'=> 2,
                'currency' => $this->currencyResolver->resolveProductCurrency()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class
        ]);
    }
}
