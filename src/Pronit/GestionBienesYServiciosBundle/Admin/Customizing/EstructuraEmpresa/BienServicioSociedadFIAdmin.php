<?php

namespace Pronit\GestionBienesYServiciosBundle\Admin\Customizing\EstructuraEmpresa;

use Pronit\CoreBundle\Model\BienesYServicios\AsociacionBienServicioSociedad;
use Pronit\CoreBundle\Model\BienesYServicios\IServicioBienServicio;
use Pronit\GestionBienesYServiciosBundle\Entity\Customizing\EstructuraEmpresa\BienServicioSociedadFI;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 *
 * @author ldelia
 */
class BienServicioSociedadFIAdmin extends Admin {

    /**
     * @var IServicioBienServicio
     */
    private $servicioBienServicio;

    /**
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param IServicioBienServicio $servicioBienServicio
     */
    public function __construct($code, $class, $baseControllerName, IServicioBienServicio $servicioBienServicio)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->servicioBienServicio = $servicioBienServicio;
    }

    /**
     * {@inheritdoc}
    */
    public function id($entity) {
        if (is_a($entity, 'Pronit\CoreBundle\Model\BienesYServicios\AsociacionBienServicioSociedad')) {
            return null;
        }  else {
            return parent::id($entity);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function create($object)
    {
        $this->prePersist($object);
        foreach ($this->extensions as $extension) {
            $extension->prePersist($this, $object);
        }

        $result = $this->servicioBienServicio->asociarSociedad($object['bienServicio'], $object['sociedadFI'], $object['codigo']);
        
        $this->postPersist($object);
        foreach ($this->extensions as $extension) {
            $extension->postPersist($this, $object);
        }

        $this->createObjectSecurity($object);

        return $result;
    }
    
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('codigo')
                ->add('precioValoracionPromedio')
                ->add('precioValoracionEstandar')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('sociedadFI')
                ->add('bienServicio')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->add('sociedadFI')
                ->addIdentifier('bienServicio')
                ->add('codigo')
                ->add('precioValoracionPromedio')
                ->add('precioValoracionEstandar')
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                    ),
                        )
                )

        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        // Here we set the fields of the ShowMapper variable, $showMapper (but this can be called anything)
        $showMapper
                ->add('sociedadFI')
                ->add('bienServicio')
                ->add('codigo')
                ->add('precioValoracionPromedio')
                ->add('precioValoracionEstandar')
        ;
    }

}
