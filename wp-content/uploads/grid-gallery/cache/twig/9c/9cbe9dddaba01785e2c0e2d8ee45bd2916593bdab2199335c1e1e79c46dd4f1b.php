<?php

/* @optimization/index.twig */
class __TwigTemplate_d21d3d721366cde298d2b2b884ed14a9f2919825c896943d61634c24020cbad4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("grid-gallery.twig", "@optimization/index.twig", 1);
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
        echo "\t";
        $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 4);
        // line 5
        echo "
    <nav id=\"supsystic-breadcrumbs\" class=\"supsystic-breadcrumbs\">
        <a href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "galleries"), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Galleries")), "html", null, true);
        echo "</a>
        <i class=\"fa fa-angle-right\"></i>
        <a href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute(($context["environment"] ?? null), "generateUrl", array(0 => "optimization"), "method"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Image Optimization")), "html", null, true);
        echo "</a>
    </nav>

    <div class=\"sgg-io-tabs-links-list sgg-main-tab-anch\">
        <a href=\"#\" class=\"sgg-io-tab-link sggActive\" data-tab-id=\"sgg-maintab-image-opt\">
            <i class=\"fa fa-compress\"></i>
            ";
        // line 15
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Image Optimize")), "html", null, true);
        echo "
\t\t\t";
        // line 16
        echo $context["hlp"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Onboard image opimization with TinyPNG. ")) . "<a target='_blank' href='https://supsystic.com/documentation/image-optimize/'>https://supsystic.com/documentation/image-optimize/</a>"), "top", true);
        // line 18
        echo "
        </a>
        <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-maintab-transfer-cdn\">
            <i class=\"fa fa-cloud-upload\"></i>
            ";
        // line 22
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer to CDN")), "html", null, true);
        echo "
\t\t\t";
        // line 23
        echo $context["hlp"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Here you may transfer your gallery images to CDN (Content Delivery Network) in order to reduce your site database load. ")) . "<a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>"), "top", true);
        // line 26
        echo "
        </a>
    </div>
";
    }

    // line 31
    public function block_content($context, array $blocks = array())
    {
        // line 32
        echo "    ";
        $context["imgOptTemplate"] = $this;
        // line 33
        echo "    <div class=\"supsystic-image-optimize\">
        <div class=\"sgg-io-tabs-list sgg-main-tab-anch\">
            <input id=\"sggImgOptMainTabName\" name=\"sggImgOptMainTabName\" value=\"";
        // line 35
        echo twig_escape_filter($this->env, ($context["tabName"] ?? null), "html", null, true);
        echo "\" type=\"hidden\"/>
            <div class=\"sgg-io-one-tab sgg-maintab-image-opt\">
                ";
        // line 37
        echo $context["imgOptTemplate"]->getimageOptimizeMainDialog(($context["imgOptTemplate"] ?? null), ($context["imgOptimizationSett"] ?? null));
        echo "
                ";
        // line 38
        echo $context["imgOptTemplate"]->getimageOptimizeMainTab(($context["imgOptTemplate"] ?? null), ($context["imgOptimizationSett"] ?? null), ($context["galleryList"] ?? null), ($context["statistic"] ?? null));
        echo "
            </div>
            <div class=\"sgg-io-one-tab sgg-maintab-transfer-cdn sgg-io-tab-hidden\">
\t\t\t\t";
        // line 41
        if ((($context["cdnSett"] ?? null) == null)) {
            // line 42
            echo "\t\t\t\t\t<div class=\"sgg-error-list-page\">
\t\t\t\t\t\t<h2>";
            // line 43
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Your host does not support the minimum requirements:")), "html", null, true);
            echo "</h2>
\t\t\t\t\t\t";
            // line 44
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["cdnRequirements"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["elem1"]) {
                // line 45
                echo "\t\t\t\t\t\t\t<h3>";
                echo twig_escape_filter($this->env, $context["elem1"], "html", null, true);
                echo "</h3>
\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['elem1'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 47
            echo "\t\t\t\t\t</div>
\t\t\t\t";
        } else {
            // line 49
            echo "\t\t\t\t\t";
            echo $context["imgOptTemplate"]->gettransferToCdnDialog(($context["cdnSett"] ?? null));
            echo "
\t\t\t\t\t";
            // line 50
            echo $context["imgOptTemplate"]->getimageOptimizeCdnTab(($context["cdnSett"] ?? null), ($context["galleryList"] ?? null));
            echo "
\t\t\t\t\t";
            // line 51
            echo $context["imgOptTemplate"]->getcdnServiceSettingDialog(($context["cdnSett"] ?? null));
            echo "
\t\t\t\t";
        }
        // line 53
        echo "            </div>
        </div>
    </div>
";
    }

    // line 58
    public function getimageOptimizeCdnTab($__cdnSettings__ = null, $__cdnGalleryList__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "cdnSettings" => $__cdnSettings__,
            "cdnGalleryList" => $__cdnGalleryList__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 59
            echo "\t";
            $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 59);
            // line 60
            echo "
    <input type=\"hidden\" id=\"sgg-transfer-to-cdn-used\";/>
    <div class=\"supsystic-io-block sgg-cdn-service-block\">
        <div class=\"supsystic-io-block-table sgg-cnd-service-info\">
            <div class=\"supsystic-io-block-row\">
                <div class=\"supsystic-io-block-cell sgg-io-tab-hidden\">
                    <input value=\"keycdn\" ";
            // line 66
            if (($this->getAttribute(($context["cdnSettings"] ?? null), "current", array()) == "keycdn")) {
                echo " checked=\"checked\" ";
            }
            echo " type=\"radio\" class=\"selected-cnd-opt-service\" name=\"selected-cdn-opt-service\"/>
                </div>
                <div class=\"supsystic-io-block-cell\">
\t\t\t\t\t";
            // line 69
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("KeyCDN")), "html", null, true);
            echo "
\t\t\t\t\t";
            // line 70
            echo $context["hlp"]->getshowTooltip((((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer your galleries to Content Delivery Network. Note: in order to do this, you should be a member of CDN. ")) . "<a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>") . "<br/>") . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Note: before starting the transfer you should press the 'Setup' button, fill in the data and save the settings."))), "top", true);
            // line 74
            echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"supsystic-io-block-cell\">
                    <a href=\"\" class=\"button sgg-setup-button\" data-dialog-code=\"keycdn\"  data-dialog-title=\"";
            // line 77
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("KeyCDN Settings")), "html", null, true);
            echo "\">
                        <i class=\"fa fa-info-circle\"></i>
                        ";
            // line 79
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSettings"] ?? null), "setting", array(), "any", false, true), "keycdn", array(), "any", false, true), "u_name", array(), "any", true, true) && ($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSettings"] ?? null), "setting", array()), "keycdn", array()), "u_name", array()) != ""))) {
                // line 80
                echo "                            ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Change Details")), "html", null, true);
                echo "
                        ";
            } else {
                // line 82
                echo "                            ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Setup")), "html", null, true);
                echo "
                        ";
            }
            // line 84
            echo "                    </a>
                </div>
            </div>
        </div>
    </div>
