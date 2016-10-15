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

class GraficaController extends Controller
{
  



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
                
                $votoshabilitados = $votosactivos * 4;


                $votosdisponible = 0 ;
                foreach ($totalvotos as $totalvotos ) {

                        $votosdisponible = $votosdisponible + $totalvotos->getCtvcbs() + $totalvotos->getCtvcss()+ $totalvotos->getCtvfp() + $totalvotos->getCtvts(); 

                }
                //echo $votoshabilitados;
                //echo "<br>";
                //echo $votosdisponible;

                $votosrealizados = $em->getRepository('AppBundle:Historialvoto')->findAll();
                $totalvr = count($votosrealizados);

                //echo "<br>";
                //echo $totalvr;
                //die();



                $totalfv = $votoshabilitados - $totalvr;
                $porcentvr =($totalvr/$votoshabilitados)*100;
                $porcentfv =($totalfv/$votoshabilitados)*100; 
                $porcentvr =round($porcentvr,2);
                $porcentfv =round($porcentfv,2);
                
                $contcbs = 0;
                $contcss = 0;
                $contfp = 0;
                $contts = 0;   
                $contdes = 0;
                $contm = 0;

                foreach ($votosrealizados as $key) {
                    if($key->getTrabajo()->getNiveltrab() == 'cbs'){
                        $contcbs = $contcbs + 1;
                    }elseif($key->getTrabajo()->getNiveltrab() == 'css'){
                        $contcss = $contcss + 1;
                    }elseif($key->getTrabajo()->getNiveltrab() == 'fp'){
                        $contfp = $contfp + 1;
                    }else{
                        $contts = $contts + 1;
                    }

                    if($key->getTipovoto() == 'Estudiante'){
                        $contdes = $contdes + 1;
                    }elseif($key->getTipovoto() == 'Encargado'){
                        $contm = $contm + 1;
                    }
                }
                
                $totalestrab = $contcbs + $contcss + $contfp + $contts;
                $porcentcbs = ($contcbs/ $totalestrab)*100;
                $porcentcss = ($contcss/ $totalestrab)*100;
                $porcentfp = ($contfp/ $totalestrab)*100;
                $porcentts = ($contts/ $totalestrab)*100;
                
                $porcentcbs =round($porcentcbs,2);
                $porcentcss =round($porcentcss,2);
                $porcentfp =round($porcentfp,2);
                $porcentts =round($porcentts,2);

                $totdm = $contdes + $contm;
                $porcentdes = ($contdes/$totdm)*100;
                $porcentmen = ($contm/$totdm)*100;
                $porcentdes =round($porcentdes,2);
                $porcentmen =round($porcentmen,2);

                return $this->render('AppBundle:Reportes:grafica.html.twig',
                    array(
                        'totalvr'=>$totalvr, 'totalfv'=>$totalfv,
                        'porcentfv'=>$porcentfv,'porcentvr'=>$porcentvr,
                        'totd'=>$totd, 'tote'=>$tote, 'tota'=>$tota,
                        'porcentdirectivo'=>$porcentdirectivo, 'porcentdocente'=>$porcentdocente,
                        'porcentalumno'=>$porcentalumno, 
                        
                        'contcbs'=>$contcbs, 'contcss'=>$contcss,'contfp'=>$contfp, 'contts'=>$contts,
                        'porcentcbs'=>$porcentcbs, 'porcentcss'=>$porcentcss, 'porcentfp'=>$porcentfp, 'porcentts'=>$porcentts,

                        'contdes'=>$contdes, 'contm'=>$contm, 'porcentdes'=>$porcentdes, 'porcentmen'=>$porcentmen

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