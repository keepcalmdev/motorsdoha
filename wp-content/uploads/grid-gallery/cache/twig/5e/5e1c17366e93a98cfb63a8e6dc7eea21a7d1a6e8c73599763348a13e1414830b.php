<?php

/* @galleries/index.twig */
class __TwigTemplate_89d2f471e4268557c6056aae8dbf65f53ba352b3320df78f2838e54db3a36047 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("grid-gallery.twig", "@galleries/index.twig", 1);
        $this->blocks = array(
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "grid-gallery.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_header($context, array $blocks = array())
    {
        // line 4
        echo "
    <nav id=\"supsystic-breadcrumbs\" class=\"supsystic-breadcrumbs\">
        ";
        // line 7
        echo "        ";
        // line 8
        echo "        <a href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries"), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Galleries")), "html", null, true);
        echo "</a>
    </nav>

";
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
        // line 14
        echo "
    <section id=\"gg-galleries\">

        <div class=\"row\">
            <div class=\"col-xs-12\">

                ";
        // line 20
        $context["columns"] = array(0 => "ID", 1 => $this->getAttribute(        // line 22
($context["environment"] ?? null), "translate", array(0 => "Title"), "method"), 2 => $this->getAttribute(        // line 23
($context["environment"] ?? null), "translate", array(0 => "Thumbnail"), "method"), 3 => $this->getAttribute(        // line 24
($context["environment"] ?? null), "translate", array(0 => "Shortcode"), "method"), 4 => $this->getAttribute(        // line 25
($context["environment"] ?? null), "translate", array(0 => "PHP"), "method"), 5 => $this->getAttribute(        // line 26
($context["environment"] ?? null), "translate", array(0 => "Actions"), "method"));
        // line 28
        echo "
                <table id=\"galleries\" class=\"wp-list-galleries\" style=\"min-width: 100%;\">
                    <thead>
                        <tr>
                            <th scope=\"col\">
                                <input type=\"checkbox\" id=\"check_all\" name=\"check_all\">
                            </th>
                            ";
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["columns"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
            // line 36
            echo "                                <th scope=\"col\">";
            echo twig_escape_filter($this->env, $context["column"], "html", null, true);
            echo "</th>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 38
        echo "                        </tr>
                    </thead>
                    <tbody>
                    ";
        // line 41
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["galleries"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["gallery"]) {
            // line 42
            echo "                        <tr id=\"gallery-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["gallery"], "id", array()), "html", null, true);
            echo "\" data-gallery-id=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["gallery"], "id", array()), "html", null, true);
            echo "\">
                            <td>
                                <input type=\"checkbox\" class=\"tableCheckbox\" id=\"check_";
            // line 44
            echo twig_escape_filter($this->env, $this->getAttribute($context["gallery"], "id", array()), "html", null, true);
            echo "\" data-gallery-id=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["gallery"], "id", array()), "html", null, true);
            echo "\" name=\"check_";
            echo twig_escape_filter($this->env, $this->getAttribute($context["gallery"], "id", array()), "html", null, true);
            echo "\">
                            </td>
                            <td>
                                ";
            // line 47
            echo twig_escape_filter($this->env, $this->getAttribute($context["gallery"], "id", array()), "html", null, true);
            echo "
                            </td>
                            <td>
                                <a href=\"";
            // line 50
            echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "settings", 2 => array("gallery_id" => $this->getAttribute($context["gallery"], "id", array()))), "method"), "html", null, true);
            echo "\" data-toggle=\"tooltip\" title=\"";
            echo twig_escape_filter($this->env, sprintf($this->getAttribute(($context["environment"] ?? null), "translate", array(0 => "Edit gallery \"%s\""), "method"), $this->getAttribute($context["gallery"], "title", array())), "html", null, true);
            echo "\">
                                    ";
            // line 51
            echo twig_title_string_filter($this->env, $this->getAttribute($context["gallery"], "title", array()));
            echo "
                                </a>
                                <i class=\"fa fa-fw fa-pencil\"></i>
                            </td>
                            <td>
                                ";
            // line 56
            if ((($this->getAttribute($context["gallery"], "attachment_id", array()) == 0) && (twig_length_filter($this->env, $this->getAttribute($context["gallery"], "link_default", array())) > 1))) {
                // line 57
                echo "                                    ";
                $context["cover"] = $this->getAttribute($context["gallery"], "link_default", array());
                // line 58
                echo "                                ";
            } else {
                // line 59
                echo "                                    ";
                $context["cover"] = call_user_func_array($this->env->getFunction('get_attachment')->getCallable(), array($this->getAttribute($context["gallery"], "attachment_id", array()), "155", "100", "true"));
                // line 60
                echo "                                ";
            }
            // line 61
            echo "
                                ";
            // line 62
            if ((twig_length_filter($this->env, ($context["cover"] ?? null)) < 1)) {
                // line 63
                echo "                                    ";
                if ((twig_length_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($context["gallery"], "settings", array()), "posts", array()), "postCover", array())) > 1)) {
                    // line 64
                    echo "                                        ";
                    $context["cover"] = $this->getAttribute($this->getAttribute($this->getAttribute($context["gallery"], "settings", array()), "posts", array()), "postCover", array());
                    // line 65
                    echo "                                    ";
                }
                // line 66
                echo "                                ";
            }
            // line 67
            echo "                                <div style=\"width:155px;height:100px;overflow:hidden;\">
                                    <img src=\"";
            // line 68
            echo twig_escape_filter($this->env, ((array_key_exists("cover", $context)) ? (_twig_default_filter(($context["cover"] ?? null), ("holder.js/350x220?theme=gray&text=" . $this->getAttribute($context["gallery"], "title", array())))) : (("holder.js/350x220?theme=gray&text=" . $this->getAttribute($context["gallery"], "title", array())))), "html", null, true);
            echo "\" alt=\"";
            echo $this->getAttribute($context["gallery"], "title", array());
            echo "\" width=\"155px\" height=\"100px\" style=\"height:auto\"/>
                                </div>
                            </td>
                            <td>
                                <input type=\"text\" id=\"shortcode-";
            // line 72
            echo twig_escape_filter($this->env, $this->getAttribute($context["gallery"], "id", array()), "html", null, true);
            echo "\" class=\"ggCopyTextCode shortcode\" value=\"[supsystic-gallery id='";
            echo twig_escape_filter($this->env, $this->getAttribute($context["gallery"], "id", array()), "html", null, true);
            echo "']\">
                            </td>
                            <td>
                                <input type=\"text\" id=\"phpcode-";
            // line 75
            echo twig_escape_filter($this->env, $this->getAttribute($context["gallery"], "id", array()), "html", null, true);
            echo "\" class=\"ggCopyTextCode phpcode\"
                                       value=\"";
            // line 76
            echo twig_escape_filter($this->env, (("<?php echo do_shortcode('[supsystic-gallery id=" . $this->getAttribute($context["gallery"], "id", array())) . "]') ?>"), "html", null, true);
            echo "\">
                            </td>
                            <td>
                                <a href=\"";
            // line 79
            echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "settings", 2 => array("gallery_id" => $this->getAttribute($context["gallery"], "id", array()))), "method"), "html", null, true);
            echo "\"
                                   class=\"button background sggActionButtons\">
                                    <i class=\"fa fa-cogs\"></i>
                                    ";
            // line 82
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Settings")), "html", null, true);
            echo "
                                </a>
                                <a href=\"";
            // line 84
            echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "view", 2 => array("gallery_id" => $this->getAttribute($context["gallery"], "id", array()))), "method"), "html", null, true);
            echo "\"
                                   class=\"button background sggActionButtons\">
                                    <i class=\"fa fa-bars\"></i>
                                    ";
            // line 87
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Images list")), "html", null, true);
            echo "
                                </a>
                                <a href=\"";
            // line 89
            echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "preview", 2 => array("gallery_id" => $this->getAttribute($context["gallery"], "id", array()))), "method"), "html", null, true);
            echo "\"
                                   class=\"button background sggActionButtons\">
                                    <i class=\"fa fa-eye\"></i>
                                    ";
            // line 92
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Preview")), "html", null, true);
            echo "
                                </a>
                                <br>
                                <button class=\"button button-primary gallery import-to-gallery sggActionButtons\" data-folder-id=\"0\"
                                        data-gallery-id=\"";
            // line 96
            echo twig_escape_filter($this->env, $this->getAttribute($context["gallery"], "id", array()), "html", null, true);
            echo "\" ";
            echo ">
                                    <i class=\"fa fa-fw fa-camera\"></i>
                                    ";
            // line 98
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Add Images")), "html", null, true);
            echo "
                                </button>
                                <a id=\"delete-gallery\" data-confirm=\"";
            // line 100
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Are you sure you want to delete this gallery?")), "html", null, true);
            echo "\" class=\"button button-primary sggActionButtons\" title=\"Delete this gallery\"
                                   href=\"";
            // line 101
            echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries", 1 => "delete", 2 => array("gallery_id" => $this->getAttribute($context["gallery"], "id", array()), "_wpnonce" => ($context["_wpnonce"] ?? null))), "method"), "html", null, true);
            echo "\">
                                    <i class=\"fa fa-trash-o\"></i>
                                    ";
            // line 103
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Delete gallery")), "html", null, true);
            echo "
                                </a>
                                ";
            // line 106
            echo "                                ";
            // line 107
            echo "                                ";
            // line 108
            echo "                                ";
            // line 109
            echo "                                ";
            // line 110
            echo "                                ";
            // line 111
            echo "                            </td>
                        </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['gallery'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 114
        echo "                    </tbody>
                </table>

            </div>
            <div class=\"col-xs-12\">
                <button class=\"button group_button\" id=\"delete-group\" disabled>
                    <i class=\"fa fa-fw fa-trash-o\"></i>";
        // line 120
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "translate", array(0 => "Delete selected"), "method"), "html", null, true);
        echo "
                </button>
            </div>
        </div>
    </section>

    ";
        // line 147
        echo "


    ";
        // line 150
        $context["importTypes"] = $this->loadTemplate("@galleries/shortcode/import.twig", "@galleries/index.twig", 150);
        // line 151
        echo "    <div id=\"importDialog\" title=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Select source to import from")), "html", null, true);
        echo "\" style=\"display: none;\">
        ";
        // line 152
        echo $context["importTypes"]->getshow(400);
        echo "
    </div>