\t<div class=\"supsystic-io-block sgg-cdn-list\">
\t\t<input id=\"sgg-cdn-auth-sett\" type=\"hidden\" value=\"";
            // line 90
            echo twig_escape_filter($this->env, twig_jsonencode_filter(($context["cdnSettings"] ?? null)), "html", null, true);
            echo "\"/>
        <button class=\"button sgg-transer-to-cdn\" disabled=\"disabled\">";
            // line 91
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer selected")), "html", null, true);
            echo "</button>

        <div class=\"supsystic-io-block-table sgg-transfer-to-cdn-table\">
            <div class=\"supsystic-io-block-row sgg-table-row-header\">
                <div class=\"supsystic-io-block-cell\"></div>
                <div class=\"supsystic-io-block-cell\">";
            // line 96
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Gallery Name")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 97
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Images")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 98
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Size")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 99
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Location")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\"></div>
            </div>

\t\t\t";
            // line 103
            $context["disableTransferBtn"] = false;
            // line 104
            echo "\t\t\t";
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSettings"] ?? null), "setting", array(), "any", false, true), "keycdn", array(), "any", false, true), "u_name", array(), "any", true, true) && ($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSettings"] ?? null), "setting", array()), "keycdn", array()), "u_name", array()) != ""))) {
                // line 105
                echo "\t\t\t\t";
                $context["disableTransferBtn"] = false;
                // line 106
                echo "\t\t\t";
            } else {
                // line 107
                echo "\t\t\t\t";
                $context["disableTransferBtn"] = true;
                // line 108
                echo "\t\t\t";
            }
            // line 109
            echo "
            ";
            // line 110
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["cdnGalleryList"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["gallInfo"]) {
                // line 111
                echo "                <div class=\"supsystic-io-block-row sgg-cdn-info-row-";
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                echo "\">
                    <div class=\"supsystic-io-block-cell\">
\t\t\t\t\t\t<input class=\"sgg-check-gallery-inp\" name=\"sgg-check-gallery-inp\" type=\"checkbox\"
\t\t\t\t\t\t\t   data-gallery-size=\"";
                // line 114
                if ($this->getAttribute($context["gallInfo"], "cdn_size", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "cdn_size", array()), "html", null, true);
                    echo " ";
                } elseif ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "optimized_size", array()), "html", null, true);
                } else {
                    echo "-";
                }
                echo "\"
\t\t\t\t\t\t\t   data-gallery-img-cnt=\"";
                // line 115
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                echo "\" value=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                echo "\"/>
                    </div>
\t\t\t\t\t<div class=\"supsystic-io-block-cell\">";
                // line 117
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "title", array()), "html", null, true);
                echo "</div>
\t\t\t\t\t<div class=\"supsystic-io-block-cell\">
\t\t\t\t\t\t";
                // line 119
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                echo "
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"supsystic-io-block-cell sgg-cdn-info-size\">
\t\t\t\t\t\t";
                // line 122
                if ($this->getAttribute($context["gallInfo"], "cdn_size", array(), "any", true, true)) {
                    // line 123
                    echo "\t\t\t\t\t\t\t";
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["gallInfo"], "cdn_size", array()) . " ") . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
                    echo "
\t\t\t\t\t\t";
                } elseif ($this->getAttribute(                // line 124
$context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                    // line 125
                    echo "\t\t\t\t\t\t\t";
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["gallInfo"], "optimized_size", array()) . " ") . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
                    echo "
\t\t\t\t\t\t";
                } else {
                    // line 126
                    echo "-";
                }
                // line 127
                echo "\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"supsystic-io-block-cell sgg-cdn-info-tr-date\">
\t\t\t\t\t\t";
                // line 129
                if (($this->getAttribute($context["gallInfo"], "cdn_last_transfer_date", array(), "any", true, true) && $this->getAttribute($context["gallInfo"], "cdn_service_name", array(), "any", true, true))) {
                    // line 130
                    echo "\t\t\t\t\t\t\t";
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["gallInfo"], "cdn_service_name", array()) . " / ") . $this->getAttribute($context["gallInfo"], "cdn_last_transfer_date", array())), "html", null, true);
                    echo "
\t\t\t\t\t\t";
                } else {
                    // line 131
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("website")), "html", null, true);
                }
                // line 132
                echo "\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"supsystic-io-block-cell\">
\t\t\t\t\t\t<button class=\"button sgg-transfer-to\" data-gallery-id=\"";
                // line 134
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                echo "\"
\t\t\t\t\t\t\t\t";
                // line 135
                if ((($context["disableTransferBtn"] ?? null) == true)) {
                    echo " ";
                    echo "disabled=\"disabled\"";
                    echo " ";
                }
                // line 136
                echo "\t\t\t\t\t\t\t\tdata-photo-count=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                echo "\"
\t\t\t\t\t\t\t\tdata-img-size=\"";
                // line 137
                if ($this->getAttribute($context["gallInfo"], "cdn_size", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "cdn_size", array()), "html", null, true);
                    echo " ";
                } elseif ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "optimized_size", array()), "html", null, true);
                } else {
                    echo "-";
                }
                echo "\">
\t\t\t\t\t\t\t";
                // line 138
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer to")), "html", null, true);
                echo "
