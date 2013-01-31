<?php
defined('_JEXEC') or die;

/**
 * Template for Joomla! CMS, created with Artisteer.
 * See readme.txt for more details on how to use the template.
 */



require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';

// Create alias for $this object reference:
$document = & $this;

// Shortcut for template base url:
$templateUrl = $document->baseurl . '/templates/' . $document->template;

// Initialize $view:
$view = $this->artx = new ArtxPage($this);

// Decorate component with Artisteer style:
$view->componentWrapper();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $document->language; ?>" lang="<?php echo $document->language; ?>" dir="ltr">
<head>
 <jdoc:include type="head" />
 <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/system.css" type="text/css" />
 <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/general.css" type="text/css" />
 <link rel="stylesheet" type="text/css" href="<?php echo $templateUrl; ?>/css/template.css" media="screen" />
 <!--[if IE 6]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie6.css" type="text/css" media="screen" /><![endif]-->
 <!--[if IE 7]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie7.css" type="text/css" media="screen" /><![endif]-->
 <script type="text/javascript">if ('undefined' != typeof jQuery) document._artxJQueryBackup = jQuery;</script>
 <script type="text/javascript" src="<?php echo $templateUrl; ?>/jquery.js"></script>
 <script type="text/javascript">jQuery.noConflict();</script>
 <script type="text/javascript" src="<?php echo $templateUrl; ?>/script.js"></script>
 <script type="text/javascript">if (document._artxJQueryBackup) jQuery = document._artxJQueryBackup;</script>
 <script type="text/javascript" src="<?php echo $templateUrl; ?>/js.js"></script>
</head>
<body onload="onload()">
<div id="my-main">
    <div class="cleared reset-box"></div>
<div class="my-box my-sheet">
    <div class="my-box-body my-sheet-body">
<div class="my-header">
  <div id="line">
          
  <div id="hoverthermo" style="visibility: hidden;"></div>
  <div id="selthermo" onmouseover="showInfo()" onmouseout="clearInfo()">&nbsp;</div>
  
  <div id="hoverhydro" style="visibility: hidden;"></div>
  <div id="selhydro" onmouseover="showInfo1()" onmouseout="clearInfo()">&nbsp;</div>
  
  <div id="hovermechanical" style="visibility: hidden;"></div>
  <div id="selmechanical" onmouseover="showInfo2()" onmouseout="clearInfo()">&nbsp;</div>
  
  <div id="hoverchemical" style="visibility: hidden;"></div>
  <div id="selchemical" onmouseover="showInfo3()" onmouseout="clearInfo()">&nbsp;</div>
    
    
                <!-- /*<div id="fontsize"></div>*/ -->
                                        <h3 class="unseen"><?php echo JText::_('TPL_BEEZ2_SEARCH'); ?></h3>
                                        <jdoc:include type="modules" name="position-0" />
                                        </div> <!-- end line -->
<div class="my-logo">
</div>
<?php if ($view->containsModules('position-1', 'position-28', 'position-29')) : ?>
<div class="my-bar my-nav">
<div class="my-nav-outer">
<div class="my-nav-wrapper">
<div class="my-nav-inner">
  <?php if ($view->containsModules('position-28')) : ?>
  <div class="my-hmenu-extra1"><?php echo $view->position('position-28'); ?></div>
  <?php endif; ?>
  <?php if ($view->containsModules('position-29')) : ?>
  <div class="my-hmenu-extra2"><?php echo $view->position('position-29'); ?></div>
  <?php endif; ?>
  <?php echo $view->position('position-1'); ?>
</div>
</div>
</div>
</div>
<div class="cleared reset-box"></div>
<?php endif; ?>

</div>
<div class="cleared reset-box"></div>
<?php echo $view->position('position-15', 'my-nostyle'); ?>
<?php echo $view->positions(array('position-16' => 33, 'position-17' => 33, 'position-18' => 34), 'my-block'); ?>
<div class="my-layout-wrapper">
    <div class="my-content-layout">
        <div class="my-content-layout-row">
<div class="my-layout-cell my-content">

<?php
  echo $view->position('position-19', 'my-nostyle');
  if ($view->containsModules('position-2'))
    echo artxPost($view->position('position-2'));
  echo $view->positions(array('position-20' => 50, 'position-21' => 50), 'my-article');
  echo $view->position('position-12', 'my-nostyle');
  if ($view->hasMessages())
    echo artxPost('<jdoc:include type="message" />');
  echo '<jdoc:include type="component" />';
  echo $view->position('position-22', 'my-nostyle');
  echo $view->positions(array('position-23' => 50, 'position-24' => 50), 'my-article');
  echo $view->position('position-25', 'my-nostyle');
?>

  <div class="cleared"></div>
</div>

        </div>
    </div>
</div>
<div class="cleared"></div>


<?php echo $view->positions(array('position-9' => 33, 'position-10' => 33, 'position-11' => 34), 'my-block'); ?>
<?php echo $view->position('position-26', 'my-nostyle'); ?>
<div class="my-footer">
    <div class="my-footer-body">
     <div class="my-rss-tag-icon" id="showrss">
  <a href="http://opengeosys.org/?format=feed&type=rss">
          <img class="rss" src="http://opengeosys.org/templates/ogs_joomla_01/images/livemarks.png" height="30" width="19" border="0">
         </a>  
     </div>
        <?php echo $view->position('position-14'); ?>
                <div class="my-footer-text">
                    <?php if ($view->containsModules('position-27')): ?>
                    <?php echo $view->position('position-27', 'my-nostyle'); ?>
                    <?php else: ?>
                    <?php ob_start(); ?>
<!-- <p><a href="#">Link1</a> | <a href="#">Link2</a> | <a href="#">Link3</a></p>-->
                  <p>This work is licensed under a Creative Commons Attribution-NoDerivs 3.0 Unported License. Additional information on this license can be found here.</p> 

                    <?php echo str_replace('%YEAR%', date('Y'), ob_get_clean()); ?>
                    <?php endif; ?>
               </div>
        <div class="cleared"></div>
    </div>
</div>

    <div class="cleared"></div>
    </div>
</div>
<div class="cleared"></div>
<p class="my-page-footer"></p>

    <div class="cleared"></div>
</div>

<?php echo $view->position('debug'); ?>
</body>
</html>