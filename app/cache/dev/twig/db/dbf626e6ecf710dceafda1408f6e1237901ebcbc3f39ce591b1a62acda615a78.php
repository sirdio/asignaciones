<?php

/* ::base.html.twig */
class __TwigTemplate_65f1d69c8d9c9c71a02e4fd4b2ddafbac6b5998617d1d07c33960aef2cd57e0e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_d32f51ffe8567f019a8ef9fea0f3926693f996aa7adfa4da823ed7560f0d9175 = $this->env->getExtension("native_profiler");
        $__internal_d32f51ffe8567f019a8ef9fea0f3926693f996aa7adfa4da823ed7560f0d9175->enter($__internal_d32f51ffe8567f019a8ef9fea0f3926693f996aa7adfa4da823ed7560f0d9175_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "::base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <title>";
        // line 7
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 8
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 13
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
      
    </head>
    <body>
        ";
        // line 17
        $this->displayBlock('body', $context, $blocks);
        // line 20
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 25
        echo "    </body>
</html>
\t";
        
        $__internal_d32f51ffe8567f019a8ef9fea0f3926693f996aa7adfa4da823ed7560f0d9175->leave($__internal_d32f51ffe8567f019a8ef9fea0f3926693f996aa7adfa4da823ed7560f0d9175_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_ac57a25d4b433d0b0ec7b83d31ca7926783e7644078d73457f4d9a9ba5f84029 = $this->env->getExtension("native_profiler");
        $__internal_ac57a25d4b433d0b0ec7b83d31ca7926783e7644078d73457f4d9a9ba5f84029->enter($__internal_ac57a25d4b433d0b0ec7b83d31ca7926783e7644078d73457f4d9a9ba5f84029_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Bienvenidos!!!";
        
        $__internal_ac57a25d4b433d0b0ec7b83d31ca7926783e7644078d73457f4d9a9ba5f84029->leave($__internal_ac57a25d4b433d0b0ec7b83d31ca7926783e7644078d73457f4d9a9ba5f84029_prof);

    }

    // line 8
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_c76b064ba51148dc1dbc585da68d90db87910d288e7ea4fbc17150195d0854b4 = $this->env->getExtension("native_profiler");
        $__internal_c76b064ba51148dc1dbc585da68d90db87910d288e7ea4fbc17150195d0854b4->enter($__internal_c76b064ba51148dc1dbc585da68d90db87910d288e7ea4fbc17150195d0854b4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 9
        echo "        <!-- Latest compiled and minified CSS -->
             <link href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("public/css/bootstrap.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
             <link href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("public/css/bootstrap.min.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        ";
        
        $__internal_c76b064ba51148dc1dbc585da68d90db87910d288e7ea4fbc17150195d0854b4->leave($__internal_c76b064ba51148dc1dbc585da68d90db87910d288e7ea4fbc17150195d0854b4_prof);

    }

    // line 17
    public function block_body($context, array $blocks = array())
    {
        $__internal_54e70b2770cf757af453271e98e9584a27ca5bbc1f2b5dbcba07dc8d6de8162e = $this->env->getExtension("native_profiler");
        $__internal_54e70b2770cf757af453271e98e9584a27ca5bbc1f2b5dbcba07dc8d6de8162e->enter($__internal_54e70b2770cf757af453271e98e9584a27ca5bbc1f2b5dbcba07dc8d6de8162e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 18
        echo "        ";
        echo twig_include($this->env, $context, "menu.html.twig");
        echo "
        ";
        
        $__internal_54e70b2770cf757af453271e98e9584a27ca5bbc1f2b5dbcba07dc8d6de8162e->leave($__internal_54e70b2770cf757af453271e98e9584a27ca5bbc1f2b5dbcba07dc8d6de8162e_prof);

    }

    // line 20
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_5dfb36cd3910c5f9ed564e4da4a4d89709b36909cd0f6b88f870e4f67fcbdd6a = $this->env->getExtension("native_profiler");
        $__internal_5dfb36cd3910c5f9ed564e4da4a4d89709b36909cd0f6b88f870e4f67fcbdd6a->enter($__internal_5dfb36cd3910c5f9ed564e4da4a4d89709b36909cd0f6b88f870e4f67fcbdd6a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 21
        echo "           <!-- Latest compiled and minified JavaScript -->
           <script src=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("public/js/jquery-3.1.0.min.js"), "html", null, true);
        echo "\"></script>
           <script src=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("public/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>  
        ";
        
        $__internal_5dfb36cd3910c5f9ed564e4da4a4d89709b36909cd0f6b88f870e4f67fcbdd6a->leave($__internal_5dfb36cd3910c5f9ed564e4da4a4d89709b36909cd0f6b88f870e4f67fcbdd6a_prof);

    }

    public function getTemplateName()
    {
        return "::base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  125 => 23,  121 => 22,  118 => 21,  112 => 20,  102 => 18,  96 => 17,  87 => 11,  83 => 10,  80 => 9,  74 => 8,  62 => 7,  53 => 25,  50 => 20,  48 => 17,  40 => 13,  38 => 8,  34 => 7,  26 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html>*/
/*     <head>*/
/*         <meta charset="UTF-8" />*/
/*         <meta http-equiv="X-UA-Compatible" content="IE=edge">*/
/*         <meta name="viewport" content="width=device-width, initial-scale=1">*/
/*         <title>{% block title %}Bienvenidos!!!{% endblock %}</title>*/
/*         {% block stylesheets %}*/
/*         <!-- Latest compiled and minified CSS -->*/
/*              <link href="{{ asset('public/css/bootstrap.css') }}" type="text/css" rel="stylesheet" />*/
/*              <link href="{{ asset('public/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet" />*/
/*         {% endblock %}*/
/*         <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />*/
/*       */
/*     </head>*/
/*     <body>*/
/*         {% block body %}*/
/*         {{include('menu.html.twig')}}*/
/*         {% endblock %}*/
/*         {% block javascripts %}*/
/*            <!-- Latest compiled and minified JavaScript -->*/
/*            <script src="{{ asset('public/js/jquery-3.1.0.min.js') }}"></script>*/
/*            <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>  */
/*         {% endblock %}*/
/*     </body>*/
/* </html>*/
/* 	*/
