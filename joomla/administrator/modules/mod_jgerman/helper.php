<?php
/**
 * @version    $Id: helper.php 466 2009-03-27 21:52:38Z sisko1990 $
 * @author     Jan Erik Zassenhaus (www.jgerman.de)
 * @copyright  Copyright (C) 2005 - 2009 Open Source Matters. All rights reserved.
 * @copyright  Copyright (C) 2009 Jan Erik Zassenhaus. All rights reserved.
 *
 * BugFix: Uwe Walter (admin@joomlakom.de)
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die( 'Restricted access' );


class modJGermanHelper
{
  var $language;
  var $imagesize;
  var $url;
  var $fsock;
  var $curl;

  function modJGermanHelper($params)
  {
    $this->language  = $params->get('select_language');
    $this->imagesize = $params->get('image_size');
    $this->url       = 'www.jgerman.de';
  }

  function getAvailable()
  {
    // Check if server is available
    if (function_exists('fsockopen')) {
      $this->fsock = @fsockopen($this->url, 80, $errno, $errstr, 3);

      if (!$this->fsock) {
        return 'offline';
      } else {
        $get  = "GET / HTTP/1.1\r\n";
        $get .= "Host: ".$this->url."\r\n";
        $get .= "Connection: Close\r\n\r\n";
        @fwrite($this->fsock, $get);
        stream_set_timeout($this->fsock, 5);

        if (! @fgets($this->fsock, 16)) {
          return 'not responding';
        }	else {
          return 'online';
        }
      }
      @fclose($this->fsock);

    } elseif (function_exists('curl_init')) {
      $this->curl = @curl_init('http://'.$this->url);

      curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 3);
      curl_setopt($this->curl, CURLOPT_TIMEOUT, 5);
      curl_setopt($this->curl, CURLOPT_FAILONERROR, 1);
      curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

      curl_exec($this->curl);

      $errno = curl_errno($this->curl);

      if ($errno == 7) {
        return 'offline';
      } elseif ($errno > 7) {
        return 'not responding';
      } else {
        return 'online';
      }

      @curl_close($this->curl);
    } else {
      return 'impossible';
    }
  }

  function getVersion($section)
  {
    if ($section == 'frontend') {
      $client_nr = '0';
    } else {
      $client_nr = '1';
    }

    $client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', $client_nr, '', 'int'));

    // Load folder filesystem class
    jimport('joomla.filesystem.folder');
    $path = JLanguage::getLanguagePath($client->path);

    $language_path = $path.DS.$this->language.DS.$this->language.'.xml';

    if (file_exists($language_path)) {
      $data = JApplicationHelper::parseXMLLangMetaFile($language_path);
      return $data['version'];
    } else {
      return 'missing';
    }
  }
}
?>