\t\t\t\t\t\t</button>
\t\t\t\t\t</div>
                </div>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['gallInfo'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 143
            echo "        </div>
\t</div>
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

    // line 147
    public function gettransferToCdnDialog($__cdnSettings__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "cdnSettings" => $__cdnSettings__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 148
            echo "\t<div id=\"transfer-to-cdn-dialog\">";
            // line 149
            echo "\t\t<div class=\"sgg-io-tabs-links-list sgg-il-transfer-dialog sgg-io-tab-hidden\">
\t\t\t<a href=\"#\" class=\"sgg-io-tab-link \" data-tab-id=\"sgg-il-transfer-start\">1</a>
\t\t\t<a href=\"#\" class=\"sgg-io-tab-link \" data-tab-id=\"sgg-il-transfer-process\">2</a>
\t\t</div>

\t\t<div class=\"sgg-io-tabs-list sgg-il-transfer-dialog\">
        \t<div class=\"sgg-io-one-tab sgg-il-transfer-start\">
\t\t\t\t<div class=\"sgg-cdndlg-row\">
\t\t\t\t\t";
            // line 157
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer Gallery to")), "html", null, true);
            echo "
\t\t\t\t\t<strong><span class=\"sgg-cdn-service-name\">";
            // line 158
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Servicename")), "html", null, true);
            echo "</span></strong>
\t\t\t\t</div>
\t\t\t\t<div class=\"sgg-cdndlg-row\">
\t\t\t\t\t<strong>";
            // line 161
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total images")), "html", null, true);
            echo ":</strong>
\t\t\t\t\t<span class=\"sgg-cdndlg-img-count\">55</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"sgg-cdndlg-row sgg-cnddlg-imgs-size-row\">
\t\t\t\t\t<strong>";
            // line 165
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total size")), "html", null, true);
            echo ":</strong>
\t\t\t\t\t<span class=\"sgg-cnddlg-imgs-size\">66</span> ";
            // line 166
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb")), "html", null, true);
            echo "
\t\t\t\t</div>
\t\t\t\t";
            // line 169
            echo "\t\t\t\t\t";
            // line 170
            echo "\t\t\t\t\t\t";
            // line 171
            echo "\t\t\t\t\t\t";
            // line 172
            echo "\t\t\t\t\t";
            // line 173
            echo "\t\t\t\t";
            // line 174
            echo "\t\t\t\t<input type=\"hidden\" id=\"sgg-transl-start-transf\" value=\"";
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Start Transfer")), "html", null, true);
            echo "\"/>
\t\t\t</div>

\t\t\t<div class=\"sgg-io-one-tab sgg-il-transfer-process\">
\t\t\t\t<div class=\"sgg-cdndlg-row\">
\t\t\t\t\t";
            // line 179
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Connected to")), "html", null, true);
            echo "
\t\t\t\t\t<strong><span class=\"sgg-cdn-service-name\">Servicename</span></strong>
\t\t\t\t\t";
            // line 181
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("service")), "html", null, true);
            echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"sgg-cdndlg-row\"><strong>";
            // line 183
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer information:")), "html", null, true);
            echo "</strong></div>
\t\t\t\t<div class=\"sgg-cdndlg-row sgg-cdndlg-info\">
\t\t\t\t\t<div class=\"sgg-cdndlg-row\">
\t\t\t\t\t\t<span id=\"sgg-cdn-curr-gallery\">2</span>
\t\t\t\t\t\t";
            // line 187
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("of")), "html", null, true);
            echo "
\t\t\t\t\t\t<span id=\"sgg-cdn-gallery-count\">22</span>
\t\t\t\t\t\t";
            // line 189
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("galleries")), "html", null, true);
            echo "
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"sgg-cdndlg-row\">
\t\t\t\t\t\t<span id=\"sgg-cdn-curr-img\">1</span>
\t\t\t\t\t\t";
            // line 193
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("of")), "html", null, true);
            echo "
\t\t\t\t\t\t<span id=\"sgg-cdn-img-count\">34</span>
\t\t\t\t\t\t<span class=\"sgg-cdn-img-text1\">";
            // line 195
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("images")), "html", null, true);
            echo "</span>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"sgg-cdndlg-row sgg-cdn-info-error\">
\t\t\t\t\t<span>";
            // line 199
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer ending with errors!")), "html", null, true);
            echo "</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"sgg-cdndlg-row sgg-cdn-info-succ\">
