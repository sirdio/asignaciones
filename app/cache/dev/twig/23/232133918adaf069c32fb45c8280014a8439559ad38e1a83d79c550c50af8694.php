<?php

/* menu.html.twig */
class __TwigTemplate_d8a433dd04cf1319071d4348aa05293f8f677edf0c4824b1340cb0bc11c8d85a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_63088e1676fb94515f26f2c880b62bfbf547f3c302d917823d57afcc36b5c0b5 = $this->env->getExtension("native_profiler");
        $__internal_63088e1676fb94515f26f2c880b62bfbf547f3c302d917823d57afcc36b5c0b5->enter($__internal_63088e1676fb94515f26f2c880b62bfbf547f3c302d917823d57afcc36b5c0b5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "menu.html.twig"));

        // line 1
        echo "<div class=\"container-fluid\">
<nav class=\"navbar navbar-default\">
<div class=\"btn-group\">
  <button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
    Escuela <span class=\"caret\"></span>
  </button>
  <ul class=\"dropdown-menu\">
    <li><a href=\"#\">Agregar</a></li>
    <li><a href=\"#\">Modoficar</a></li>
    <li role=\"separator\" class=\"divider\"></li>
    <li><a href=\"#\">Habilitar</a></li>
    <li><a href=\"#\">Bloquear</a></li>
  </ul>
<button type=\"button\" class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
    Usuario <span class=\"caret\"></span>
  </button>
  <ul class=\"dropdown-menu\">
    <li><a href=\"";
        // line 18
        echo $this->env->getExtension('routing')->getPath("Default_SelecU");
        echo "\">Agregar</a></li>
    <li><a href=\"#\">Modificar</a></li>
    <li role=\"separator\" class=\"divider\"></li>
    <li><a href=\"#\">Habilitar</a></li>
    <li><a href=\"#\">Bloquear</a></li>
  </ul>
<button type=\"button\" class=\"btn btn-success dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
    Trabajo<span class=\"caret\"></span>
  </button>
  <ul class=\"dropdown-menu\">
    <li><a href=\"#\">Agregar</a></li>
    <li><a href=\"#\">Modificar</a></li>
    <li role=\"separator\" class=\"divider\"></li>
    <li><a href=\"#\">Habilitar</a></li>
    <li><a href=\"#\">Bloquear</a></li>
  </ul>
<button type=\"button\" class=\"btn btn-info dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
    Presentaci&oacuten<span class=\"caret\"></span>
  </button>
  <ul class=\"dropdown-menu\">
    <li><a href=\"#\">Agregar</a></li>
    <li><a href=\"#\">Modificar</a></li>
    <li role=\"separator\" class=\"divider\"></li>
    <li><a href=\"#\">Habilitar</a></li>
    <li><a href=\"#\">Bloquear</a></li>
  </ul>
<button type=\"button\" class=\"btn btn-warning dropdown-toggle\">Salir</button>
</nav>
</div>
";
        
        $__internal_63088e1676fb94515f26f2c880b62bfbf547f3c302d917823d57afcc36b5c0b5->leave($__internal_63088e1676fb94515f26f2c880b62bfbf547f3c302d917823d57afcc36b5c0b5_prof);

    }

    public function getTemplateName()
    {
        return "menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 18,  22 => 1,);
    }
}
/* <div class="container-fluid">*/
/* <nav class="navbar navbar-default">*/
/* <div class="btn-group">*/
/*   <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">*/
/*     Escuela <span class="caret"></span>*/
/*   </button>*/
/*   <ul class="dropdown-menu">*/
/*     <li><a href="#">Agregar</a></li>*/
/*     <li><a href="#">Modoficar</a></li>*/
/*     <li role="separator" class="divider"></li>*/
/*     <li><a href="#">Habilitar</a></li>*/
/*     <li><a href="#">Bloquear</a></li>*/
/*   </ul>*/
/* <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">*/
/*     Usuario <span class="caret"></span>*/
/*   </button>*/
/*   <ul class="dropdown-menu">*/
/*     <li><a href="{{path('Default_SelecU')}}">Agregar</a></li>*/
/*     <li><a href="#">Modificar</a></li>*/
/*     <li role="separator" class="divider"></li>*/
/*     <li><a href="#">Habilitar</a></li>*/
/*     <li><a href="#">Bloquear</a></li>*/
/*   </ul>*/
/* <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">*/
/*     Trabajo<span class="caret"></span>*/
/*   </button>*/
/*   <ul class="dropdown-menu">*/
/*     <li><a href="#">Agregar</a></li>*/
/*     <li><a href="#">Modificar</a></li>*/
/*     <li role="separator" class="divider"></li>*/
/*     <li><a href="#">Habilitar</a></li>*/
/*     <li><a href="#">Bloquear</a></li>*/
/*   </ul>*/
/* <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">*/
/*     Presentaci&oacuten<span class="caret"></span>*/
/*   </button>*/
/*   <ul class="dropdown-menu">*/
/*     <li><a href="#">Agregar</a></li>*/
/*     <li><a href="#">Modificar</a></li>*/
/*     <li role="separator" class="divider"></li>*/
/*     <li><a href="#">Habilitar</a></li>*/
/*     <li><a href="#">Bloquear</a></li>*/
/*   </ul>*/
/* <button type="button" class="btn btn-warning dropdown-toggle">Salir</button>*/
/* </nav>*/
/* </div>*/
/* */
