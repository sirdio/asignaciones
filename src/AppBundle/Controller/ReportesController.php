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

class ReportesController extends Controller
{

    
    /**
     * @Route("/seleccionarnivel", name="SeleccionarNivel")
     */
    public function SeleccionarNivelAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array("niveltrab"=>$_POST['nivel']),Array("cantvoto"=>'DESC'));
                return $this->render('AppBundle:Reportes:resultadosvotos.html.twig', array("trabajo"=>$trabajo));
            }
            return $this->render('AppBundle:Reportes:seleccionarnivel.html.twig');
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }
    
    /**
     * @Route("/seleccionarestablecimiento", name="SeleccionarEst")
     */
    public function SeleccionarEstAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $escuela = $em->getRepository('AppBundle:Escuela')->find($_POST['establecimiento']);
                $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array("escuela"=>$escuela));
                $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array("idesc"=>$escuela->getId()));
                $estudiante = $em->getRepository('AppBundle:Estudiante')->findAll();
                return $this->render('AppBundle:Reportes:resultadosinscripcion.html.twig', 
                array("escuela"=>$escuela, "trabajo"=>$trabajo, "directivo"=>$directivo, "estudiante"=>$estudiante));
            }
            $em=$this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder('AppBundle:Escuela')
                        ->select('e')
                        ->from('AppBundle:Escuela','e')
                        ->orderBy("e.cue","asc")
                        ->getQuery();
            $escuela=$em->getArrayResult();
            //$escuela = $em->getRepository('AppBundle:Escuela')->findBy(Array("nombesc"=>$_POST['establecimiento']),Array("cantvoto"=>'DESC'));
            return $this->render('AppBundle:Reportes:seleccionarescuela.html.twig', array("escuela"=>$escuela));
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }
    
    /**
     * @Route("/mostrarhistorialvotos", name="MostrarHistorialTrab")
     */
    public function MostrarHistorialTrabAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
                $em = $this->getDoctrine()->getManager();
                $historial = $em->getRepository('AppBundle:Historialvoto')->findAll();
                if($historial){
                    return $this->render('AppBundle:Reportes:historialvotos.html.twig', 
                    array("historial"=>$historial));
                }
                $msj = "No existen Votos registrados.";              
                return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj)); 
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }
    
    /**
     * @Route("/mostrarhistorialvotosexp", name="MostrarHistorialPress")
     */
    public function MostrarHistorialPressAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
                $em = $this->getDoctrine()->getManager();
                $historial = $em->getRepository('AppBundle:Historicovotoexp')->findAll();
                if($historial){
                    return $this->render('AppBundle:Reportes:historialvotosexp.html.twig', 
                    array("historial"=>$historial));
                }
                $msj = "No existen Votos registrados.";              
                return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj)); 
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    } 
    
    /**
     * @Route("/mostrarasistemcia", name="VerAsistencia")
     */
    public function VerAsistenciaAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
                $em = $this->getDoctrine()->getManager();
                $asistencia = $em->getRepository('AppBundle:Asistencia')->findAll();
                if($asistencia){
                    $i = 1;
                    foreach($asistencia as $linea){
                        $encargado = $em->getRepository('AppBundle:Encargado')->findOneBy(Array('dni'=>$linea->getDniasist()));
                        $docente = $em->getRepository('AppBundle:Docente')->findOneBy(Array('dni'=>$linea->getDniasist()));
                        if($encargado){
                            $listaasist[$i] = array( 1 =>$linea->getId(), 2 => $encargado->getDni(), 3 => $encargado->getApellido(), 4 => $encargado->getNombre(), 5 => $linea->getFechaasist());

                        }elseif($docente){
                            $listaasist[$i] = array( 1 => $linea->getId(), 2 => $docente->getDni(), 3 =>$docente->getApellido(), 4 => $docente->getNombre(), 5 => $linea->getFechaasist());
                         
                        }
                        $i++;
                    }
                    $cont = count($listaasist);
                    //die();
                    return $this->render('AppBundle:Reportes:asistencia.html.twig', 
                    array("listaasist"=>$listaasist, 'cont'=>$cont));
                }
                $msj = "No existe registro de asistencia.";              
                return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj)); 
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    } 
    
    /**
     * @Route("/mostrarresultados", name="MostrarResultados")
     */
    public function MostrarResultadosAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
                $em = $this->getDoctrine()->getManager();
                $presresultado = $em->getRepository('AppBundle:Presentacion')->findBy(Array("nivelpres"=>'expped'), Array("cantvoto"=>'DESC'));
                return $this->render('AppBundle:Reportes:resultadosvotosexp.html.twig', array("presresultado"=>$presresultado));
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }    
    
    /**
     * @Route("/mostrarpresentacionesinscriptas", name="VerPresentacionesInscriptas")
     */
    public function VerPresentacionesInscriptasAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
                $em = $this->getDoctrine()->getManager();
                $presentacion = $em->getRepository('AppBundle:Presentacion')->findAll();
                if($presentacion){
                    return $this->render('AppBundle:Reportes:presentacionesinscriptas.html.twig', array("presentacion"=>$presentacion));    
                }
                return $this->render('AppBundle:Default:inicio.html.twig');    
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }  

    /**
     * @Route("/reporteentregasviatico", name="VerEntregas")
     */
    public function VerEntregasAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
                $em = $this->getDoctrine()->getManager();
                $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
                $directivo = $em->getRepository('AppBundle:Directivo')->findAll();
                $encargado = $em->getRepository('AppBundle:Encargado')->findAll();
                $estudiante = $em->getRepository('AppBundle:Estudiante')->findAll();
                $docente = $em->getRepository('AppBundle:Docente')->findAll();
                $trabajo = $em->getRepository('AppBundle:Trabajo')->findAll();
                $presentacion = $em->getRepository('AppBundle:Presentacion')->findAll();
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $fechaactual = date("d-m-Y");        
                $tipoviatico = $em->getRepository('AppBundle:Tipoviatico')->findOneBy(Array('isActive' => 1));
                $viatico = $em->getRepository('AppBundle:Viatico')->findBy(Array('fechav' => $fechaactual, 'descv' => $tipoviatico->getDesc()));
                return $this->render('AppBundle:Reportes:entregaviaticos.html.twig', array(
                    'escuela' =>$escuela, 'directivo'=>$directivo, 'encargado'=>$encargado,
                    'estudiante'=>$estudiante, 'trabajo'=>$trabajo,
                    'presentacion'=>$presentacion, 'docente'=>$docente, 'viatico'=>$viatico));
                //print_r($listaviaticos);
                //die();
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }  
    
}