\t\t\t\t\t<span>";
            // line 202
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Transfer completed successfully!")), "html", null, true);
            echo "</span>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
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

    // line 209
    public function getimageOptimizeMainDialog($___selfTemplate__ = null, $__ioSetting__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "_selfTemplate" => $___selfTemplate__,
            "ioSetting" => $__ioSetting__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 210
            echo "    <input type=\"hidden\" id=\"sgg-ai-optimize-sel-auth\" value=\"";
            echo twig_escape_filter($this->env, twig_jsonencode_filter(($context["ioSetting"] ?? null)), "html", null, true);
            echo "\"/>
    <div class=\"sgg-io-tabs-links-list sgg-il-optimize-dlg-wnd sgg-io-tab-hidden\">
        <a href=\"#\" class=\"sgg-io-tab-link sggActive\" data-tab-id=\"sgg-il-optimize-start\">FirstPage</a>
        <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-il-optimize-servlist\">Service List</a>
        <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-il-optimize-process\">Image Optimize process</a>
        <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-il-optimize-result\">Image Optimize Result</a>
    </div>

    <!--  sgg-io-tab-hidden -->
    <div class=\"sgg-io-tabs-list sgg-il-optimize-dlg-wnd\">
        <div class=\"sgg-io-one-tab sgg-il-optimize-start sgg-io-tab-hidden\">
\t\t\t<input type=\"hidden\" id=\"sgg-transl-img-opt-1\" value=\"";
            // line 221
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Image optimization")), "html", null, true);
            echo "\"/>
\t\t\t<input type=\"hidden\" id=\"sgg-transl-start-opt-1\" value=\"";
            // line 222
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Start Optimization")), "html", null, true);
            echo "\"/>

            ";
            // line 225
            echo "                ";
            // line 226
            echo "                ";
            // line 227
            echo "                    ";
            // line 228
            echo "                        ";
            // line 229
            echo "                    ";
            // line 230
            echo "                ";
            // line 231
            echo "                    ";
            // line 232
            echo "                ";
            // line 233
            echo "            ";
            // line 234
            echo "
            <div class=\"sgg-il-os-item\">
                <div class=\"sgg-il-os-onerow\">";
            // line 236
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Images")), "html", null, true);
            echo ":
\t\t\t\t\t<div id=\"sgg-il-full-img-cnt-div\" class=\"sgg-il-img-cnt-type-obj\">
\t\t\t\t\t\t<span id=\"sgg-il-amount-img-cnt\">18</span>
\t\t\t\t\t\t(<span class=\"sgg-il-preview-img-cnt\">9</span> preview and <span class=\"sgg-il-original-img-cnt\">9</span> original images)
\t\t\t\t\t</div>
\t\t\t\t</div><br/>
                <div id=\"sgg-iop-totalrow\" class=\"sgg-il-os-onerow\">";
            // line 242
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Size")), "html", null, true);
            echo ":
\t\t\t\t\t<span id=\"sgg-il-gallery-size\">00</span>
\t\t\t\t\t<span id=\"sgg-il-gallery-units\">";
            // line 244
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb")), "html", null, true);
            echo "</span>
\t\t\t\t</div>
            </div>
            <label for=\"sgg-il-backup-img-src\" class=\"sgg-il-os-item\">
                <input id=\"sgg-il-backup-img-src\" class=\"sgg-il-checkbox-prm\" name=\"sgg-il-backup-img-src\" type=\"checkbox\" checked=\"checked\"/>
                ";
            // line 249
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Backup Images Source")), "html", null, true);
            echo "
            </label>
            <label for=\"sgg-il-optimize-preview\" class=\"sgg-il-os-item\">
                <input id=\"sgg-il-optimize-preview\" class=\"sgg-il-checkbox-prm\" name=\"sgg-il-optimize-preview\" type=\"checkbox\" checked=\"checked\"/>
                ";
            // line 253
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize Preview images")), "html", null, true);
            echo "
            </label>
        </div>
        <div class=\"sgg-io-one-tab sgg-il-optimize-servlist sgg-io-tab-hidden\">
            ";
            // line 257
            echo twig_escape_filter($this->env, $this->getAttribute(($context["_selfTemplate"] ?? null), "imageOptimizeServiceSettingTable", array(0 => ($context["_selfTemplate"] ?? null), 1 => ($context["ioSetting"] ?? null)), "method"), "html", null, true);
            echo "
        </div>
        <div class=\"sgg-io-one-tab sgg-il-optimize-process sgg-io-tab-hidden\">
\t\t\t<input type=\"hidden\" id=\"sgg-transl-img-opt-2\" value=\"";
            // line 260
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimization in process...")), "html", null, true);
            echo "\"/>
            <div class=\"sgg-optimize-info sgg-io-tab-hidden\">
                <div>
                    ";
            // line 263
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Connected to")), "html", null, true);
            echo "
                    <strong><span id=\"sgg-conn-to-serv-name\">servicename</span></strong>
                    ";
            // line 265
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("service")), "html", null, true);
            echo "
                </div>
                <div><strong>";
            // line 267
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize:")), "html", null, true);
            echo "</strong></div>
                <div>
                    <span id=\"sgg-opt-curr-gallery\">curr</span>
                    ";
            // line 270
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("of")), "html", null, true);
            echo "
                    <span id=\"sgg-opt-numb-gallery\">numb</span>
                    ";
            // line 272
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("galleries")), "html", null, true);
            echo "
                </div>
                <div>
                    <span id=\"sgg-opt-curr-img\">curr</span>
                    ";
            // line 276
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("of")), "html", null, true);
            echo "
                    <span id=\"sgg-opt-numb-imgs\">numb</span>
                    <span class=\"sgg-iop-without-prev\">";
            // line 278
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("images")), "html", null, true);
            echo "</span>
                    <span class=\"sgg-iop-with-prev\">";
            // line 279
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("images (preview and original images)")), "html", null, true);
            echo "</span>
                </div>
                <div class=\"sgg-opt-info-error sgg-io-tab-hidden\">
                    <span>";
            // line 282
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Error ocured. Optimize process stopped!")), "html", null, true);
            echo "</span>
                </div>
            </div>
        </div>
        <div class=\"sgg-io-one-tab sgg-il-optimize-result sgg-io-tab-hidden\">
\t\t\t<input type=\"hidden\" id=\"sgg-transl-img-opt-3\" value=\"";
            // line 287
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimization complete")), "html", null, true);
            echo "\"/>
            <div class=\"sgg-iores-info\">
                <div class=\"sgg-iores-txt\">
                    ";
            // line 290
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Images size before:")), "html", null, true);
            echo "
                    <span class=\"sgg-iores-tsizebefore\">0</span>
                    ";
            // line 292
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb")), "html", null, true);
            echo "
                </div>
                <div class=\"sgg-iores-txt\">
                    ";
            // line 295
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Images size after:")), "html", null, true);
            echo "
                    <span class=\"sgg-iores-tsizeafter\">0</span>
                    ";
            // line 297
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb")), "html", null, true);
            echo "
                </div>
                <div class=\"sgg-iores-txt\">
                    ";
            // line 300
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Saving:")), "html", null, true);
            echo " <span class=\"sgg-iores-tsaving\">0</span>%
                </div>
            </div>
            <br/>
            <button class=\"button sgg-il-optimize-again-btn\">
                <i class=\"fa fa-compress\"></i>
                ";
            // line 306
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize one more time")), "html", null, true);
            echo "
            </button>
            <br/>
            <a href=\"\" class=\"sgg-iores-link-compare\">
                ";
            // line 310
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Show image comparision")), "html", null, true);
            echo "
            </a>

            <div class=\"supsystic-io-block-table sgg-iores-compare-wrap sgg-io-tab-hidden\">
                <!-- Rows to compare Images -->
            </div>
            <div class=\"sgg-iores-cmp-template sgg-io-tab-hidden\">
                <div class=\"supsystic-io-block-row sgg-compare-first-row\">
                    <div class=\"supsystic-io-block-cell\"><h3>";
            // line 318
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Before")), "html", null, true);
            echo "</h3></div>
                    <div class=\"supsystic-io-block-cell\"><h3>";
            // line 319
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("After")), "html", null, true);
            echo "</h3></div>
                </div>
            </div>
        </div>
    </div>

    ";
            // line 325
            echo twig_escape_filter($this->env, $this->getAttribute(($context["_selfTemplate"] ?? null), "imageOptimizeServiceSettingsDialog", array(0 => ($context["ioSetting"] ?? null)), "method"), "html", null, true);
            echo "
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

    // line 328
    public function getimageOptimizeServiceSettingTable($___selfTemplate__ = null, $__ioSetting__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "_selfTemplate" => $___selfTemplate__,
            "ioSetting" => $__ioSetting__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 329
            echo "\t";
            $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 329);
            // line 330
            echo "
    <div class=\"supsystic-io-block sgg-service-setting\">
        <div class=\"supsystic-io-block-table sgg-service-info\">
            <div class=\"supsystic-io-block-row\">
                <div class=\"supsystic-io-block-cell sgg-io-tab-hidden\">
                    <input value=\"tinypng\" ";
            // line 335
            if (($this->getAttribute(($context["ioSetting"] ?? null), "current", array()) == "tinypng")) {
                echo " checked=\"checked\" ";
            }
            echo " type=\"radio\" class=\"selected-opt-service\" name=\"selected-opt-service\"/>
                </div>
                <div class=\"supsystic-io-block-cell\">
