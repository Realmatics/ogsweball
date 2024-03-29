<?php
/**
* @version		1.5.0
* @package		AceSearch Library
* @subpackage	Search
* @copyright	2009-2011 JoomAce LLC, www.joomace.net
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

//No Permision
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class AcesearchSearch extends JModel {

	var $_data 		 = null;
	var $_total 	 = null;
	var $_refines	 = null;
	var $_pagination = null;
	var $_request    = null;
	
	function __construct() {
		parent::__construct();
		
		$mainframe =& JFactory::getApplication();
		$this->AcesearchConfig = AcesearchFactory::getConfig();
		
		$limit = $mainframe->getUserStateFromRequest('com_acesearch.limit', 'limit', $this->AcesearchConfig->display_limit, 'int');
	
		if ($mainframe->isSite()) { 
			$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
        }
		else {
			$limitstart	= $mainframe->getUserStateFromRequest('limitstart', 'limitstart', 0, 'int');
		}
		
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
	
		$this->_request = self::_getRequest();
	}
	
	function getData() {
		$this->_data = "";

		if (empty($this->_request['query']) && empty($this->_request['exact']) && empty($this->_request['all']) && empty($this->_request['any']) && empty($this->_request['none'])) {
			return $this->_data;
		}
		
		if (empty($this->_request['ext']) || !isset($this->_request['ext'])) {	
			$rows = self::searchAllComponents(); 
		} else{	
			$rows = self::searchComponent($this->_request['ext']);
			
			self::_checkIfIsLucky($rows);
		}
		
		$this->_total = count($rows);
		
		if (!empty($rows)){
			if ($this->AcesearchConfig->google_more_results == '0') {
				usort($rows, array($this, '_orderResults'));
			}
			
			if ($this->getState('limit') > 0) {
				$this->_data = array_splice($rows, $this->getState('limitstart'), $this->getState('limit'));
			} else {
				$this->_data = $rows;
			}
		}

		$suggestions_enabled = ((JFactory::getApplication()->isSite() && $this->AcesearchConfig->enable_suggestion == 1) || (JFactory::getApplication()->isAdmin() && $this->AcesearchConfig->admin_enable_suggestion == 1));
		
		if ($suggestions_enabled && (empty($this->_data) || $this->AcesearchConfig->suggestions_always == '1')) {
			$this->_data['suggest'] = AcesearchSuggestions::getSuggestions(self::getQuery());
		}
		
		if (!empty($this->_data) && (JFactory::getApplication()->isSite()) && ($this->AcesearchConfig->save_results == 1)){ 
			self::_saveResults();
		}
		
		return $this->_data;
	}
	
	function searchAllComponents(){
		$rows = array();
		$cache = AcesearchFactory::getCache();
		
		$filter = AcesearchExtension::getInt('filter');
		if (!empty($filter)) {
			$components = $cache->getFilterExtensions($filter);
		}
		else {
			$components = $cache->getExtensions();
		}
		
		if (empty($components)) {
			return $rows;
		}

        $count = count($components);

		foreach($components as $component) {
			$results = self::searchComponent($component->extension);
			
			if (empty($results)) {
				continue;
			}
			
			$this->_refines[$component->extension] = count($results);

            if ($this->AcesearchConfig->google_more_results == '1' && $count != 1 && empty($filter) && JFactory::getApplication()->isSite()) {

                $prm_results_length = $cache->getExtensionParams($component->extension)->get('google_more_results_length', '');
                if (!empty($prm_results_length)) {
                    $results_length = intval($prm_results_length);
                }
                else {
                    $results_length = $this->AcesearchConfig->google_more_results_length;
                }

                $rows = array_merge($rows, array_splice($results, 0, $results_length));
            }
            else{
                $rows = array_merge($rows, $results);
            }

			self::_checkIfIsLucky($rows);

		}
		
		return $rows;
	}
	
	function searchComponent($component) {
		$params = AcesearchFactory::getCache()->getExtensionParams($component);

		if (empty($params)) {
			return array();
		}
		
		if ($params->get('handler', '1') == '0') {
			return array();
		}
		
		if ($params->get('handler', '1') == '1') {
			$acesearch_ext =& AcesearchFactory::getExtension($component);

			return $acesearch_ext->getResults();
		}
		
		if ($params->get('handler', '1') == '2' && JFactory::getApplication()->isSite()) {
			$query = $phrase = '';
			
			if (!empty($this->_request['query'])) {
				$phrase = 'all';
				$query = $this->_request['query'];
			}
			elseif (!empty($this->_request['any'])) {
				$phrase = 'any';
				$query = $this->_request['any'];
			}
			elseif (!empty($this->_request['exact'])) {
				$phrase = 'exact';
				$query = $this->_request['exact'];
			}
			
			if (empty($query)) {
				return array();
			}
			
			$plugin = AcesearchUtility::findSearchPlugin($component);
			if (!$plugin) {
				return array();
			}

            require_once(JPATH_ADMINISTRATOR.'/components/com_search/helpers/search.php' );
			
			JPluginHelper::importPlugin('search', $plugin);
			$dispatcher =& JDispatcher::getInstance();
			$results = $dispatcher->trigger('onSearch', array($query, $phrase, 'popular', $plugin));
			
			if (empty($results) || !is_array($results) || empty($results[0])) {
				return array();
			}

            $results = $results[0];
			
			$ret_results = array();

			foreach ($results as $result) {
                if (!isset($result->title) || !isset($result->href)) {
                    continue;
                }

                $uri =& JFactory::getURI();

                $result->name = $result->title;
                $result->description = $result->text;
                $result->link = JRoute::_($result->href, false);
                $result->route = $uri->getScheme().'://'.$uri->getHost().$result->link;
                $result->acesearch_ext = $component;

                unset($result->title);
                unset($result->text);
                unset($result->href);

                $ret_results[] = $result;
			}
			
			return $ret_results;
		}
	}
	
	function _checkIfIsLucky($rows) {
		$lucky = JRequest::getInt('lucky');
		
		if ($lucky == 0 || empty($rows) || !isset($rows[0])) {
			return;
		}
		
		$row = $rows[0];
		self::finalizeResult($row);
		
		$mainframe = JFactory::getApplication();
		$mainframe->redirect($row->link);
	}
	
	public function _orderResults($a, $b) {
        $order = JRequest::getWord('order', 'relevance');
        
        if ($order == 'relevance') {
            $order = 'acesearch_relevance';
        }

		if (!isset($a->$order)) {
			return 1;
		}

		if (!isset($b->$order)) {
			return -1;
		}
		
		$a1 = $a->$order;
		$b1 = $b->$order;
		
		if ($a1 == $b1) {
			return 0;
		}
		
		return ($a1 > $b1) ? -1 : 1;
	}
	
	function getComplete() {
		$query = AcesearchExtension::getSecureText(JRequest::getString('q'));
		
		return AceDatabase::loadResultArray("SELECT DISTINCT keyword FROM #__acesearch_search_results WHERE LOWER(keyword) LIKE {$query} AND search_result > '0' GROUP BY keyword ORDER BY search_result DESC");
	}
	
	function finalizeResult(&$row) {
		$site = JFactory::getApplication()->isSite();
		$admin = JFactory::getApplication()->isAdmin();
		
		$params = AcesearchFactory::getCache()->getExtensionParams($row->acesearch_ext);
		
		$q = trim(self::getQuery(), '"');
	
		if (isset($row->acesearch_ext) && isset($row->acesearch_type)) {
			$acesearch_ext =& AcesearchFactory::getExtension($row->acesearch_ext);
			
			$row->properties = '';
			if ((AcesearchUtility::getConfigState($params , 'show_properties'))){
				$function = '_get'.ucfirst($row->acesearch_type).'Properties';
				$acesearch_ext->$function($row);
			}
			
			if (!isset($row->link)) {
				$function = '_get'.ucfirst($row->acesearch_type).'URL';
				$acesearch_ext->$function($row);
				
				$row->route = '';
				if (substr($row->link, 0, 4) == 'http' && (AcesearchUtility::getConfigState($params , 'show_url'))) {
					$row->route = $row->link;
				}
				else {
					$row->link = JRoute::_($row->link, false);
					
					if (AcesearchUtility::getConfigState($params , 'show_url')) {
					    $uri = JFactory::getURI();
						$row->route = rtrim($uri->getScheme().'://'.$uri->getHost(), '/') . '/' . ltrim($row->link, '/');
					}
				}
			}
			
		}
		
		$tlength = "title_length";
		$dlength = "description_length";
		if ($admin) {
			$tlength = "admin_title_length";
			$dlength = "admin_description_length";
		}
		
		if (!empty($row->name) && !empty($this->AcesearchConfig->$tlength)) {
			$row->name = AcesearchUtility::cleanText(substr($row->name, 0, $this->AcesearchConfig->$tlength));
		}
		
		if (empty($row->description) || !isset($row->description) || (AcesearchUtility::getConfigState($params , 'show_desc')==false)) {
			$row->description = "";
		}
		else {
			if (!empty($this->AcesearchConfig->$dlength)) {
				$row->description = strip_tags($row->description);
				$row->description = AcesearchUtility::cleanText(AcesearchUtility::smartSubstr($row->description, $this->AcesearchConfig->$dlength, self::getSearchQuery()));
			}
		} 
		
		// Higlight
		if (!empty($q) && (($this->AcesearchConfig->admin_enable_highlight && $admin) || ($this->AcesearchConfig->enable_highlight && $site))) {
            $i = 1;
			$queries = array_unique(explode(' ', $q));

			foreach ($queries as $query) {
                $query = trim($query);
				if ((strlen($query) < 3) || empty($query)) {
					continue;
				}

    			if (substr_count($q, $query) > 1 ){
    				continue;
    			}

                $back  = 'highlight_back'.$i;
                $clr   = 'highlight_text'.$i;
                $kw = '<_'.$this->AcesearchConfig->$back.'_'.$this->AcesearchConfig->$clr.'>\0<_>';

                $row->name = preg_replace('/' . preg_quote($query, '/') . '/i', $kw, $row->name);
                $row->description = preg_replace('/' . preg_quote($query, '/') . '/i', $kw, $row->description);

                $i++;
                if ($i == 5){
    				$i = 1;
    			}
            }

            $row->name = preg_replace('/\<_([a-zA-Z0-9]+)_([a-zA-Z0-9]+)\>/', '<span class="acesearch_highlight" style="background-color: #$1; color: #$2">', $row->name);
		    $row->name = preg_replace('/\<_\>/', '</span>', $row->name);
            $row->description = preg_replace('/\<_([a-zA-Z0-9]+)_([a-zA-Z0-9]+)\>/', '<span class="acesearch_highlight" style="background-color: #$1; color: #$2">', $row->description);
		    $row->description = preg_replace('/\<_\>/', '</span>', $row->description);
		}
	}
	
	function _saveResults(){
		$date = date("Y-m-d H:d:s");
		$query = trim(self::getQuery(),'"');
		
		if(empty($query) && strlen($query) < 3) {
			return;
		}
		
		$ext = $this->_request['ext'];
		$total = self::getTotal();
			
		if (empty($ext)) {
			$ext = JText::_('COM_ACESEARCH_SEARCH_SECTIONS');
		}
		
		$query = AceDatabase::quote($query);
		$keyword = AceDatabase::loadObject("SELECT id, search_count FROM #__acesearch_search_results WHERE keyword = {$query} AND extension = '{$ext}'");
		
		if (is_object($keyword)) {
			$keyword->search_count ++;
			AceDatabase::query("UPDATE #__acesearch_search_results SET search_result='{$total}', search_count='{$keyword->search_count}', search_date='{$date}' WHERE id = {$keyword->id}");
		}
		else {
			AceDatabase::query("INSERT INTO #__acesearch_search_results (keyword, extension, search_result, search_count, search_date) VALUES ({$query}, '{$ext}', '{$total}', '1', '{$date}')");
		}
	}
	
	function _getRequest() {
		if (JFactory::getApplication()->isAdmin()) {
			$request = JRequest::get('post');
		
			if (empty($request)) {
				$request = JRequest::get('get');
			}
		}
		else {		
			
			$session = JFactory::getSession();
			
			$request = $session->get('acesearch.post');
			
			$_query = $this->getQuery();
            if (empty($_query)) {
                unset($request);
			    $session->clear('acesearch.post');
            }
			
			if (empty($request)) {
				$request = JRequest::get('get');
				$request['ext'] =& JFactory::getURI()->getVar('ext');
				$filter = & JFactory::getURI()->getVar('filter');
				if(!empty($filter)) {
					$request['filter'] =$filter;
				}
			}
		
			if (!empty($request) && is_array($request)) {
				foreach ($request as $key => $value) {
					if (empty($value) || strlen($key) >= '15') {
						unset($request[$key]);
					}
				}
			
				JRequest::set($request, 'post');
			}
			
		}
		
		$request['ext'] = !isset($request['ext']) ? '' : $request['ext'];
		
		return $request;	
	}
	
	public function getQuery($type = '') {
		$query = '';
		
		$qu = strip_tags(JRequest::getString('query', '', $type));
		$ex = strip_tags(JRequest::getString('exact', '', $type));
		$al = strip_tags(JRequest::getString('all', '', $type));
		$an = strip_tags(JRequest::getString('any', '', $type));
	
		if (!empty($qu)){
			$query = $qu;
		}
		elseif(!empty($al)){
			$query = $al;
		}
		elseif(!empty($an)){
			$query = $an;
		}
		elseif(!empty($ex)){
			$query = $ex;
		}
		
		if (empty($query)) {
			return $query;
		}
		
		$badchars = array('#','>','<','\\');
		$query = trim(str_replace($badchars, '', $query));
		
		$query = preg_replace("'<script[^>]*>.*?</script>'si", ' ', $query);
		$query = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '', $query);
		$query = preg_replace('/\s/u', ' ', $query);
		
		while(strpos($query, '  ')) {
			$query = str_replace('  ', ' ', $query);
		}
		
		return $query;
	}
	
	function getSearchQuery() {
		$q = $query = $any = $none = $exact = '';
		
		$query = JRequest::getString('query', '');
		$ex = JRequest::getString('exact', '');
		$al = JRequest::getString('all', '');
		$an = JRequest::getString('any', '');
		$no = JRequest::getString('none', '');

		if (!empty($query)) {
			$q = $query;
		}
		else {
			if (!empty($an)) {
				$q = ' '.$an.' ';
			}

			if (!empty($al)) {
				$q = ' '.$al.' ';
			}

			if (!empty($ex)) {
				$q = ' "'.$ex.'" ';
			}

			if (!empty($no)) {
				$q = ' -'.$no;
			}
		}
		
		//$ret = $this->escape($q);
		$ret = htmlspecialchars($q, ENT_COMPAT, 'UTF-8');
		
		return $ret;
	}
	
	function getTotal() {
		if (empty($this->_total)) {
			$rows = $this->_data;
			
			if (isset($rows['suggest'])) {
				unset($rows['suggest']);
			}
			
			$this->_total = count($rows);	
		}
		
		return $this->_total;
	}
	
	function getRefines() {
		if (empty($this->_refines)) {
			$this->_refines = count($this->_refines);	
		}
		
		return $this->_refines;	
	}
	
	function getPagination(){
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
		}

		return $this->_pagination;
	}
}