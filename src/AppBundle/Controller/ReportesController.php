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
                $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array("isActive"=> 1, "estado"=> 0));
                $historial = $em->getRepository('AppBundle:Historialvoto')->findAll();
                if($trabajo and $historial){
                    $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array("niveltrab"=>$_POST['nivel'], "isActive"=> 1),Array("cantvoto"=>'DESC'));
                    return $this->render('AppBundle:Reportes:resultadosvotos.html.twig', array("trabajo"=>$trabajo));
                }else{
                    $this->get('session')->getFlashBag()->add('mensaje','La votación continua abierta, debe finalizar para poder ver los resultados.');
                    return $this->render('AppBundle:Reportes:seleccionarnivel.html.twig');
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
                $directivo = $em->getRepository('AppBundle:Directivo')->findBy(Array('isActive' => 1));
                $encargado = $em->getRepository('AppBundle:Encargado')->findBy(Array('isActive' => 1));
                $estudiante = $em->getRepository('AppBundle:Estudiante')->findBy(Array('isActive' => 1));
                $docente = $em->getRepository('AppBundle:Docente')->findAll();
                $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1));
                $presentacion = $em->getRepository('AppBundle:Presentacion')->findAll();
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $fechaactual = date("d-m-Y");        
                $tipoviatico = $em->getRepository('AppBundle:Tipoviatico')->findOneBy(Array('isActive' => 1));
                if($tipoviatico){
                $viatico = $em->getRepository('AppBundle:Viatico')->findBy(Array( 'descv' => $tipoviatico->getDesc(), 'fechav' => $fechaactual ));
                return $this->render('AppBundle:Reportes:entregaviaticos.html.twig', array(
                    'escuela' =>$escuela, 'directivo'=>$directivo, 'encargado'=>$encargado,
                    'estudiante'=>$estudiante, 'trabajo'=>$trabajo,
                    'presentacion'=>$presentacion, 'docente'=>$docente, 'viatico' => $viatico));
                }else{
                    $msj = "Debe solicitar al adminstrador que Active la entrega.";              
                    return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                     
                }
                
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }  

    /**
     * @Route("/listaentregadeviaticos", name="VerEntregasViatico")
     */
    public function VerEntregasViaticoAction(Request $request)
    {
                $em = $this->getDoctrine()->getManager();
                $escuela = $em->getRepository('AppBundle:Escuela')->findAll();
                $directivo = $em->getRepository('AppBundle:Directivo')->findBy(Array('isActive' => 1));
                $encargado = $em->getRepository('AppBundle:Encargado')->findBy(Array('isActive' => 1));
                $estudiante = $em->getRepository('AppBundle:Estudiante')->findBy(Array('isActive' => 1));
                $docente = $em->getRepository('AppBundle:Docente')->findAll();
                $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(Array('isActive' => 1));
                $presentacion = $em->getRepository('AppBundle:Presentacion')->findAll();
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $fechaactual = date("d-m-Y");        
                $tipoviatico = $em->getRepository('AppBundle:Tipoviatico')->findOneBy(Array('isActive' => 1));
                if($tipoviatico){
                $viatico = $em->getRepository('AppBundle:Viatico')->findBy(Array( 'descv' => $tipoviatico->getDesc(), 'fechav' => $fechaactual ));
                return $this->render('AppBundle:Reportes:entregaviaticos2.html.twig', array(
                    'escuela' =>$escuela, 'directivo'=>$directivo, 'encargado'=>$encargado,
                    'estudiante'=>$estudiante, 'trabajo'=>$trabajo,
                    'presentacion'=>$presentacion, 'docente'=>$docente, 'viatico' => $viatico));
                }else{
                    $msj = "Debe solicitar al adminstrador que Active la entrega.";              
                    return $this->render('AppBundle:Default:mensajeerro.html.twig', array('msj'=>$msj));                     
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
            $juris= $em->getRepository('AppBundle:Jurisdiccion')->find($request->get('juri'));
            $trabajo = $em->getRepository('AppBundle:Trabajo')->findBy(
                Array('isActive' => 1,'estado' => 0), Array( 'cantvoto'=>'DESC'));
            if($trabajo){
                return $this->render('AppBundle:Reportes:datosestadisticos.html.twig',
                    array('juris'=>$juris, 'trabajo'=>$trabajo ));
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
     * @Route("/cargadatos/seleccionarjurisdiccion", name="SelecJuris")
     */
    public function SelecJurisAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $juris = $em->getRepository('AppBundle:Jurisdiccion')->findAll();
            return $this->render('AppBundle:Reportes:seleccionarJuris.html.twig',array('juris'=>$juris));
        }else
        {
            return $this->render('AppBundle:Default:principal.html.twig');
        }
    }


    /**
     * @Route("/cargadatos/vergraficas", name="VerGrafica")
     */
    public function VerGraficaAction(Request $request)
    {
        $session=$request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $historial = $em->getRepository('AppBundle:Historialvoto')->findAll();
            $directivo = $em->getRepository('AppBundle:Directivo')->findBy(array('isActive' => 1));
            $encargado = $em->getRepository('AppBundle:Encargado')->findBy(array('isActive' => 1));
            $estudiantes = $em->getRepository('AppBundle:Estudiante')->findBy(array('isActive' => 1));
        if(!$directivo and !$encargado and !$estudiantes){
            $msj = "No se puede Mostrar la información.";
            return $this->render('AppBundle:Default:mensajeerro.html.twig',array('msj'=>$msj));
        }else{
            $totd = count($directivo);
            $tote = count($encargado);
            $tota = count($estudiantes);

            $totaluser = $totd + $tote + $tota;

                
            $porcentdirectivo = ($totd / $totaluser)*100;
            $porcentdocente = ($tote / $totaluser)*100;
            $porcentalumno = ($tota / $totaluser)*100; 

            $porcentdirectivo =round($porcentdirectivo,2);
            $porcentdocente =round( $porcentdocente,2);
            $porcentalumno =round($porcentalumno,2);            
            if($historial){

                
                $totalvotos = $em->getRepository('AppBundle:Configuracion')->findBy(array('isActive' => 1));

                $votosactivos = count($totalvotos);
                
                $votoshabilitados = $votosactivos * 30;


                $votosdisponible = 0 ;
                foreach ($totalvotos as $totalvotos ) {
                    $detalle = $em->getRepository('AppBundle:Detalleconfiguracion')->findBy(array('configuracion'=>$totalvotos));
                    foreach ($detalle as $detalle) {
                        $votosdisponible = $votosdisponible + $detalle->getCantcbs() + $detalle->getCantcbs(); 

                    }
                }

                $votosrealizados = $em->getRepository('AppBundle:Historialvoto')->findAll();
                $totalvr = count($votosrealizados);

                $totalfv = $votoshabilitados - $totalvr;
                $porcentvr =($totalvr/$votoshabilitados)*100;
                $porcentfv =($totalfv/$votoshabilitados)*100; 
                $porcentvr =round($porcentvr,2);
                $porcentfv =round($porcentfv,2);
                
                $contcbs = 0;
                $contcss = 0;

                $corrcbs = 0;
                $miscbs = 0;
                $formcbs = 0;
                $chcbs = 0;
                $entriocbs = 0;

                $corrcss = 0;
                $miscss = 0;
                $formcss = 0;
                $chcss = 0;
                $entriocss = 0;   

                foreach ($votosrealizados as $key) {
                    if($key->getTrabajo()->getNiveltrab() == 'cbs'){
                        $contcbs = $contcbs + 1;
                    }elseif($key->getTrabajo()->getNiveltrab() == 'css'){
                        $contcss = $contcss + 1;
                    }else{
                        $contotros = $contotros + 1;
                    }

                    if($key->getTrabajo()->getEscuela()->getJurisdiccion() == 'Corrientes' and $key->getTrabajo()->getNiveltrab() == 'cbs'){
                        $corrcbs = $corrcbs + 1;
                    }elseif($key->getTrabajo()->getEscuela()->getJurisdiccion() == 'Misiones' and $key->getTrabajo()->getNiveltrab() == 'cbs'){
                        $miscbs = $miscbs + 1;
                    }elseif($key->getTrabajo()->getEscuela()->getJurisdiccion() == 'Formosa' and $key->getTrabajo()->getNiveltrab() == 'cbs'){
                        $formcbs = $formcbs + 1;
                    }elseif($key->getTrabajo()->getEscuela()->getJurisdiccion() == 'Chaco' and $key->getTrabajo()->getNiveltrab() == 'cbs'){
                        $chcbs = $chcbs + 1;
                    }elseif($key->getTrabajo()->getEscuela()->getJurisdiccion() == 'Entre Ríos' and $key->getTrabajo()->getNiveltrab() == 'cbs'){
                        $entriocbs = $entriocbs + 1;
                    }

                    if($key->getTrabajo()->getEscuela()->getJurisdiccion() == 'Corrientes' and $key->getTrabajo()->getNiveltrab() == 'css'){
                        $corrcss = $corrcss + 1;
                    }elseif($key->getTrabajo()->getEscuela()->getJurisdiccion() == 'Misiones' and $key->getTrabajo()->getNiveltrab() == 'css'){
                        $miscss = $miscss + 1;
                    }elseif($key->getTrabajo()->getEscuela()->getJurisdiccion() == 'Formosa' and $key->getTrabajo()->getNiveltrab() == 'css'){
                        $formcss = $formcss + 1;
                    }elseif($key->getTrabajo()->getEscuela()->getJurisdiccion() == 'Chaco' and $key->getTrabajo()->getNiveltrab() == 'css'){
                        $chcss = $chcss + 1;
                    }elseif($key->getTrabajo()->getEscuela()->getJurisdiccion() == 'Entre Ríos' and $key->getTrabajo()->getNiveltrab() == 'css'){
                        $entriocss = $entriocss + 1;
                    }
                }
                
                $totcbscss = $contcbs + $contcss;
                $porcentcbs = ($contcbs/ $totcbscss)*100;
                $porcentcss = ($contcss/ $totcbscss)*100;
                $porcentcbs =round($porcentcbs,2);
                $porcentcss =round($porcentcss,2);

                $chcbscss = $chcbs + $chcss;
                $corrcbscss = $corrcbs +$corrcss;
                $entriocbscss = $entriocbs +$entriocss;
                $formcbscss = $formcbs +$formcss;
                $miscbscss = $miscbs+ $miscss;
                $totChCoERFoMi = $chcbscss + $corrcbscss + $entriocbscss + $formcbscss + $miscbscss;
                $porcentchcbscss = ($chcbscss / $totChCoERFoMi)*100;
                $porcentcorrcbscss = ($corrcbscss / $totChCoERFoMi)*100;
                $porcententriocbscss = ($entriocbscss / $totChCoERFoMi)*100;
                $porcentformcbscss = ($formcbscss / $totChCoERFoMi)*100;
                $porcentmiscbscss = ($miscbscss / $totChCoERFoMi)*100;

                $porcentchcbscss = round($porcentchcbscss,2);
                $porcentcorrcbscss  = round($porcentcorrcbscss,2);
                $porcententriocbscss = round($porcententriocbscss,2);
                $porcentformcbscss = round($porcentformcbscss,2);
                $porcentmiscbscss = round($porcentmiscbscss,2);

                return $this->render('AppBundle:Reportes:grafica.html.twig',
                    array(
                        'totalvr'=>$totalvr, 'totalfv'=>$totalfv,
                        'porcentfv'=>$porcentfv,'porcentvr'=>$porcentvr,
                        'totd'=>$totd, 'tote'=>$tote, 'tota'=>$tota,
                        'porcentdirectivo'=>$porcentdirectivo, 'porcentdocente'=>$porcentdocente,
                        'porcentalumno'=>$porcentalumno, 
                        'contcbs'=>$contcbs, 'contcss'=>$contcss,
                        'porcentcbs'=>$porcentcbs, 'porcentcss'=>$porcentcss,
                        'chcbscss'=>$chcbscss, 'corrcbscss'=>$corrcbscss, 'entriocbscss'=>$entriocbscss, 
                        'formcbscss'=>$formcbscss, 'miscbscss'=>$miscbscss,
                        'porcentchcbscss' => $porcentchcbscss, 'porcentcorrcbscss' => $porcentcorrcbscss,
                        'porcententriocbscss' => $porcententriocbscss, 'porcentformcbscss' => $porcentformcbscss,
                        'porcentmiscbscss' => $porcentmiscbscss
                        ));
            }else{
                return $this->render('AppBundle:Reportes:grafica2.html.twig',
                    array(
                        /*'totalvr'=>$totalvr, 'totalfv'=>$totalfv,
                        'porcentfv'=>$porcentfv,'porcentvr'=>$porcentvr,*/
                        'totd'=>$totd, 'tote'=>$tote, 'tota'=>$tota,
                        'porcentdirectivo'=>$porcentdirectivo, 'porcentdocente'=>$porcentdocente,
                        'porcentalumno'=>$porcentalumno
                        ));                
            }
        }
        }else{
            return $this->render('AppBundle:Default:principal.html.twig');
        }

    }

}