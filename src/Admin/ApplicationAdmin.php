<?php
namespace App\Admin;

use App\Entity\Application;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Класс админки для заявок
 */
final class ApplicationAdmin extends AbstractAdmin
{
    /**
     * Конфигурация формы
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper->add('amount')
            ->add('status', ChoiceType::class, [
                'choices' => \array_flip(Application::$statusesText)
            ])
            ->add('wallet',)
            ->add('type', ChoiceType::class, [
                'choices' => \array_flip(Application::$typesText)
            ]);
    }

    /**
     * Конфигурация списка
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper->addIdentifier('amount')
            ->addIdentifier('statusText')
            ->addIdentifier('wallet')
            ->addIdentifier('typeText');
    }
}
