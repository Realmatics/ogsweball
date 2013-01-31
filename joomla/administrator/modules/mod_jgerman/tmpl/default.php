<?php
/**
 * @version    $Id: default.php 42 2009-10-03 12:14:54Z sisko1990 $
 * @author     Jan Erik Zassenhaus (www.jgerman.de)
 * @copyright  Copyright (C) 2005 - 2009 Open Source Matters. All rights reserved.
 * @copyright  Copyright (C) 2009 Jan Erik Zassenhaus. All rights reserved.
 *
 * BugFix: Uwe Walter (www.joomlakom.de)
 * BugFix: Klaus Hils (www.2-it.de)
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die( 'Restricted access' );
?>

<?php
  if($params->get( 'auto_check' ) == 'auto_check_no' && !isset($_POST['check1']) && !isset($_POST['check2'])) {
?>
  <div style="text-align: center;">
    <h3><?php echo JText::_( 'WANT CHECK' ); ?></h3>
    <br />
    <form method="post" action="<?php echo JUri::base();?>index.php">
      <input type="submit" name="check1" value="<?php echo JText::_( 'DO CHECK' ); ?>" />
    </form>
  </div>

<?php
  } elseif($server == 'impossible' && !isset($_POST['check2'])) {
?>
  <div style="text-align: center;">
    <span style="color: red;"><?php echo JText::sprintf('ERROR FSOCK', JTEXT::_( 'CHECK ANYWAY' )); ?></span>
    <br />
    <br />
    <form method="post" action="<?php echo JUri::base();?>index.php">
      <input type="submit" name="check2" value="<?php echo JText::_( 'CHECK ANYWAY' ); ?>" />
    </form>
  </div>
<?php
  } else {
?>
    <table class="adminlist">
      <tr>
        <td class="title">
          <div style="text-align: center;">
            <strong><?php echo JText::_( 'LANGUAGE FRONTEND' ); ?></strong>
        	</div>
        </td>
        <td class="title">
          <div style="text-align: center;">
            <strong><?php echo JText::_( 'LANGUAGE BACKEND' ); ?></strong>
        	</div>
        </td>
      </tr>
      <tr>
        <td>
          <?php
            if($helper->getVersion('frontend') != 'missing' && $server != 'offline' && $server != 'not responding') {
          ?>
            <img src="http://versioncheck.jgerman.de/lang/<?php echo $helper->getVersion('frontend'); ?>/<?php echo $helper->imagesize; ?>" alt="Frontend" style="display: block; margin: 0px auto;" />
          <?php
            } elseif($server == 'offline') {
            ?>
              <div style="text-align: center;">
                <?php echo JText::_( 'SERVER OFFLINE' ); ?>
              </div>
          <?php
            } elseif ($server == 'not responding') {
          ?>
              <div style="text-align: center;">
                <?php echo JText::_( 'SERVER NOT RESPONDING' ); ?>
              </div>
          <?php
            } else {
          ?>
              <div style="text-align: center;">
                <?php echo JText::_( 'LANGUAGE NOT INSTALLED' ); ?>
              </div>
          <?php
              }
          ?>
        </td>
        <td>
          <?php
            if($helper->getVersion('backend') != 'missing' && $server != 'offline' && $server != 'not responding') {
          ?>
            <img src="http://versioncheck.jgerman.de/lang/<?php echo $helper->getVersion('backend'); ?>/<?php echo $helper->imagesize; ?>" alt="Backend" style="display: block; margin: 0px auto;" />
          <?php
            } elseif($server == 'offline') {
            ?>
              <div style="text-align: center;">
                <?php echo JText::_( 'SERVER OFFLINE' ); ?>
              </div>
          <?php
            } elseif ($server == 'not responding') {
          ?>
              <div style="text-align: center;">
                <?php echo JText::_( 'SERVER NOT RESPONDING' ); ?>
              </div>
          <?php
            } else {
          ?>
              <div style="text-align: center;">
                <?php echo JText::_( 'LANGUAGE NOT INSTALLED' ); ?>
              </div>
          <?php
              }
          ?>
        </td>
      </tr>
      <?php
        if($params->get( 'check_core' ) == 'check_core_show') {
      ?>
        <tr>
          <td colspan="2">
            <div style="text-align: center;">
              <strong><?php echo JText::_( 'JOOMLA CORE' ); ?></strong>
            </div>
            <?php
              if($server != 'offline' && $server != 'not responding') {
            ?>
              <img src="http://versioncheck.jgerman.de/core/<?php echo JVERSION; ?>/<?php echo $helper->imagesize; ?>" alt="Joomla!-Core" style="display: block; margin: 0px auto;" />
            <?php
              } elseif ($server == 'not responding') {
            ?>
                <div style="text-align: center;">
                  <?php echo JText::_( 'SERVER NOT RESPONDING' ); ?>
                </div>
            <?php
              } else {
            ?>
                <div style="text-align: center;">
                  <?php echo JText::_( 'SERVER OFFLINE' ); ?>
                </div>
            <?php
              }
            ?>
          </td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
      if($params->get( 'delete_notice' ) == 'delete_notice_show') {
    ?>
      <?php echo JText::_( 'DELETE MODULE' ); ?>
    <?php
      }
    }
  ?>
  <hr />
  <div style="text-align: center;">
    <strong><?php echo JText::sprintf( 'SERVICE BY' , '<a href="http://www.jgerman.de" target="_blank">www.jgerman.de</a>' ); ?></strong>
  </div>