\t\t\t\t\t";
            // line 338
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("TinyPNG")), "html", null, true);
            echo "
\t\t\t\t\t";
            // line 339
            echo $context["hlp"]->getshowTooltip((((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("The intelligent image optimization feature allows you to save bandwidth and make your gallery load faster. ")) . "<a target='_blank' href='https://supsystic.com/documentation/image-optimize/'>https://supsystic.com/documentation/image-optimize/</a> ") . "<br/>") . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Note: before starting the optimization you should press the 'Change Details' button, get your TinyPNG API key and insert it to the text field. Use the tooltip to find the key. "))), "top", true);
            // line 343
            echo "
\t\t\t\t</div>
\t\t\t\t<div class=\"supsystic-io-block-cell\">
                    <a href=\"\" class=\"button sgg-setup-button\" data-dialog-code=\"tinypng\"  data-dialog-title=\"";
            // line 346
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("TinyPNG Settings")), "html", null, true);
            echo "\">
                        <i class=\"fa fa-info-circle\"></i>
                        ";
            // line 348
            if (($this->getAttribute($this->getAttribute($this->getAttribute(($context["ioSetting"] ?? null), "setting", array(), "any", false, true), "tinypng", array(), "any", false, true), "auth_key", array(), "any", true, true) && ($this->getAttribute($this->getAttribute($this->getAttribute(($context["ioSetting"] ?? null), "setting", array()), "tinypng", array()), "auth_key", array()) != ""))) {
                // line 349
                echo "                            ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Change Details")), "html", null, true);
                echo "
                        ";
            } else {
                // line 351
                echo "                            ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Setup")), "html", null, true);
                echo "
                        ";
            }
            // line 353
            echo "                    </a>
                </div>
            </div>
            ";
            // line 357
            echo "                ";
            // line 358
            echo "                    ";
            // line 359
            echo "                ";
            // line 360
            echo "                ";
            // line 361
            echo "                ";
            // line 362
            echo "                    ";
            // line 363
            echo "                        ";
            // line 364
            echo "                        ";
            // line 365
            echo "                    ";
            // line 366
            echo "                ";
            // line 367
            echo "            ";
            // line 368
            echo "        </div>
    </div>
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

    // line 372
    public function getimageOptimizeMainTab($___selfTemplate__ = null, $__ioSetting__ = null, $__galleryList__ = null, $__statistic__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "_selfTemplate" => $___selfTemplate__,
            "ioSetting" => $__ioSetting__,
            "galleryList" => $__galleryList__,
            "statistic" => $__statistic__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 373
            echo "\t";
            $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 373);
            // line 374
            echo "
    <input type=\"hidden\" id=\"sgg-optimize-main-tab-inp\"/>
    ";
            // line 376
            echo twig_escape_filter($this->env, $this->getAttribute(($context["_selfTemplate"] ?? null), "imageOptimizeServiceSettingTable", array(0 => ($context["_selfTemplate"] ?? null), 1 => ($context["ioSetting"] ?? null)), "method"), "html", null, true);
            echo "

    <div class=\"supsystic-io-block sgg-io-stat-block\">
        <!--<div class=\"sgg-io-tabs-links-list sgg-io-stat-anch\">
            <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-io-one-tab\">All</a>
            <a href=\"#\" class=\"sgg-io-tab-link sggActive\" data-tab-id=\"sgg-stat-tab-1\">TinyPNG</a>
            <a href=\"#\" class=\"sgg-io-tab-link\" data-tab-id=\"sgg-stat-tab-2\">Another Service</a>
        </div>-->
        <div class=\"sgg-io-tabs-list sgg-io-stat-anch\">
            <div class=\"sgg-io-one-tab sgg-stat-tab-1\">
                ";
            // line 386
            echo twig_escape_filter($this->env, $this->getAttribute(($context["_selfTemplate"] ?? null), "oneImageOptimizeStatTable", array(0 => "tinypng", 1 => "", 2 => ($context["statistic"] ?? null)), "method"), "html", null, true);
            echo "
            </div>
            <!-- <div class=\"sgg-io-one-tab sgg-stat-tab-2 sgg-io-tab-hidden\">
                ";
            // line 390
            echo "            </div>-->
        </div>
    </div>

    <div class=\"supsystic-io-block sgg-optimize-list\">
        <button class=\"button sgg-optimize-selected\" disabled=\"disabled\">";
            // line 395
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize selected")), "html", null, true);
            echo "</button>
