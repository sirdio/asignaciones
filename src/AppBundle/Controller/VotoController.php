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
use AppBundle\Entity\Detalleconfiguracion;
use AppBundle\Entity\Trabajo;
use AppBundle\Entity\Presentacion;
use AppBundle\Entity\Users;
use AppBundle\Entity\Historialvoto;

class VotoController extends Controller
{
    /**
     * @Route("/salir", name="LogoutSalir")
     */    
    public function LogoutSalirAction(Request $request)
    {
        $session=$request->getSession();
        $session->clear();
        return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
    }
    
    /**
     * @Route("/iniciarselecciondetrabajo", name="IniciarSelecdeTrabajo")
     */
    public function IniciarSelecTrabajoAction(Request $request)
    {
        if($request->isMethod('POST')){
            if($request->get('dni')!= "" && $request->get('password')!=""){
                $em = $this->getDoctrine()->getManager();
                $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneBy(Array("dni"=>$request->get('dni')));
                if($directivo and $directivo->getIsActive() == 1){
                    $this->get('session')->getFlashBag()->add('mensaje','El directivo debe decidir junto con el docente responsable de uno de los trabajos que representa a su establecimiento y seleccionar en forma conjunta los trabajos que van a votar y luego el docente se encarga de realizar el voto.');
                    return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
                }elseif($encargado and $encargado->getIsActive() == 1){
                    $trabajo = $em->getRepository('AppBundle:trabajo')->findOneBy(array('encargado' => $encargado ));
                    if ($trabajo->getEscuela()->getCue() == $request->get('password')){
                        if ($encargado->getConfiguracion()->getCtvcbs()==1 or $encargado->getConfiguracion()->getCtvcss()==1 or $encargado->getConfiguracion()->getCtvfp()==1 or $encargado->getConfiguracion()->getCtvts()==1){
                            if (isset($trabajo) && count($trabajo) == 1) {   
                                $trabajo = $em->getRepository('AppBundle:trabajo')->findOneBy(array('encargado' => $encargado ));
                                    $session=$request->getSession();
                                    $session->set("dni",$encargado->getDni());
                                    $session->set("tipovot",$encargado->getTipovot());
                                    $session->set("cue",$trabajo->getEscuela()->getCue());
                                    $ciclo = "cbs";
                                    $trabcbs = $this->getRecuperartrabajos($ciclo);
                                    $ciclo = "css";
                                    $trabcss = $this->getRecuperartrabajos($ciclo);
                                    $ciclo = "fp";
                                    $trabfp = $this->getRecuperartrabajos($ciclo);
                                    $ciclo = "ts";
                                    $trabts = $this->getRecuperartrabajos($ciclo);
                                    $dnienc = $encargado->getDni();
                                    return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',
                                        array('enc'=>$encargado,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'dnienc'=>$dnienc));                       
                            }else{
                                $this->get('session')->getFlashBag()->add('mensaje','Error 111: Problema al definir el objeto, consulte con el administrador.');
                                return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
                            } 
                        }else{
                            $this->get('session')->getFlashBag()->add('mensaje','Supero la cantidad de votos disponibles.');
                            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
                        }
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','La Contraseña que Ingreso No es Correcta, si no recuerda su contraseña consulte con el administrador.');
                        return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
                    }                         
                }elseif($estudiante and $estudiante->getIsActive() == 1){
                    
                    if ($estudiante->getTrabajo()->getEscuela()->getCue() == $request->get('password')){
                        if ($estudiante->getTrabajo()->getConfiguracion()->getCtvcbs()==1 or $estudiante->getTrabajo()->getConfiguracion()->getCtvcss()==1 or $estudiante->getTrabajo()->getConfiguracion()->getCtvfp()==1 or $estudiante->getTrabajo()->getConfiguracion()->getCtvts()==1) {
                                $session=$request->getSession();
                                $session->set("dni",$estudiante->getDni());
                                $session->set("tipovot",$estudiante->getTipovot());
                                $session->set("cue",$estudiante->getTrabajo()->getEscuela()->getCue());
                                $ciclo = "cbs";
                                $trabcbs = $this->getRecuperartrabajos($ciclo);
                                $ciclo = "css";
                                $trabcss = $this->getRecuperartrabajos($ciclo);
                                $ciclo = "fp";
                                $trabfp = $this->getRecuperartrabajos($ciclo);
                                $ciclo = "ts";
                                $trabts = $this->getRecuperartrabajos($ciclo);
                                $idtrabajo = $estudiante->getTrabajo()->getId();
                                return $this->render('AppBundle:PesVotos:votartrabajoalumno.html.twig',
                                    array('alu'=>$estudiante,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'idtrabajo'=>$idtrabajo));
                        }else{
                            $this->get('session')->getFlashBag()->add('mensaje','Supero la cantidad de votos disponibles.');
                            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
                        }                        
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','La Contraseña que Ingreso No es Correcta, si no recuerda su contraseña consulte con el administrador.');
                        return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
                    }                    
                }else{
                $this->get('session')->getFlashBag()->add('mensaje','El usario que intenta ingresar no fue acreditado o no esta cargado en el sistema, consulte con el administrador.');
                return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');                     
                }
            }else{
                $this->get('session')->getFlashBag()->add('mensaje','Debe Ingresar el D.N.I. y la Contraseña para Ingresar.');
                return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');    
            }    
        }
        return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
    }

    public function getRecuperartrabajos($ciclo)
    {
        $em = $this->getDoctrine()->getManager();
        $trabajos = $em->getRepository('AppBundle:Trabajo')->findBy(array('niveltrab'=>$ciclo,'isActive'=>1, 'estado'=>1));
         return $trabajos;
    }

    public function getRegVoto($dni, $nombre, $apellido, $trabajoid, $tipovotante)
    {
        $em = $this->getDoctrine()->getManager();
        $trabajovoto = $em->getRepository('AppBundle:Trabajo')->find($trabajoid);       
        $hvoto = new Historialvoto();
        $hvoto->setDni($dni);
        $hvoto->setNembre($nombre);
        $hvoto->setApellido($apellido);
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $horaactual = date("H:i:s");
        $fechaactual = date("d-m-Y");
        $hvoto->setFecha($fechaactual);
        $hvoto->setHora($horaactual);
        $hvoto->setTrabajo($trabajovoto);
        $hvoto->setTipovoto($tipovotante);
        $em->persist($hvoto);
        $em->flush();
        $valor = true;
        return;
    }

    /**
     * @Route("/guardarvotos", name="VotarTrabajos")
     */
    public function VotarTrabajosAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("dni")){
            $em = $this->getDoctrine()->getManager();
            $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(array('dni' => $session->get('dni')));
            if($request->isMethod('POST')){                
                if ($request->get('cbs')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(
                        array('stand'=>$request->get('cbs'),'isActive' => 1, 'estado' => 1));
                    if($trabajo){
                        if($encargado->getConfiguracion()->getCtvcbs() == 1){                            
                            $standcbs = $trabajo->getStand();
                            $nombcbs = $trabajo->getnombproyecto();
                            $encargado->getConfiguracion()->setCtvcbs(0);
                            
                            $dni = $encargado->getDni();
                            $nombre = $encargado->getNombre();
                            $apellido = $encargado->getApellido();
                            $trabajoid = $trabajo->getId();
                            $tipovotante =$encargado->getTipovot();
                            $this->getRegVoto($dni, $nombre, $apellido, $trabajoid, $tipovotante);
                        }else{
                            $msj ="Supero la cantidad de votos disponibles para Ciclo Básico.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig');
                        }
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','El número de Stand que desea votar para la categoría Ciclo Básico, no existe o no esta habilitado. En caso de tener dudas consulte con el administrador.');
                            $ciclo = "cbs";
                            $trabcbs = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "css";
                            $trabcss = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "fp";
                            $trabfp = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "ts";
                            $trabts = $this->getRecuperartrabajos($ciclo);
                            $dnienc = $encargado->getDni();
                            return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',
                             array('enc'=>$encargado,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'dnienc'=>$dnienc)); 
                    }
                }else{
                    $standcbs = 0;
                    $nombcbs = 0;
                }
                if ($request->get('css')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(
                        array('stand'=>$request->get('css'),'isActive' => 1, 'estado' => 1));
                    if($trabajo){
                        if($encargado->getConfiguracion()->getCtvcss() == 1){                            
                            $standcss = $trabajo->getStand();
                            $nombcss = $trabajo->getnombproyecto();
                            $encargado->getConfiguracion()->setCtvcss(0);
                            
                            $dni = $encargado->getDni();
                            $nombre = $encargado->getNombre();
                            $apellido = $encargado->getApellido();
                            $trabajoid = $trabajo->getId();
                            $tipovotante =$encargado->getTipovot();
                            $this->getRegVoto($dni, $nombre, $apellido, $trabajoid, $tipovotante);
                        }else{
                            $msj ="Supero la cantidad de votos disponibles para Ciclo Superior.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig');
                        }
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','El número de Stand que desea votar para la categoría Ciclo Superior, no existe o no esta habilitado. En caso de tener dudas consulte con el administrador.');
                            $ciclo = "cbs";
                            $trabcbs = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "css";
                            $trabcss = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "fp";
                            $trabfp = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "ts";
                            $trabts = $this->getRecuperartrabajos($ciclo);
                            $dnienc = $encargado->getDni();
                            return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',
                             array('enc'=>$encargado,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'dnienc'=>$dnienc)); 
                    }                    
                }else{
                    $standcss = 0;
                    $nombcss = 0;
                }
                if ($request->get('fp')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(
                        array('stand'=>$request->get('fp'),'isActive' => 1, 'estado' => 1));
                    if($trabajo){
                        if($encargado->getConfiguracion()->getCtvfp() == 1){                            
                            $standfp = $trabajo->getStand();
                            $nombfp = $trabajo->getnombproyecto();
                            $encargado->getConfiguracion()->setCtvfp(0);
                            
                            $dni = $encargado->getDni();
                            $nombre = $encargado->getNombre();
                            $apellido = $encargado->getApellido();
                            $trabajoid = $trabajo->getId();
                            $tipovotante =$encargado->getTipovot();
                            $this->getRegVoto($dni, $nombre, $apellido, $trabajoid, $tipovotante);
                        }else{
                            $msj ="Supero la cantidad de votos disponibles para Formación Profesional.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig');
                        }
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','El número de Stand que desea votar para la categoría Formación Profesional, no existe o no esta habilitado. En caso de tener dudas consulte con el administrador.');
                            $ciclo = "cbs";
                            $trabcbs = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "css";
                            $trabcss = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "fp";
                            $trabfp = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "ts";
                            $trabts = $this->getRecuperartrabajos($ciclo);
                            $dnienc = $encargado->getDni();
                            return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',
                             array('enc'=>$encargado,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'dnienc'=>$dnienc)); 
                    }  
                }else{
                    $standfp = 0;
                    $nombfp = 0;
                }
                if ($request->get('ts')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(
                        array('stand' => $request->get('ts'),'isActive' => 1, 'estado' => 1));
                    if($trabajo){
                        if($encargado->getConfiguracion()->getCtvts() == 1){                            
                            $standts = $trabajo->getStand();
                            $nombts = $trabajo->getnombproyecto();
                            $encargado->getConfiguracion()->setCtvts(0);
                            
                            $dni = $encargado->getDni();
                            $nombre = $encargado->getNombre();
                            $apellido = $encargado->getApellido();
                            $trabajoid = $trabajo->getId();
                            $tipovotante =$encargado->getTipovot();
                            $this->getRegVoto($dni, $nombre, $apellido, $trabajoid, $tipovotante);
                        }else{
                            $msj ="Supero la cantidad de votos disponibles para el Nivel Superior.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig');
                        }
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','El número de Stand que desea votar para la categoría Nivel Superiro, no existe o no esta habilitado. En caso de tener dudas consulte con el administrador.');
                            $ciclo = "cbs";
                            $trabcbs = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "css";
                            $trabcss = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "fp";
                            $trabfp = $this->getRecuperartrabajos($ciclo);
                            $ciclo = "ts";
                            $trabts = $this->getRecuperartrabajos($ciclo);
                            $dnienc = $encargado->getDni();
                            return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',
                             array('enc'=>$encargado,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'dnienc'=>$dnienc)); 
                    }
                }else{
                    $standts = 0;
                    $nombts = 0;
                }
                $em->persist($encargado);
                $em->flush();
                $msj = "Gracias por votar.";
                $datosvoto = array ( 'standcbs' => $standcbs, 'nombcbs' => $nombcbs, 'standcss' => $standcss, 'nombcss' => $nombcss, 'standfp' => $standfp, 'nombfp' => $nombfp, 'standts' => $standts, 'nombts' => $nombts);
                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', Array('msj'=>$msj, 'datosvoto'=>$datosvoto));                
            }
            $this->get('session')->getFlashBag()->add('mensaje','Ocuurio un problema intete enviar los datos de nuevo, si el error persiste consulte con el administrador.');
            $ciclo = "cbs";
            $trabcbs = $this->getRecuperartrabajos($ciclo);
            $ciclo = "css";
            $trabcss = $this->getRecuperartrabajos($ciclo);
            $ciclo = "fp";
            $trabfp = $this->getRecuperartrabajos($ciclo);
            $ciclo = "ts";
            $trabts = $this->getRecuperartrabajos($ciclo);
            $dnienc = $encargado->getDni();
            return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',
                             array('enc'=>$encargado,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'dnienc'=>$dnienc)); 
        }else{
            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
        }            
    }

    /**
     * @Route("/guardarvotoalumno", name="VotarTrabajoAlumno")
     */
    public function VotarTrabajoAlumnoAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("dni")){
            $em = $this->getDoctrine()->getManager();
            $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneBy(array('dni' => $session->get('dni')));
            $ciclo = "cbs";
            $trabcbs = $this->getRecuperartrabajos($ciclo);
            $ciclo = "css";
            $trabcss = $this->getRecuperartrabajos($ciclo);
            $ciclo = "fp";
            $trabfp = $this->getRecuperartrabajos($ciclo);
            $ciclo = "ts";
            $trabts = $this->getRecuperartrabajos($ciclo);
            $idtrabajo = $estudiante->getTrabajo()->getId();            
            if($request->isMethod('POST')){  
                $dni = $estudiante->getDni();
                $nombre = $estudiante->getNombre();
                $apellido = $estudiante->getApellido();
                $tipovotante =$estudiante->getTipovot();
                if ($request->get('cbs')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(
                        array('stand'=>$request->get('cbs'),'isActive' => 1, 'estado' => 1));                    
                    if($trabajo){
                        if($estudiante->getTrabajo()->getConfiguracion()->getCtvcbs() == 1){                            
                            $standcbs = $trabajo->getStand();
                            $nombcbs = $trabajo->getnombproyecto();
                            $estudiante->getTrabajo()->getConfiguracion()->setCtvcbs(0);

                            $trabajoid = $trabajo->getId();
                            $this->getRegVoto($dni, $nombre, $apellido, $trabajoid, $tipovotante);
                        }else{
                            $msj ="Supero la cantidad de votos disponibles para Ciclo Básico.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig');
                        }
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','El número de Stand que desea votar para la categoría Ciclo Básico, no existe o no esta habilitado. En caso de tener dudas consulte con el administrador.');
                        return $this->render('AppBundle:PesVotos:VotarTrabajoAlumno.html.twig',
                            array('alu'=>$estudiante,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'idtrabajo'=>$idtrabajo));
                    }
                }else{
                    $standcbs = 0;
                    $nombcbs = 0;
                }
                if ($request->get('css')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(
                        array('stand'=>$request->get('css'),'isActive' => 1, 'estado' => 1));
                    if($trabajo){
                        if($estudiante->getTrabajo()->getConfiguracion()->getCtvcss() == 1){                            
                            $standcss = $trabajo->getStand();
                            $nombcss = $trabajo->getnombproyecto();
                            $estudiante->getTrabajo()->getConfiguracion()->setCtvcss(0);
                            
                            $trabajoid = $trabajo->getId();
                            $this->getRegVoto($dni, $nombre, $apellido, $trabajoid, $tipovotante);
                        }else{
                            $msj ="Supero la cantidad de votos disponibles para Ciclo Superior.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig');
                        }
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','El número de Stand que desea votar para la categoría Ciclo Superior, no existe o no esta habilitado. En caso de tener dudas consulte con el administrador.');
                        return $this->render('AppBundle:PesVotos:VotarTrabajoAlumno.html.twig',
                            array('alu'=>$estudiante,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'idtrabajo'=>$idtrabajo));
                    }                    
                }else{
                    $standcss = 0;
                    $nombcss = 0;
                }
                if ($request->get('fp')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(
                        array('stand'=>$request->get('fp'),'isActive' => 1, 'estado' => 1));
                    if($trabajo){
                        if($estudiante->getTrabajo()->getConfiguracion()->getCtvfp() == 1){                            
                            $standfp = $trabajo->getStand();
                            $nombfp = $trabajo->getnombproyecto();
                            $estudiante->getTrabajo()->getConfiguracion()->setCtvfp(0);
                            
                            $trabajoid = $trabajo->getId();
                            $this->getRegVoto($dni, $nombre, $apellido, $trabajoid, $tipovotante);
                        }else{
                            $msj ="Supero la cantidad de votos disponibles para Formación Profesional.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig');
                        }
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','El número de Stand que desea votar para la categoría Formación Profesional, no existe o no esta habilitado. En caso de tener dudas consulte con el administrador.');
                        return $this->render('AppBundle:PesVotos:VotarTrabajoAlumno.html.twig',
                            array('alu'=>$estudiante,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'idtrabajo'=>$idtrabajo));
                    }  
                }else{
                    $standfp = 0;
                    $nombfp = 0;
                }
                if ($request->get('ts')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(
                        array('stand' => $request->get('ts'),'isActive' => 1, 'estado' => 1));
                    if($trabajo){
                        if($estudiante->getTrabajo()->getConfiguracion()->getCtvts() == 1){                            
                            $standts = $trabajo->getStand();
                            $nombts = $trabajo->getnombproyecto();
                            $estudiante->getTrabajo()->getConfiguracion()->setCtvts(0);
                            
                            $trabajoid = $trabajo->getId();
                            $this->getRegVoto($dni, $nombre, $apellido, $trabajoid, $tipovotante);
                        }else{
                            $msj ="Supero la cantidad de votos disponibles para el Nivel Superior.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig');
                        }
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','El número de Stand que desea votar para la categoría Nivel Superiro, no existe o no esta habilitado. En caso de tener dudas consulte con el administrador.');
                        return $this->render('AppBundle:PesVotos:VotarTrabajoAlumno.html.twig',
                            array('alu'=>$estudiante,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'idtrabajo'=>$idtrabajo));
                    }
                }else{
                    $standts = 0;
                    $nombts = 0;
                }
                $em->persist($estudiante);
                $em->flush();
                $msj = "Gracias por votar.";
                $datosvoto = array ( 'standcbs' => $standcbs, 'nombcbs' => $nombcbs, 'standcss' => $standcss, 'nombcss' => $nombcss, 'standfp' => $standfp, 'nombfp' => $nombfp, 'standts' => $standts, 'nombts' => $nombts);
                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', Array('msj'=>$msj, 'datosvoto'=>$datosvoto));                
            }
            $this->get('session')->getFlashBag()->add('mensaje','Ocuurio un problema intete enviar los datos de nuevo, si el error persiste consulte con el administrador.');

            return $this->render('AppBundle:PesVotos:VotarTrabajoAlumno.html.twig',
                array('alu'=>$estudiante,'trabcbs'=>$trabcbs,'trabcss'=>$trabcss,'trabfp'=>$trabfp,'trabts'=>$trabts, 'idtrabajo'=>$idtrabajo));
        }else{
            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
        }            
    }    
}
