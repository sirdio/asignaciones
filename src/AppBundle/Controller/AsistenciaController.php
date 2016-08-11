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
use AppBundle\Entity\Asistencia;

class AsistenciaController extends Controller
{

    
    /**
     * @Route("/asistenciapresentacion", name="AsistenciaPres")
     */
    public function AsistenciaPresAction(Request $request)
    {
        if($request->isMethod('POST')){
            if($request->get('dni')!= ""){
                $em = $this->getDoctrine()->getManager();
                $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array("dni"=>$request->get('dni')));
                $docente = $em->getRepository('AppBundle:Docente')->findOneBy(Array("dni"=>$request->get('dni')));
                if($encargado){
                    $asistencia = new Asistencia();
                    $asistencia->setDniasist($encargado->getDni());
                    date_default_timezone_set("America/Argentina/Buenos_Aires");
                    $fechaactual = date("d-m-Y");                    
                    $asistencia->setFechaasist($fechaactual);
                    $em->persist($asistencia);
                    $em->flush();
                    $msja = "Gracias por asistir, recuerde que al finalizar las presentación podra votar por 2 trabajos.";
                    return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja));                                
                
                }elseif($docente){
                    $asistencia = new Asistencia();
                    $asistencia->setDniasist($docente->getDni());
                    date_default_timezone_set("America/Argentina/Buenos_Aires");
                    $fechaactual = date("d-m-Y");                    
                    $asistencia->setFechaasist($fechaactual);
                    $em->persist($asistencia);
                    $em->flush();                    
                    $msja = "Gracias por asistir, recuerde que al finalizar las presentación podra votar por 2 trabajos..";
                    return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja)); 
                    
                }else{
                    $msja = "Usted puede asistir, pero no esta autorizado para votar las presentaciones.";
                    return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja));    
                }                                                
            }
            return $this->render('AppBundle:Presentacion:asistenciapresentacion.html.twig');

        }
        return $this->render('AppBundle:Presentacion:asistenciapresentacion.html.twig');
    }   
 
 
    
}