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

                if ($_POST['nivel'] == "0" or $_POST['nivel'] == " " ) {
                    $this->get('session')->getFlashBag()->add('mensaje','Debe seleccionar una opción.');
                    return $this->render('AppBundle:Reportes:seleccionarnivel.html.twig');
                }else{
                    $em = $this->getDoctrine()->getManager();
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array("isActive"=> 1, "estado"=> 0));
                    $historial = $em->getRepository('AppBundle:Historialvoto')->findAll();
                    if($trabajo and $historial){

                        $trabajodes = $em->getRepository('AppBundle:Trabajo')->findBy(Array("niveltrab"=>$_POST['nivel'], "isActive"=> 1),Array("cvdestacado"=>'DESC'));
                        $trabajomen = $em->getRepository('AppBundle:Trabajo')->findBy(Array("niveltrab"=>$_POST['nivel'], "isActive"=> 1),Array("cvmencion"=>'DESC'));
                        if ($_POST['nivel'] =='cbs') {
                            $nivel = "Ciclo Básico Secundario";
                        }elseif ($_POST['nivel'] =='css') {
                            $nivel = "Ciclo Superior Secundario";
                        }elseif ($_POST['nivel'] =='fp') {
                            $nivel = "Formación Profesional";
                        }else{
                            $nivel = "Nivel Superior";
                        } 
                        return $this->render('AppBundle:Reportes:resultadosvotos.html.twig', 
                            array("trabajodes"=>$trabajodes, "trabajomen"=>$trabajomen, "nivel"=>$nivel));
                    }else{
                        $this->get('session')->getFlashBag()->add('mensaje','La votación continua abierta, debe finalizar para poder ver los resultados.');
                        return $this->render('AppBundle:Reportes:seleccionarnivel.html.twig');
                    }
                }    
            }
            return $this->render('AppBundle:Reportes:seleccionarnivel.html.twig');
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }

    /**
     * @Route("/verintegrantes/{idt}", name="VerIntegrantes")
     */
    public function VerIntegrantesAction(Request $request, $idt)
    {
        $session=$request->getSession();
        if($session->has("id")){
            echo $idt;
            die();            
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
                if($escuela){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array("escuela"=>$escuela, "isActive"=> 1 ));
                    $directivo = $em->getRepository('AppBundle:Directivo')->findOneBy(Array("idesc"=>$escuela->getId()));
                    $estudiante = $em->getRepository('AppBundle:Estudiante')->findAll();
                    return $this->render('AppBundle:Reportes:resultadosinscripcion.html.twig', 
                    array("escuela"=>$escuela, "trabajo"=>$trabajo, "directivo"=>$directivo, "estudiante"=>$estudiante));
                }
            }
            $em=$this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder('AppBundle:Escuela')
                        ->select('e')
                        ->from('AppBundle:Escuela','e')
                        ->orderBy("e.cue","asc")
                        ->getQuery();
            $escuela=$em->getArrayResult();
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
     * @Route("/cargadatos/datosestadisticos", name="DatosEstadisticos")
     */
    public function DatosEstadisticosAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1,'estado' => 0));
            if ($request->get('tv') == "destacados"){
                $trabajocb = $em->getRepository('AppBundle:Trabajo')->findBy(
                 Array('isActive' => 1,'estado' => 0, 'niveltrab' => 'cbs'), Array( 'cvdestacado'=>'DESC'));
                
                $trabajocs = $em->getRepository('AppBundle:Trabajo')->findBy(
                 Array('isActive' => 1,'estado' => 0, 'niveltrab' => 'css'), Array( 'cvdestacado'=>'DESC'));
                
                $trabajofp = $em->getRepository('AppBundle:Trabajo')->findBy(
                 Array('isActive' => 1,'estado' => 0, 'niveltrab' => 'fp'), Array( 'cvdestacado'=>'DESC'));
                
                $trabajots = $em->getRepository('AppBundle:Trabajo')->findBy(
                 Array('isActive' => 1,'estado' => 0, 'niveltrab' => 'ts' ), Array( 'cvdestacado'=>'DESC'));
                $tipov = "Destacados";
            }elseif($request->get('tv')== "mencionados"){
                $trabajocb = $em->getRepository('AppBundle:Trabajo')->findBy(
                 Array('isActive' => 1,'estado' => 0, 'niveltrab' => 'cbs'), Array( 'cvmencion'=>'DESC'));
                
                $trabajocs = $em->getRepository('AppBundle:Trabajo')->findBy(
                 Array('isActive' => 1,'estado' => 0, 'niveltrab' => 'css'), Array( 'cvmencion'=>'DESC'));

                $trabajofp = $em->getRepository('AppBundle:Trabajo')->findBy(
                 Array('isActive' => 1,'estado' => 0, 'niveltrab' => 'fp'), Array( 'cvmencion'=>'DESC'));

                $trabajots = $em->getRepository('AppBundle:Trabajo')->findBy(
                 Array('isActive' => 1,'estado' => 0, 'niveltrab' => 'ts'), Array( 'cvmencion'=>'DESC'));
                $tipov = "Mencionados";
            }else{
                $this->get('session')->getFlashBag()->add('mensaje','Debe seleccionar una Opción, gracias.');
                return $this->render('AppBundle:Reportes:seleccionarOpcion.html.twig');
            }

            if($trabajo){
                return $this->render('AppBundle:Reportes:datosestadisticos.html.twig',
                    array('tipov'=>$tipov, 'trabajocb'=>$trabajocb, 'trabajocs'=>$trabajocs,'trabajofp'=>$trabajofp,'trabajots'=>$trabajots ));
            }else{
                $msj = "Sigue abierta la votación.";
                return $this->render('AppBundle:Reportes:msjestadistica.html.twig',array('msj'=>$msj));
            }            
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }

    /**
     * @Route("/cargadatos/seleccionarOpcion", name="SelecOpcion")
     */
    public function SelecOpcionAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            return $this->render('AppBundle:Reportes:seleccionarOpcion.html.twig');
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }

}