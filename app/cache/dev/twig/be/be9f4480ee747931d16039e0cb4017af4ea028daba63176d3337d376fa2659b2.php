<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_f219883a74433165ba781ad6d60d9f4c3b5230b2aef6c9f232d86b187de0b416 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_cf5e6cc4bc8f5695b39914df0144d58ac1d663d3356959b67ac01001bdd0953f = $this->env->getExtension("native_profiler");
        $__internal_cf5e6cc4bc8f5695b39914df0144d58ac1d663d3356959b67ac01001bdd0953f->enter($__internal_cf5e6cc4bc8f5695b39914df0144d58ac1d663d3356959b67ac01001bdd0953f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_cf5e6cc4bc8f5695b39914df0144d58ac1d663d3356959b67ac01001bdd0953f->leave($__internal_cf5e6cc4bc8f5695b39914df0144d58ac1d663d3356959b67ac01001bdd0953f_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_26f73874abaa764c4b5b2787d026e3aab60460b84b16ed6a29728f15d2268c24 = $this->env->getExtension("native_profiler");
        $__internal_26f73874abaa764c4b5b2787d026e3aab60460b84b16ed6a29728f15d2268c24->enter($__internal_26f73874abaa764c4b5b2787d026e3aab60460b84b16ed6a29728f15d2268c24_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_26f73874abaa764c4b5b2787d026e3aab60460b84b16ed6a29728f15d2268c24->leave($__internal_26f73874abaa764c4b5b2787d026e3aab60460b84b16ed6a29728f15d2268c24_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_12b6837e669bde2f79f4e896b3f6f11f47b44aaded95f688b34132e4bb20f1d8 = $this->env->getExtension("native_profiler");
        $__internal_12b6837e669bde2f79f4e896b3f6f11f47b44aaded95f688b34132e4bb20f1d8->enter($__internal_12b6837e669bde2f79f4e896b3f6f11f47b44aaded95f688b34132e4bb20f1d8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_12b6837e669bde2f79f4e896b3f6f11f47b44aaded95f688b34132e4bb20f1d8->leave($__internal_12b6837e669bde2f79f4e896b3f6f11f47b44aaded95f688b34132e4bb20f1d8_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_1dcfb1e0eb142ccba40b60b19455d6ebe751a0782b0c6a7022234831ae96c3a2 = $this->env->getExtension("native_profiler");
        $__internal_1dcfb1e0eb142ccba40b60b19455d6ebe751a0782b0c6a7022234831ae96c3a2->enter($__internal_1dcfb1e0eb142ccba40b60b19455d6ebe751a0782b0c6a7022234831ae96c3a2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_1dcfb1e0eb142ccba40b60b19455d6ebe751a0782b0c6a7022234831ae96c3a2->leave($__internal_1dcfb1e0eb142ccba40b60b19455d6ebe751a0782b0c6a7022234831ae96c3a2_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends 'TwigBundle::layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include 'TwigBundle:Exception:exception.html.twig' %}*/
/* {% endblock %}*/
/* */