\t\t";
            // line 396
            echo $context["hlp"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("You may choose one, several or all the galleries at once to optimize them. ")) . "<a target='_blank' href='https://supsystic.com/documentation/image-optimize/'>https://supsystic.com/documentation/image-optimize/</a>"), "top", true);
            // line 399
            echo "

        <div class=\"supsystic-io-block-table sgg-gallery-opt-table\">
            <div class=\"supsystic-io-block-row sgg-table-row-header\">
                <div class=\"supsystic-io-block-cell\"></div>
                <div class=\"supsystic-io-block-cell\">";
            // line 404
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Gallery Name")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 405
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Images")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 406
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total Size")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\">";
            // line 407
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimization")), "html", null, true);
            echo "</div>
                <div class=\"supsystic-io-block-cell\"></div>
            </div>
            ";
            // line 410
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["galleryList"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["gallInfo"]) {
                // line 411
                echo "                <div class=\"supsystic-io-block-row\">
                    <div class=\"supsystic-io-block-cell\">
                        <input class=\"sgg-checkb-inp\" type=\"checkbox\" value=\"";
                // line 413
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                echo "\"
                               data-once-optimize=\"";
                // line 414
                if (($this->getAttribute($context["gallInfo"], "last_optimize_date", array(), "any", true, true) && $this->getAttribute($context["gallInfo"], "service_name", array(), "any", true, true))) {
                    echo "1";
                } else {
                    echo "0";
                }
                echo "\"
                               data-gallery-total-size=\"";
                // line 415
                if ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "optimized_size", array()), "html", null, true);
                } else {
                    echo "-";
                }
                echo "\"
                               data-phot-count=\"";
                // line 416
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                echo "\"
                        />
                    </div>
                    <div class=\"supsystic-io-block-cell\">";
                // line 419
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "title", array()), "html", null, true);
                echo "</div>
                    <div class=\"supsystic-io-block-cell\">
                        ";
                // line 421
                echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                echo "
                    </div>
                    <div class=\"supsystic-io-block-cell\">
                        ";
                // line 424
                if ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                    // line 425
                    echo "                            ";
                    echo twig_escape_filter($this->env, (($this->getAttribute($context["gallInfo"], "optimized_size", array()) . " ") . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
                    echo "
                        ";
                } else {
                    // line 427
                    echo "                            -
                        ";
                }
                // line 429
                echo "                    </div>
                    <div class=\"supsystic-io-block-cell\">
                        ";
                // line 431
                if ((($this->getAttribute($context["gallInfo"], "last_optimize_date", array(), "any", true, true) && $this->getAttribute($context["gallInfo"], "service_name", array(), "any", true, true)) && $this->getAttribute($context["gallInfo"], "optimize_percent", array(), "any", true, true))) {
                    // line 432
                    echo "                            ";
                    // line 433
                    echo "                            ";
                    echo twig_escape_filter($this->env, ((($this->getAttribute($context["gallInfo"], "last_optimize_date", array()) . " / ") . $this->getAttribute($context["gallInfo"], "optimize_percent", array())) . "% "), "html", null, true);
                    echo "
                        ";
                } else {
                    // line 435
                    echo "                            ";
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("No")), "html", null, true);
                    echo "
                        ";
                }
                // line 437
                echo "\t\t\t\t\t</div>
                    <div class=\"supsystic-io-block-cell\">
                        ";
                // line 439
                if ($this->getAttribute($context["gallInfo"], "last_optimize_date", array(), "any", true, true)) {
                    // line 440
                    echo "                            <button class=\"button sgg-restore-src-img\" data-gallery-id=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                    echo "\">
                                ";
                    // line 441
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Restore Source Images")), "html", null, true);
                    echo "
                            </button>
                            <div class=\"sgg-opt-twi-button\">
                                <button class=\"button sgg-tbl-optimize-retr\"
                                        data-gallery-id=\"";
                    // line 445
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                    echo "\"
                                        data-gallery-total-size=\"";
                    // line 446
                    if ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                        echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "optimized_size", array()), "html", null, true);
                    } else {
                        echo "-";
                    }
                    echo "\"
                                        data-photo-count=\"";
                    // line 447
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                    echo "\">
                                    ";
                    // line 448
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize")), "html", null, true);
                    echo "
                                </button>
                                <br/><span class=\"sgg-more-info-str\">* one more time</span>
                            </div>
                        ";
                } else {
                    // line 453
                    echo "                            <button class=\"button sgg-restore-src-img sgg-io-tab-hidden\" data-gallery-id=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                    echo "\">
                                ";
                    // line 454
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Restore Source Images")), "html", null, true);
                    echo "
                            </button>
                            <button class=\"button sgg-tbl-optimize-first\"
                                    data-gallery-id=\"";
                    // line 457
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "id", array()), "html", null, true);
                    echo "\"
                                    data-gallery-total-size=\"";
                    // line 458
                    if ($this->getAttribute($context["gallInfo"], "optimized_size", array(), "any", true, true)) {
                        echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "optimized_size", array()), "html", null, true);
                    } else {
                        echo "-";
                    }
                    echo "\"
                                    data-photo-count=\"";
                    // line 459
                    echo twig_escape_filter($this->env, $this->getAttribute($context["gallInfo"], "photo_count", array()), "html", null, true);
                    echo "\">
                                ";
                    // line 460
                    echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Optimize Now")), "html", null, true);
                    echo "
                            </button>
                        ";
                }
                // line 463
                echo "                    </div>
                </div>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['gallInfo'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 466
            echo "        </div>
    </div>
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

    // line 470
    public function getimageOptimizeServiceSettingsDialog($__ioSetting__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "ioSetting" => $__ioSetting__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 471
            echo "    ";
            $context["helper1"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 471);
            // line 472
            echo "
    <div id=\"sggDialogSeviceSetting\" title=\"\" style=\"display:none;\">
        <div class=\"sgg-dialog-block-part sgg-io-tab-hidden\" data-img-opt-sett-code=\"tinypng\">
            <label>
                ";
            // line 476
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your TinyPNG API key")), "html", null, true);
            echo "
                ";
            // line 477
            echo $context["helper1"]->getshowTooltip(call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your name and email address on this <a target='_blank' href='https://tinypng.com/developers'>page</a> to retrieve your API key. On your email will be sent a link to your API key. Follow the link from email and grab your API key.")), "top", true);
            echo "
                <br/>
                <input type=\"text\" class=\"sgg-tinypng-sett-auth-val\" name=\"tinypng-auth-val\" value=\"";
            // line 479
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["ioSetting"] ?? null), "setting", array(), "any", false, true), "tinypng", array(), "any", false, true), "auth_key", array(), "any", true, true)) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["ioSetting"] ?? null), "setting", array()), "tinypng", array()), "auth_key", array()), "html", null, true);
            }
            echo "\"/>
            </label>
            <button class=\"button sgg-setup-button sgg-tinypng-save\" >";
            // line 481
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Save")), "html", null, true);
            echo "</button>
        </div>
    </div>
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

    // line 486
    public function getcdnServiceSettingDialog($__cdnSett__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "cdnSett" => $__cdnSett__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 487
            echo "    ";
            $context["helper1"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 487);
            // line 488
            echo "
    <div id=\"sggCdnDialogSeviceSett\" title=\"\" style=\"display:none;\">
        <div class=\"sgg-dialog-block-part sgg-io-tab-hidden\" data-img-opt-sett-code=\"keycdn\">
            <label>
                ";
            // line 492
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your Site name")), "html", null, true);
            echo "
\t\t\t\t";
            // line 493
            echo $context["helper1"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your KeyCdn Zone name (for example: pz-6f09.kxcdn.com)")) . " <a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>"), "top", true);
            // line 496
            echo "
\t\t\t\t<br/>
                <input type=\"text\" autocomplete=\"off\" class=\"sgg-keycdn-sett-zonename\" name=\"sgg-keycdn-sett-sitename\" value=\"";
            // line 498
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array(), "any", false, true), "keycdn", array(), "any", false, true), "zone_name", array(), "any", true, true)) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array()), "keycdn", array()), "zone_name", array()), "html", null, true);
            }
            echo "\"/>
            </label>
            <br/>
