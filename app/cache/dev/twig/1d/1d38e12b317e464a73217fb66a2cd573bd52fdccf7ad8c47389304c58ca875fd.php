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
        $__internal_faddf5e6640b5099c13dffe12bcdb6ba66675e5d5f1f7bdcf3db92d45e0a55fd = $this->env->getExtension("native_profiler");
        $__internal_faddf5e6640b5099c13dffe12bcdb6ba66675e5d5f1f7bdcf3db92d45e0a55fd->enter($__internal_faddf5e6640b5099c13dffe12bcdb6ba66675e5d5f1f7bdcf3db92d45e0a55fd_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "AppBundle:Default:inicio.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_faddf5e6640b5099c13dffe12bcdb6ba66675e5d5f1f7bdcf3db92d45e0a55fd->leave($__internal_faddf5e6640b5099c13dffe12bcdb6ba66675e5d5f1f7bdcf3db92d45e0a55fd_prof);

    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        $__internal_fe3a4438099e20d52c5e7403917248a4bf91fc0a31a09a12b27d108fd53132b9 = $this->env->getExtension("native_profiler");
        $__internal_fe3a4438099e20d52c5e7403917248a4bf91fc0a31a09a12b27d108fd53132b9->enter($__internal_fe3a4438099e20d52c5e7403917248a4bf91fc0a31a09a12b27d108fd53132b9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Bienvenido a TECNICAMENTE 2016!!!";
        
        $__internal_fe3a4438099e20d52c5e7403917248a4bf91fc0a31a09a12b27d108fd53132b9->leave($__internal_fe3a4438099e20d52c5e7403917248a4bf91fc0a31a09a12b27d108fd53132b9_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_a8298334159363b7f591bc9f7ecf0ec1122ba1b0e080c510e36cd81faaecd4ff = $this->env->getExtension("native_profiler");
        $__internal_a8298334159363b7f591bc9f7ecf0ec1122ba1b0e080c510e36cd81faaecd4ff->enter($__internal_a8298334159363b7f591bc9f7ecf0ec1122ba1b0e080c510e36cd81faaecd4ff_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "
";
        // line 5
        $this->displayParentBlock("body", $context, $blocks);
        echo "
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
        // line 21
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo "</p>
</footer>
";
        
        $__internal_a8298334159363b7f591bc9f7ecf0ec1122ba1b0e080c510e36cd81faaecd4ff->leave($__internal_a8298334159363b7f591bc9f7ecf0ec1122ba1b0e080c510e36cd81faaecd4ff_prof);

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
        return array (  75 => 21,  56 => 5,  53 => 4,  47 => 3,  35 => 2,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* {% block title %}Bienvenido a TECNICAMENTE 2016!!!{% endblock %}*/
/* {% block body %}*/
/* */
/* {{parent()}}*/
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
