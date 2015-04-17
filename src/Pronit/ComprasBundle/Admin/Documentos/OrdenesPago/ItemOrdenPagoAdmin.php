<?php
namespace Pronit\ComprasBundle\Admin\Documentos\OrdenesPago;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 *
 * @author ldelia
 */
class ItemOrdenPagoAdmin extends Admin
{
    protected $parentAssociationMapping = 'documento';
    
     // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
//        $numero = $this->getParentFieldDescription()->getAdmin()->getSubject()->getNumero();
//        dump( $numero );
//        die('test');
        //$ordenPago = $this->getParentFieldDescription()->getAdmin()->getSubject();
        //dump( $ordenPago );
        //die('test');
        //$a=$ordenPago->getProveedorSociedad()->getAcreedor();
        
        $formMapper
            ->add('clasificador')
            ->add('importe')
            ->add('gestionMovimientoAcreedor')
        ;        
        
        //$this->getConfigurationPool()->getContainer()->get('logger')->info('colo ' . $this->getParentFieldDescription()->getAdmin()->getSubject()->getNumero());
        //dump();
        //dump( $formMapper);
              
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('clasificador')
            ->add('importe')
            ->add('gestionMovimientoAcreedor')
        ;
    }
    
    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('PronitComprasBundle:Documentos\ItemOrdenPago:itemordenpago_admin_theme.html.twig')
        );
    }    
    
}


