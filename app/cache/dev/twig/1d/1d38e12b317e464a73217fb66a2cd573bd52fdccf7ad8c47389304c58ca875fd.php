<?php

/* AppBundle:Default:inicio.html.twig */
class __TwigTemplate_00224bddb372e2dda8a53f7d737a3d36adcb564780f37815d075d2f5d4f6510f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::base.html.twig", "AppBundle:Default:inicio.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_3350a9d403df5019e8c0f0653238f1a23de87acf5b4ac2f26816893a2ae30ddc = $this->env->getExtension("native_profiler");
        $__internal_3350a9d403df5019e8c0f0653238f1a23de87acf5b4ac2f26816893a2ae30ddc->enter($__internal_3350a9d403df5019e8c0f0653238f1a23de87acf5b4ac2f26816893a2ae30ddc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "AppBundle:Default:inicio.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_3350a9d403df5019e8c0f0653238f1a23de87acf5b4ac2f26816893a2ae30ddc->leave($__internal_3350a9d403df5019e8c0f0653238f1a23de87acf5b4ac2f26816893a2ae30ddc_prof);

    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        $__internal_8a65b440a75878da3b71fe196d6e17320f5416c4481a150c269d0057b597b7e8 = $this->env->getExtension("native_profiler");
        $__internal_8a65b440a75878da3b71fe196d6e17320f5416c4481a150c269d0057b597b7e8->enter($__internal_8a65b440a75878da3b71fe196d6e17320f5416c4481a150c269d0057b597b7e8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Bienvenido a TECNICAMENTE 2016!!!";
        
        $__internal_8a65b440a75878da3b71fe196d6e17320f5416c4481a150c269d0057b597b7e8->leave($__internal_8a65b440a75878da3b71fe196d6e17320f5416c4481a150c269d0057b597b7e8_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_bd53e33bc4bfefb452f5737e8bd505b128669b643c990bda6c68db58c165710e = $this->env->getExtension("native_profiler");
        $__internal_bd53e33bc4bfefb452f5737e8bd505b128669b643c990bda6c68db58c165710e->enter($__internal_bd53e33bc4bfefb452f5737e8bd505b128669b643c990bda6c68db58c165710e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "
<nav class=\"navbar navbar-default\">
  <div class=\"container-fluid\">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class=\"navbar-header\">
      <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\" aria-expanded=\"false\">
        <span class=\"sr-only\">Toggle navigation</span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
      </button>
      <a class=\"navbar-brand\" href=\"#\">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">
      <ul class=\"nav navbar-nav\">
        <li class=\"active\"><a href=\"#\">Link <span class=\"sr-only\">(current)</span></a></li>
        ";
        // line 23
        echo "        <li class=\"dropdown\">
          <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Escuela <span class=\"caret\"></span></a>
          <ul class=\"dropdown-menu\">
            <li><a href=\"#\">Agregar</a></li>
            <li><a href=\"#\">Modificar</a></li>
            <li role=\"separator\" class=\"divider\"></li>
            <li><a href=\"#\">Habilitar</a></li>
            <li><a href=\"#\">Boquear</a></li>
         </ul>
        </li>
        
        <li class=\"dropdown\">
          <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Usuario <span class=\"caret\"></span></a>
          <ul class=\"dropdown-menu\">
            <li><a href=\"";
        // line 37
        echo $this->env->getExtension('routing')->getPath("Default_SelecU");
        echo "\">Agregar</a></li>
            <li><a href=\"#\">Modificar</a></li>
            <li role=\"separator\" class=\"divider\"></li>
            <li><a href=\"#\">Habilitar</a></li>
            <li><a href=\"#\">Boquear</a></li>
         </ul>
        </li>        
      </ul>
      ";
        // line 51
        echo "      ";
        // line 64
        echo "    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
<div class=\"container\">
     <div class=\"row\">
          <div class=\"col-md-4\">
          </div>
          <div class=\"col-md-4\">
          </div> 
          <div class=\"col-md-4\">
          </div>
    </div>
</div> 



<footer>
   <p>T&eacutecnicamente 2016 - Sistema de Votaci&oacuten - Creado por <a href=\"https://github.com/dsyph3r\">Navarro Sergio Antonio</a>
        &copy; ";
        // line 83
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo "</p>
</footer>
";
        
        $__internal_bd53e33bc4bfefb452f5737e8bd505b128669b643c990bda6c68db58c165710e->leave($__internal_bd53e33bc4bfefb452f5737e8bd505b128669b643c990bda6c68db58c165710e_prof);

    }

    public function getTemplateName()
    {
        return "AppBundle:Default:inicio.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  123 => 83,  102 => 64,  100 => 51,  89 => 37,  73 => 23,  53 => 4,  47 => 3,  35 => 2,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* {% block title %}Bienvenido a TECNICAMENTE 2016!!!{% endblock %}*/
/* {% block body %}*/
/* */
/* <nav class="navbar navbar-default">*/
/*   <div class="container-fluid">*/
/*     <!-- Brand and toggle get grouped for better mobile display -->*/
/*     <div class="navbar-header">*/
/*       <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">*/
/*         <span class="sr-only">Toggle navigation</span>*/
/*         <span class="icon-bar"></span>*/
/*         <span class="icon-bar"></span>*/
/*         <span class="icon-bar"></span>*/
/*       </button>*/
/*       <a class="navbar-brand" href="#">Brand</a>*/
/*     </div>*/
/* */
/*     <!-- Collect the nav links, forms, and other content for toggling -->*/
/*     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">*/
/*       <ul class="nav navbar-nav">*/
/*         <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>*/
/*         {#<li><a href="#">Link</a></li>#}*/
/*         <li class="dropdown">*/
/*           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Escuela <span class="caret"></span></a>*/
/*           <ul class="dropdown-menu">*/
/*             <li><a href="#">Agregar</a></li>*/
/*             <li><a href="#">Modificar</a></li>*/
/*             <li role="separator" class="divider"></li>*/
/*             <li><a href="#">Habilitar</a></li>*/
/*             <li><a href="#">Boquear</a></li>*/
/*          </ul>*/
/*         </li>*/
/*         */
/*         <li class="dropdown">*/
/*           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuario <span class="caret"></span></a>*/
/*           <ul class="dropdown-menu">*/
/*             <li><a href="{{path('Default_SelecU')}}">Agregar</a></li>*/
/*             <li><a href="#">Modificar</a></li>*/
/*             <li role="separator" class="divider"></li>*/
/*             <li><a href="#">Habilitar</a></li>*/
/*             <li><a href="#">Boquear</a></li>*/
/*          </ul>*/
/*         </li>        */
/*       </ul>*/
/*       {#<form class="navbar-form navbar-left" role="search">*/
/*         <div class="form-group">*/
/*           <inputtype="text" class="form-control" placeholder="Search">*/
/*         </div>*/
/*         <button type="submit" class="btn btn-default">Submit</button>*/
/*       </form>#}*/
/*       {#<ul class="nav navbar-nav navbar-right">*/
/*         <li><a href="#">Link</a></li>*/
/*         <li class="dropdown">*/
/*           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>*/
/*           <ul class="dropdown-menu">*/
/*             <li><a href="#">Action</a></li>*/
/*             <li><a href="#">Another action</a></li>*/
/*             <li><a href="#">Something else here</a></li>*/
/*             <li role="separator" class="divider"></li>*/
/*             <li><a href="#">Separated link</a></li>*/
/*           </ul>*/
/*         </li>*/
/*       </ul>#}*/
/*     </div><!-- /.navbar-collapse -->*/
/*   </div><!-- /.container-fluid -->*/
/* </nav>*/
/* </div>*/
/* <div class="container">*/
/*      <div class="row">*/
/*           <div class="col-md-4">*/
/*           </div>*/
/*           <div class="col-md-4">*/
/*           </div> */
/*           <div class="col-md-4">*/
/*           </div>*/
/*     </div>*/
/* </div> */
/* */
/* */
/* */
/* <footer>*/
/*    <p>T&eacutecnicamente 2016 - Sistema de Votaci&oacuten - Creado por <a href="https://github.com/dsyph3r">Navarro Sergio Antonio</a>*/
/*         &copy; {{ 'now' | date('Y') }}</p>*/
/* </footer>*/
/* {% endblock %}*/