\t";
        // line 155
        $context["form"] = $this->loadTemplate("@core/form.twig", "@galleries/index.twig", 155);
        // line 156
        echo "\t<div id=\"videoUrlAddDialog\" title=\"";
        echo "Add video url";
        echo "\" style=\"display:none;\" data-gallery-id=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["gallery"] ?? null), "id", array()), "html", null, true);
        echo "\">
\t\t<div class=\"sggVideoUrlAddWr\">
\t\t\t<div class=\"sggTableRow\">
\t\t\t\t<div class=\"sggTableColumn6\">
\t\t\t\t\t<div class=\"sggDlgVideoTypeH3\">";
        // line 160
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Video type:")), "html", null, true);
        echo "</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"sggTableColumn6\">
\t\t\t\t\t";
        // line 163
        echo ((((        // line 164
$context["form"]->getradio("sggDlgVideoType", "youtube", array("id" => "sggDlgYoutubeVideoType", "class" => "sggDlgVideoTypeRadio", "checked" => "checked")) .         // line 169
$context["form"]->getlabel(call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Youtube url")), "sggDlgYoutubeVideoType")) . "<br/>") .         // line 173
$context["form"]->getradio("sggDlgVideoType", "vimeo", array("id" => "sggDlgVimeoVideoType", "class" => "sggDlgVideoTypeRadio"))) .         // line 178
$context["form"]->getlabel(call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Vimeo url")), "sggDlgVimeoVideoType"));
        // line 182
        echo "
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"sggTableRow\">
\t\t\t\t<div class=\"sggTableColumn6\">
\t\t\t\t\t<div class=\"sggDlgVideoTypeH3\">";
        // line 187
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Video url:")), "html", null, true);
        echo "</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"sggTableColumn6\">
\t\t\t\t\t";
        // line 190
        echo         // line 191
$context["form"]->getinput("text", "sggDlgUrlVideoValue", "", array("id" => "sggDlgUrlVideoInp", "class" => ""));
        // line 197
        echo "
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"sggTableRow sggAduHiden\" id=\"sggAduErrorText\"></div>
\t\t</div>
\t</div>

";
    }

    // line 126
    public function getputPreset($__data__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "data" => $__data__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 127
            echo "        <div class=\"preset ";
            if ((($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == false) && $this->getAttribute(($context["data"] ?? null), "pro", array()))) {
                echo "disabled";
            }
            echo "\"
             data-preset=\"";
            // line 128
            echo twig_escape_filter($this->env, $this->getAttribute(($context["data"] ?? null), "value", array()), "html", null, true);
            echo "\">
            <p>";
            // line 129
            echo twig_escape_filter($this->env, twig_title_string_filter($this->env, $this->getAttribute(($context["data"] ?? null), "title", array())), "html", null, true);
            echo "</p>
            <img src=\"";
            // line 130
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["environment"] ?? null), "getModule", array(0 => "galleries"), "method"), "getLocationUrl", array(), "method"), "html", null, true);
            echo "/assets/img/";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["data"] ?? null), "image", array()), "html", null, true);
            echo "\" alt=\"\"/>
            ";
            // line 131
            if (($this->getAttribute(($context["data"] ?? null), "pro", array()) && ($this->getAttribute(($context["environment"] ?? null), "isPro", array(), "method") == false))) {
                // line 132
                echo "                <a class=\"button button-primary inPro\"
                    ";
                // line 133
                if (($this->getAttribute(($context["data"] ?? null), "title", array()) == "Categories")) {
                    // line 134
                    echo "                        href=\"http://supsystic.com/plugins/photo-gallery/\" target=\"_blank\">
                    ";
                }
                // line 136
                echo "                    ";
                if (($this->getAttribute(($context["data"] ?? null), "title", array()) == "Icons")) {
                    // line 137
                    echo "                        href=\"http://supsystic.com/plugins/photo-gallery/\" target=\"_blank\">
                    ";
                }
                // line 139
                echo "                    ";
                if (($this->getAttribute(($context["data"] ?? null), "title", array()) == "Pagination")) {
                    // line 140
                    echo "                        href=\"http://supsystic.com/plugins/photo-gallery/\" target=\"_blank\">
                    ";
                }
                // line 142
                echo "                    Available in PRO
                </a>
            ";
            }
            // line 145
            echo "        </div>
    ";
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        } catch (Throwable $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "@galleries/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  424 => 145,  419 => 142,  415 => 140,  412 => 139,  408 => 137,  405 => 136,  401 => 134,  399 => 133,  396 => 132,  394 => 131,  388 => 130,  384 => 129,  380 => 128,  373 => 127,  361 => 126,  350 => 197,  348 => 191,  347 => 190,  341 => 187,  334 => 182,  332 => 178,  331 => 173,  330 => 169,  329 => 164,  328 => 163,  322 => 160,  312 => 156,  310 => 155,  304 => 152,  299 => 151,  297 => 150,  292 => 147,  283 => 120,  275 => 114,  267 => 111,  265 => 110,  263 => 109,  261 => 108,  259 => 107,  257 => 106,  252 => 103,  247 => 101,  243 => 100,  238 => 98,  232 => 96,  225 => 92,  219 => 89,  214 => 87,  208 => 84,  203 => 82,  197 => 79,  191 => 76,  187 => 75,  179 => 72,  170 => 68,  167 => 67,  164 => 66,  161 => 65,  158 => 64,  155 => 63,  153 => 62,  150 => 61,  147 => 60,  144 => 59,  141 => 58,  138 => 57,  136 => 56,  128 => 51,  122 => 50,  116 => 47,  106 => 44,  98 => 42,  94 => 41,  89 => 38,  80 => 36,  76 => 35,  67 => 28,  65 => 26,  64 => 25,  63 => 24,  62 => 23,  61 => 22,  60 => 20,  52 => 14,  49 => 13,  38 => 8,  36 => 7,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@galleries/index.twig", "/www/qprcar01_517/public/wp-content/plugins/gallery-by-supsystic/src/GridGallery/Galleries/views/index.twig");
    }
}
