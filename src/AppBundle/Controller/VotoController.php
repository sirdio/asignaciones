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

    
    public function getRegistrarVoto($dni, $nombre, $apellido, $trabajoid)
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
        $em->persist($hvoto);
        $em->flush();
        $valor = true;
        return $valor;
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
                    $trabajo = $em->getRepository('AppBundle:trabajo')->findBy(array('encargado' => $encargado ));
                    if (isset($trabajo) && count($trabajo) == 1) {   
                        $trabajo = $em->getRepository('AppBundle:trabajo')->findOneBy(array('encargado' => $encargado ));
                        if ($trabajo->getEscuela()->getCue() == $request->get('password')){
                            $session=$request->getSession();
                            $session->set("dni",$encargado->getDni());
                            $session->set("tipovot",$encargado->getTipovot());
                            $session->set("cue",$trabajo->getEscuela()->getCue());
                            return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',array('enc'=>$encargado));
                        }else{
                            $this->get('session')->getFlashBag()->add('mensaje','La Contraseña que Ingreso No es Correcta, si no recuerda su contraseña consulte con el administrador.');
                            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
                        }                        
                    }elseif (isset($trabajo) && count($trabajo) > 1) {
                        echo "Mayor a 1";
                        echo isset($trabajo);
                        echo count($trabajo);
                        die();                        
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','Error 111: Problema al definir el objeto, consulte con el administrador.');
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
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(array('stand'=>$request->get('cbs')));
                    $standcbs = $trabajo->getStand();
                    $nombcbs = $trabajo->getnombproyecto();
                }else{
                    $standcbs = 0;
                    $nombcbs = 0;
                }
                if ($request->get('css')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(array('stand'=>$request->get('css')));
                    $standcss = $trabajo->getStand();
                    $nombcss = $trabajo->getnombproyecto();
                }else{
                    $standcss = 0;
                    $nombcss = 0;
                }
                if ($request->get('fp')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(array('stand'=>$request->get('fp')));
                    $standfp = $trabajo->getStand();
                    $nombfp = $trabajo->getnombproyecto();
                }else{
                    $standfp = 0;
                    $nombfp = 0;
                }
                if ($request->get('ts')){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(
                        array('stand' => $request->get('ts'),'isActive' => 1, 'estado' => 1));
                    if($trabajo){
                        $standts = $trabajo->getStand();
                        $nombts = $trabajo->getnombproyecto();
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','El número de Stand que desea votar para la categoría Nivel Superiro, no existe o no esta habilitado. En caso de tener dudas consulte con el administrador.');
                        return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',array('enc'=>$encargado));
                    }
                }else{
                    $standts = 0;
                    $nombts = 0;
                }
                $msj = "Gracias por votar.";
                $datosvoto = array ( 'standcbs' => $standcbs, 'nombcbs' => $nomcbs, 'standcss' => $standcss, 'nombcss' => $nomcss, 'standfp' => $standfp, 'nombfp' => $nomfp, 'standts' => $standts, 'nombts' => $nomts);
                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', Array('msj'=>$msj, 'datosvoto'=>$datosvoto));                
            
            }
            $this->get('session')->getFlashBag()->add('mensaje','Ocuurio un problema intete enviar los datos de nuevo, si el error persiste consulte con el administrador.');
            return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',array('enc'=>$encargado));
        }else{
            return $this->render('AppBundle:PesVotos:inciarselecciondetrabajo.html.twig');
        }            
    }

}
/*
                if ($request->get('cbs') == "" or $request->get('cbs') == "0") {
                    $standcbs = 0;
                    $nombcbs = 0;
                }else{
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findOneBy(array('stand' => $request->get('cbs')));
                    if(!$trabajo){
                        $this->get('session')->getFlashBag()->add('mensaje','El número de stand ingresado para el Ciclo Básico no existe, verificar que sea el correcto.');

                        return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',
                            array('enc'=>$encargado, 'stcbs' =>$stcbs ,'stcss' =>$stcss, 'stfp' =>$stfp, 'stts' =>$stts));

                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','por ahora es correcto.');
                        return $this->render('AppBundle:PesVotos:votartrabajos.html.twig',array('enc'=>$encargado));                        
                    }
                }
                $datosvoto = array ( 'standcbs' => $standcbs, 'nombcbs' => $nomcbs, 'standcss' => $standcss, 'nombcss' => $nomcss, 'standfp' => $standfp, 'nombfp' => $nomfp, 'standts' => $standts, 'nombts' => $nomts);
                return $this->render('AppBundle:PesVotos:mensajevoto2.html.twig', 
                    Array('msj'=>$msj, 'datosvoto'=>$datosvoto));


















                $em = $this->getDoctrine()->getManager();
                $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $estudiante = $em->getRepository('AppBundle:Estudiante')->findOneBy(Array("dni"=>$request->get('dni'))); 
                $copetyp = $em->getRepository('AppBundle:Copetyp')->findOneBy(Array("dni"=>$request->get('dni'))); 
                if($directivo and $directivo->getIsActive() == 1){
                    $escuela = $em->getRepository('AppBundle:Escuela')->find($directivo->getIdesc()); 
                    if($escuela->getCue() == $request->get('password')){

                        $session=$request->getSession();
                        $session->set("dni",$directivo->getDni());
                        $session->set("tipovot",$directivo->getTipovot());
                        $session->set("cue",$escuela->getCue());              
                        $em = $this->getDoctrine()->getManager();
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1, 'estado' => 1));
                        if($trabajo){
                            return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));
                        }else{
                            $msj = "Los trabajos no fueron acreditados o la votación no Inicia.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                        }                        
                    }else{
                        $msj = "La Contraseña que ingreso es incorrecta.";
                        return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj)); 
                    }
                    
                }elseif($encargado and $encargado->getIsActive() == 1){
                    $trabajo = $em->getRepository('AppBundle:trabajo')->findBy(array('encargado' => $encargado ));
                    foreach ($trabajo as $trabajo ) {

                        if($trabajo->getEscuela()->getCue() == $request->get('password')){
                            $session=$request->getSession();
                            $session->set("dni",$encargado->getDni());
                            $session->set("tipovot",$encargado->getTipovot());
                            $session->set("cue",$trabajo->getEscuela()->getCue());              
                            $em = $this->getDoctrine()->getManager();
                            $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1, 'estado' => 1));
                            if($trabajo){
                                return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));
                            }else{
                                $msj = "Los trabajos no fueron acreditados o la votación no Inicia.";
                                return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                            }                        
                        }
                    }
                    $msj = "La Contraseña que ingreso es incorrecta.";
                    return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                }elseif($estudiante and $estudiante->getIsActive() == 1){
                    
                   if($estudiante->getTrabajo()->getEscuela()->getCue() == $request->get('password')){
                        $session=$request->getSession();
                        $session->set("dni",$estudiante->getDni());
                        $session->set("tipovot",$estudiante->getTipovot());
                        $session->set("cue",$estudiante->getTrabajo()->getEscuela()->getCue());              
                        $em = $this->getDoctrine()->getManager();
                        $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1, 'estado' => 1));
                        if($trabajo){
                            return $this->render('AppBundle:PesVotos:presentartrabajos.html.twig', array('trabajo'=>$trabajo));
                        }else{
                            $msj = "Los trabajos no fueron acreditados o la votación no Inicia.";
                            return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                        }                        
                   }else{
                        $msj = "La Contraseña que ingreso es incorrecta.";
                        return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                   }
                }elseif($copetyp and $copetyp->getIsActive() == 1){
                    $msj = "Funcionalidad en construccio.";
                    return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj));
                }else{
                    $msj = "El D.N.I. del usuario que intenta acceder,
                    no se encuentra autorizado para votar o no fue acreditado.";
                    return $this->render('AppBundle:PesVotos:mensajevoto.html.twig', array('msj'=>$msj)); 
                }


                */