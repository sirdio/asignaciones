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
use AppBundle\Entity\Historicovotoexp;

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
                    $asis = $em->getRepository('AppBundle:Asistencia')->findOneBy(Array("dniasist"=>$encargado->getDni()));
                    if($asis){
                        $msja = "Su asistencia ya se registro Gracias.";
                        return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja));                                                        
                    }else{    
                        $asistencia = new Asistencia();
                        $asistencia->setDniasist($encargado->getDni());
                        date_default_timezone_set("America/Argentina/Buenos_Aires");
                        $fechaactual = date("d-m-Y");                    
                        $asistencia->setFechaasist($fechaactual);
                        $em->persist($asistencia);
                        $em->flush();
                        $msja = "Gracias por asistir, recuerde que al finalizar las presentaciones podrá votar por 2 trabajos.";
                        return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja));                                
                    }
                }elseif($docente){
                    $asis = $em->getRepository('AppBundle:Asistencia')->findOneBy(Array("dniasist"=>$docente->getDni()));
                    if($asis){
                        $msja = "Su asistencia ya se registro Gracias.";
                        return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja));                                                        
                    }else{                    
                        $asistencia = new Asistencia();
                        $asistencia->setDniasist($docente->getDni());
                        date_default_timezone_set("America/Argentina/Buenos_Aires");
                        $fechaactual = date("d-m-Y");                    
                        $asistencia->setFechaasist($fechaactual);
                        $em->persist($asistencia);
                        $em->flush();                    
                        $msja = "Gracias por asistir, recuerde que al finalizar las presentaciones podrá votar por 2 trabajos..";
                        return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja)); 
                    }
                }else{
                    $msja = "Usted puede asistir, pero no esta autorizado para votar las presentaciones.";
                    return $this->render('AppBundle:Presentacion:msjasistencia.html.twig', array('msja'=>$msja));    
                }                                                
            }
            return $this->render('AppBundle:Presentacion:asistenciapresentacion.html.twig');

        }
        return $this->render('AppBundle:Presentacion:asistenciapresentacion.html.twig');
    }   
 
     /**
     * @Route("/verpresentacion/{id}", name="VerPresentacionEXPed")
     */
    public function VerPresentacionEXPedAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $presentacion = $em->getRepository('AppBundle:Presentacion')->find($id);
        if($request->isMethod('POST')){
            if($request->get('dni')!= ""){
                $asist = $em->getRepository('AppBundle:Asistencia')->findOneBy(Array("dniasist"=>$request->get('dni')));
                if($asist){
                    $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array("dni"=>$request->get('dni')));
                    $docente = $em->getRepository('AppBundle:Docente')->findOneBy(Array("dni"=>$request->get('dni')));
                    if($encargado){

                        if($encargado->getCantexpped() == 0){
                            $this->get('session')->getFlashBag()->add('mensaje','Usted ya superó la cantidad de voto disponible.');
                            return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));                            
                        }else{
                            $historicoexp = $em->getRepository('AppBundle:Historicovotoexp')->findOneBy(
                                Array("dni"=>$encargado->getDni(), "presentacion"=>$presentacion));
                            if($historicoexp){
                                $this->get('session')->getFlashBag()->add('mensaje','Usted ya voto por este trabajo.');
                                return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));
                            }else{
                                $restarvoto = $encargado->getCantexpped() - 1;
                                $sumarvoto = $presentacion->getCantvoto() + 1;
                                $encargado->setCantexpped($restarvoto);
                                $em->persist($encargado);
                                $em->flush();
                                $presentacion->setCantvoto($sumarvoto);
                                $em->persist($presentacion);
                                $em->flush();
                                $historicovotoexp = new Historicovotoexp();
                                $historicovotoexp->setDni($encargado->getDni());
                                $historicovotoexp->setNombre($encargado->getNombre());
                                $historicovotoexp->setApellido($encargado->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");                                
                                $historicovotoexp->setFecha($fechaactual);
                                $historicovotoexp->setHora($horaactual);
                                $historicovotoexp->setPresentacion($presentacion);
                                $em->persist($historicovotoexp);
                                $em->flush();                                
                            }    

                        }

                    }elseif($docente){

                        if($docente->getCantexpped() == 0){
                            $this->get('session')->getFlashBag()->add('mensaje','Usted ya superó la cantidad de voto disponible.');
                            return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));                            
                        }else{
                            
                            $historicoexp = $em->getRepository('AppBundle:Historicovotoexp')->findOneBy(
                                Array("dni"=>$docente->getDni(), "presentacion"=>$presentacion));
                            if($historicoexp){
                                $this->get('session')->getFlashBag()->add('mensaje','Usted ya voto por este trabajo.');
                                return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));
                            }else{
                                $restarvoto = $docente->getCantexpped() - 1;
                                $sumarvoto = $presentacion->getCantvoto() + 1;
                                $docente->setCantexpped($restarvoto);
                                $em->persist($docente);
                                $em->flush();
                                $presentacion->setCantvoto($sumarvoto);
                                $em->persist($presentacion);
                                $em->flush();   
                                $historicovotoexp = new Historicovotoexp();
                                $historicovotoexp->setDni($docente->getDni());
                                $historicovotoexp->setNombre($docente->getNombre());
                                $historicovotoexp->setApellido($docente->getApellido());
                                date_default_timezone_set("America/Argentina/Buenos_Aires");
                                $horaactual = date("H:i:s");
                                $fechaactual = date("d-m-Y");                                
                                $historicovotoexp->setFecha($fechaactual);
                                $historicovotoexp->setHora($horaactual);
                                $historicovotoexp->setPresentacion($presentacion);
                                $em->persist($historicovotoexp);
                                $em->flush();                                  
                            }                            

                        }

                    }
                    $msjvotoexpe = "Gracias por votar.";
                    return $this->render('AppBundle:Presentacion:msjvotoexpe.html.twig', array('msjvotoexpe'=>$msjvotoexpe));
                }else{
                    $this->get('session')->getFlashBag()->add('mensaje','Usted no puede votar.');
                    return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));
                }
            }
            $this->get('session')->getFlashBag()->add('mensaje','Debe ingresar el D.N.I.');
            return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));

        }
        return $this->render('AppBundle:Presentacion:verpresentacionexped.html.twig', array('expe'=>$presentacion));
    } 
    
}