\t\t\t<label>
\t\t\t\t";
            // line 502
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your username")), "html", null, true);
            echo "
\t\t\t\t";
            // line 503
            echo $context["helper1"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your KeyCdn username")) . " <a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>"), "top", true);
            // line 506
            echo "
\t\t\t\t<br/>
\t\t\t\t<input type=\"text\" autocomplete=\"off\" class=\"sgg-keycdn-sett-uname\" name=\"sgg-keycdn-sett-uname\" value=\"";
            // line 508
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array(), "any", false, true), "keycdn", array(), "any", false, true), "u_name", array(), "any", true, true)) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array()), "keycdn", array()), "u_name", array()), "html", null, true);
            }
            echo "\"/>
\t\t\t</label><br/>
\t\t\t<label>
\t\t\t\t";
            // line 511
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your password")), "html", null, true);
            echo "
\t\t\t\t";
            // line 512
            echo $context["helper1"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your KeyCdn password")) . " <a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>"), "top", true);
            // line 515
            echo "
\t\t\t\t<br/>
\t\t\t\t";
            // line 518
            echo "\t\t\t\t<input type=\"password\" autocomplete=\"off\" class=\"sgg-keycdn-sett-upass\" name=\"sgg-keycdn-sett-upass\" value=\"\"/>
\t\t\t</label><br/>
\t\t\t<label>
\t\t\t\t";
            // line 521
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your ftp base path")), "html", null, true);
            echo "
\t\t\t\t";
            // line 522
            echo $context["helper1"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Enter your KeyCdn ftp base path (for example: /pz)")) . " <a target='_blank' href='https://supsystic.com/documentation/transfer-to-cdn/'>https://supsystic.com/documentation/transfer-to-cdn/</a>"), "top", true);
            // line 525
            echo "
\t\t\t\t<br/>
\t\t\t\t<input type=\"text\" class=\"sgg-keycdn-sett-base-ftp\" name=\"sgg-keycdn-sett-base-ftp\" value=\"";
            // line 527
            if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array(), "any", false, true), "keycdn", array(), "any", false, true), "base_ftp_path", array(), "any", true, true)) {
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["cdnSett"] ?? null), "setting", array()), "keycdn", array()), "base_ftp_path", array()), "html", null, true);
            }
            echo "\"/>
\t\t\t</label>
\t\t\t<button class=\"button sgg-setup-button sgg-keycdn-save\" disabled=\"disabled\">";
            // line 529
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Save")), "html", null, true);
            echo "</button>
        </div>
    </div>
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

    // line 534
    public function getoneImageOptimizeStatTable($__serviceCode__ = null, $__tblData__ = null, $__statistic__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "serviceCode" => $__serviceCode__,
            "tblData" => $__tblData__,
            "statistic" => $__statistic__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 535
            echo "\t";
            $context["hlp"] = $this->loadTemplate("@core/helpers.twig", "@optimization/index.twig", 535);
            // line 536
            echo "
    <div class=\"supsystic-io-block-table sgg-service-stat-info\">
        <div class=\"supsystic-io-block-caption\">
            <h4>
                ";
            // line 540
            if ((($context["serviceCode"] ?? null) == "tinypng")) {
                // line 541
                echo "\t\t\t\t\t";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("TinyPNG Statistics")), "html", null, true);
                echo "
