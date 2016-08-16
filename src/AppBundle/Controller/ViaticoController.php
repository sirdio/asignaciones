<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Directivo;
use AppBundle\Entity\Encargado;
use AppBundle\Entity\Docente;
use AppBundle\Entity\Estudiante;
use AppBundle\Entity\Copetyp;
use AppBundle\Entity\Escuela;
use AppBundle\Entity\Configuracion;
use AppBundle\Entity\Trabajo;
use AppBundle\Entity\Presentacion;
use AppBundle\Entity\Users;
use AppBundle\Entity\Historialvoto;
use AppBundle\Entity\Tipoviatico;
use AppBundle\Entity\Viatico;

class ViaticoController extends Controller
{

    
    /**
     * @Route("/mostrarTipodeviatico", name="ActDesactViatico")
     */
    public function ActDesactViaticoAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $tipoviatico = $em->getRepository('AppBundle:Tipoviatico')->findAll();
            return $this->render('AppBundle:Viaticos:viaticoactdesact.html.twig', array("tipoviatico"=>$tipoviatico));
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }
    
    /**
     * @Route("/mostrarTipoviatico/{id}", name="ViaticoActivarDesactivar")
     */
    public function ViaticoActivarDesactivarAction(Request $request, $id)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $tipoviatico = $em->getRepository('AppBundle:Tipoviatico')->find($id);
            if($tipoviatico->getIsActive() == 0){
                $tipoviatico = $em->getRepository('AppBundle:Tipoviatico')->findOneBy(Array('isActive' => 1));
                $tipoviatico->setIsActive(0);
                $em->persist($tipoviatico);
                $em->flush();
                $tipoviatico = $em->getRepository('AppBundle:Tipoviatico')->find($id);
                $tipoviatico->setIsActive(1);
                $em->persist($tipoviatico);
                $em->flush();                
                $tipoviatico = $em->getRepository('AppBundle:Tipoviatico')->findAll();
                return $this->render('AppBundle:Viaticos:viaticoactdesact.html.twig', array("tipoviatico"=>$tipoviatico));
            }
            $tipoviatico = $em->getRepository('AppBundle:Tipoviatico')->findAll();
                return $this->render('AppBundle:Viaticos:viaticoactdesact.html.twig', array("tipoviatico"=>$tipoviatico));
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }
    
    /**
     * @Route("/registrarentrega/{dni}", name="RegistrarEntrega")
     */
    public function RegistrarEntregaAction(Request $request, $dni)
    {
        $em = $this->getDoctrine()->getManager();
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $fechaactual = date("d-m-Y");        
        $tipoviatico = $em->getRepository('AppBundle:Tipoviatico')->findOneBy(Array('isActive' => 1));
        if($tipoviatico){
            $viatico = $em->getRepository('AppBundle:viatico')->findOneBy(Array('fecha'=> $fechaactual, 'dni' => $dni, 'desc' => $tipoviatico->getDesc() ));
            if($viatico){
                $msj = "Ya fue entregado el/la ".$tipoviatico->getDesc().".";
                return $this->render('AppBundle:Viaticos:viaticomensaje.html.twig', array('msj' =>$msj ));
            }else{
                $viatico = new Viatico();
                $viatico->setDni($dni);
                $viatico->setDesc($tipoviatico->getDesc());
                $viatico->setFecha($fechaactual);
                $em->persist($viatico);
                $em->flush();
                $msj = "Se registro con exito el viático.";
                return $this->render('AppBundle:Viaticos:viaticomensaje.html.twig', array('msj' =>$msj ));            
            }
        }else{
            $msj = "Debe Informar al administrador que Active el tipo de viático.";
            return $this->render('AppBundle:Viaticos:viaticomensaje.html.twig', array('msj' =>$msj ));                            
        }
        

    }    

}