\t\t\t\t\t";
                // line 542
                echo $context["hlp"]->getshowTooltip((call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Here you may find the detailed optimization statistics for your gallery. ")) . "<a target='_blank' href='https://supsystic.com/documentation/image-optimize/'>https://supsystic.com/documentation/image-optimize/</a>"), "top", true);
                // line 545
                echo "
                ";
            } else {
                // line 547
                echo "                    ";
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Incorrect service Code")), "html", null, true);
                echo "
                ";
            }
            // line 549
            echo "            </h4>
        </div>

        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\"></div>
            <div class=\"supsystic-io-block-cell\"><span class=\"sgg-text-style1\">";
            // line 554
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Last 24 hours")), "html", null, true);
            echo "</span></div>
            <div class=\"supsystic-io-block-cell\"><span class=\"sgg-text-style1\">";
            // line 555
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Week")), "html", null, true);
            echo "</span></div>
            <div class=\"supsystic-io-block-cell\"><span class=\"sgg-text-style1\">";
            // line 556
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Month")), "html", null, true);
            echo "</span></div>
        </div>
        ";
            // line 559
            echo "        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\">";
            // line 560
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Number of images")), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 561
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 1, array(), "array"), "photo_count", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 562
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 2, array(), "array"), "photo_count", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 563
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 3, array(), "array"), "photo_count", array()), "html", null, true);
            echo "</div>
        </div>
        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\">";
            // line 566
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total size before")), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 567
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 1, array(), "array"), "size_mb", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 568
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 2, array(), "array"), "size_mb", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 569
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 3, array(), "array"), "size_mb", array()), "html", null, true);
            echo "</div>
        </div>
        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\">";
            // line 572
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Total size after")), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 573
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 1, array(), "array"), "optimized_size_mb", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 574
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 2, array(), "array"), "optimized_size_mb", array()), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 575
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 3, array(), "array"), "optimized_size_mb", array()), "html", null, true);
            echo "</div>
        </div>
        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\">";
            // line 578
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Save in Mb")), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 579
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 1, array(), "array"), "save_mb", array()) . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 580
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 2, array(), "array"), "save_mb", array()) . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 581
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 3, array(), "array"), "save_mb", array()) . call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Mb"))), "html", null, true);
            echo "</div>
        </div>
        <div class=\"supsystic-io-block-row\">
            <div class=\"supsystic-io-block-cell\">";
            // line 584
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('translate')->getCallable(), array("Save in %")), "html", null, true);
            echo "</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 585
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 1, array(), "array"), "save_percent", array()), "html", null, true);
            echo "%</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 586
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 2, array(), "array"), "save_percent", array()), "html", null, true);
            echo "%</div>
            <div class=\"supsystic-io-block-cell\">";
            // line 587
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute(($context["statistic"] ?? null), 3, array(), "array"), "save_percent", array()), "html", null, true);
            echo "%</div>
        </div>
    </div>
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
        return "@optimization/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1461 => 587,  1457 => 586,  1453 => 585,  1449 => 584,  1443 => 581,  1439 => 580,  1435 => 579,  1431 => 578,  1425 => 575,  1421 => 574,  1417 => 573,  1413 => 572,  1407 => 569,  1403 => 568,  1399 => 567,  1395 => 566,  1389 => 563,  1385 => 562,  1381 => 561,  1377 => 560,  1374 => 559,  1369 => 556,  1365 => 555,  1361 => 554,  1354 => 549,  1348 => 547,  1344 => 545,  1342 => 542,  1337 => 541,  1335 => 540,  1329 => 536,  1326 => 535,  1312 => 534,  1293 => 529,  1286 => 527,  1282 => 525,  1280 => 522,  1276 => 521,  1271 => 518,  1267 => 515,  1265 => 512,  1261 => 511,  1253 => 508,  1249 => 506,  1247 => 503,  1243 => 502,  1234 => 498,  1230 => 496,  1228 => 493,  1224 => 492,  1218 => 488,  1215 => 487,  1203 => 486,  1184 => 481,  1177 => 479,  1172 => 477,  1168 => 476,  1162 => 472,  1159 => 471,  1147 => 470,  1130 => 466,  1122 => 463,  1116 => 460,  1112 => 459,  1104 => 458,  1100 => 457,  1094 => 454,  1089 => 453,  1081 => 448,  1077 => 447,  1069 => 446,  1065 => 445,  1058 => 441,  1053 => 440,  1051 => 439,  1047 => 437,  1041 => 435,  1035 => 433,  1033 => 432,  1031 => 431,  1027 => 429,  1023 => 427,  1017 => 425,  1015 => 424,  1009 => 421,  1004 => 419,  998 => 416,  990 => 415,  982 => 414,  978 => 413,  974 => 411,  970 => 410,  964 => 407,  960 => 406,  956 => 405,  952 => 404,  945 => 399,  943 => 396,  939 => 395,  932 => 390,  926 => 386,  913 => 376,  909 => 374,  906 => 373,  891 => 372,  874 => 368,  872 => 367,  870 => 366,  868 => 365,  866 => 364,  864 => 363,  862 => 362,  860 => 361,  858 => 360,  856 => 359,  854 => 358,  852 => 357,  847 => 353,  841 => 351,  835 => 349,  833 => 348,  828 => 346,  823 => 343,  821 => 339,  817 => 338,  809 => 335,  802 => 330,  799 => 329,  786 => 328,  769 => 325,  760 => 319,  756 => 318,  745 => 310,  738 => 306,  729 => 300,  723 => 297,  718 => 295,  712 => 292,  707 => 290,  701 => 287,  693 => 282,  687 => 279,  683 => 278,  678 => 276,  671 => 272,  666 => 270,  660 => 267,  655 => 265,  650 => 263,  644 => 260,  638 => 257,  631 => 253,  624 => 249,  616 => 244,  611 => 242,  602 => 236,  598 => 234,  596 => 233,  594 => 232,  592 => 231,  590 => 230,  588 => 229,  586 => 228,  584 => 227,  582 => 226,  580 => 225,  575 => 222,  571 => 221,  556 => 210,  543 => 209,  522 => 202,  516 => 199,  509 => 195,  504 => 193,  497 => 189,  492 => 187,  485 => 183,  480 => 181,  475 => 179,  466 => 174,  464 => 173,  462 => 172,  460 => 171,  458 => 170,  456 => 169,  451 => 166,  447 => 165,  440 => 161,  434 => 158,  430 => 157,  420 => 149,  418 => 148,  406 => 147,  389 => 143,  378 => 138,  367 => 137,  362 => 136,  356 => 135,  352 => 134,  348 => 132,  345 => 131,  339 => 130,  337 => 129,  333 => 127,  330 => 126,  324 => 125,  322 => 124,  317 => 123,  315 => 122,  309 => 119,  304 => 117,  297 => 115,  286 => 114,  279 => 111,  275 => 110,  272 => 109,  269 => 108,  266 => 107,  263 => 106,  260 => 105,  257 => 104,  255 => 103,  248 => 99,  244 => 98,  240 => 97,  236 => 96,  228 => 91,  224 => 90,  216 => 84,  210 => 82,  204 => 80,  202 => 79,  197 => 77,  192 => 74,  190 => 70,  186 => 69,  178 => 66,  170 => 60,  167 => 59,  154 => 58,  147 => 53,  142 => 51,  138 => 50,  133 => 49,  129 => 47,  120 => 45,  116 => 44,  112 => 43,  109 => 42,  107 => 41,  101 => 38,  97 => 37,  92 => 35,  88 => 33,  85 => 32,  82 => 31,  75 => 26,  73 => 23,  69 => 22,  63 => 18,  61 => 16,  57 => 15,  46 => 9,  39 => 7,  35 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@optimization/index.twig", "/www/qprcar01_517/public/wp-content/plugins/gallery-by-supsystic/src/GridGallery/Optimization/views/index.twig");
    }
}
