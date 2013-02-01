<?php
defined('_JEXEC') or die;

require_once dirname(__FILE__) . str_replace('/', DIRECTORY_SEPARATOR, '/../../../functions.php');

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$component = new ArtxContent($this, $this->params);
$article = $component->article('article', $this->item, $this->item->params, array('print' => $this->print));

echo $component->beginPageContainer('item-page');
if (strlen($article->pageHeading))
    echo $component->pageHeading($article->pageHeading);
$params = $article->getArticleViewParameters();
if (strlen($article->title)) {
    $params['header-text'] = $this->escape($article->title);
    if (strlen($article->titleLink))
        $params['header-link'] = $article->titleLink;
}
// Change the order of "if" statements to change the order of article metadata header items.
if (strlen($article->created))
    $params['metadata-header-icons'][] = "<span class=\"my-postdateicon\">" . $article->createdDateInfo($article->created) . "</span>";
if (strlen($article->modified))
    $params['metadata-header-icons'][] = "<span class=\"my-postdateicon\">" . $article->modifiedDateInfo($article->modified) . "</span>";
if (strlen($article->published))
    $params['metadata-header-icons'][] = "<span class=\"my-postdateicon\">" . $article->publishedDateInfo($article->published) . "</span>";
if (strlen($article->author))
    $params['metadata-header-icons'][] = "<span class=\"my-postauthoricon\">" . $article->authorInfo($article->author, $article->authorLink) . "</span>";
if ($article->printIconVisible)
    $params['metadata-header-icons'][] = $article->printIcon();
if ($article->emailIconVisible)
    $params['metadata-header-icons'][] = $article->emailIcon();
if ($article->editIconVisible)
    $params['metadata-header-icons'][] = $article->editIcon();
if (strlen($article->hits))
    $params['metadata-header-icons'][] = $article->hitsInfo($article->hits);
// Build article content
$content = '';
if (!$article->introVisible)
    $content .= $article->event('afterDisplayTitle');
$content .= $article->event('beforeDisplayContent');
if (strlen($article->toc))
    $content .= $article->toc($article->toc);
if (strlen($article->text))
    $content .= $article->text($article->text);
if ($article->introVisible)
    $content .= $article->intro($article->intro);
if (strlen($article->readmore))
    $content .= $article->readmore($article->readmore, $article->readmoreLink);
$content .= $article->event('afterDisplayContent');


// Start - Mein Zusatz
$dec_ea = $_GET["_search_"];
if ($dec_ea != ""){
$sep=" ";
$arrayser = explode($sep,$dec_ea);
for ($i = 0; $i < count($arrayser); $i++){
$pos=0;
for ($ia = 0; $ia < substr_count($content, $arrayser[$i])+1; $ia++){
$posa = stripos($content, $arrayser[$i], $pos);
$contentdavorl = $posa-$pos;
$contentdavor = substr($content, $pos, $contentdavorl);
$contentdavorla = $posa;
$contentdavora = substr($content, 0, $contentdavorla);
$contentdavorab[$ia] = $contentdavora;
$checkstart = substr_count($contentdavora, '<');
$checkende = substr_count($contentdavora, '>');
$checkerg = $checkende - $checkstart;
$contentgefundenl = strlen($arrayser[$i]);
$contentgefunden = substr($content, $posa, $contentgefundenl);
$posa = $posa + $contentgefundenl;
$contentdanach = substr($content, $posa);
$contentersetzdavor='<font style="background-color:yellow; font-weight:bold;">';
$contentersetzdavorl=strlen($contentersetzdavor);
$contentersetzdanach='</font>';
$contentersetzdanachl=strlen($contentersetzdanach);
if ($checkerg >= 0)
{
$contentgefunden = str_ireplace( ''.$arrayser[$i].'', ''.$contentersetzdavor.$arrayser[$i].$contentersetzdanach.'', $contentgefunden );
}
$content = $contentdavora.$contentgefunden.$contentdanach;
$pos=$posa+$contentersetzdavorl+$contentersetzdanachl;
}}}
// Ende - Mein Zusatz



/*
for ($i=0, $count = count($results); $i < $count; $i++)
			{
				$row = &$results[$i]->text;

				if ($state->get('match') == 'exact') {
					$searchwords = array($searchword);
					$needle = $searchword;
				}
				else {
					$searchworda = preg_replace('#\xE3\x80\x80#s', ' ', $searchword);
					$searchwords = preg_split("/\s+/u", $searchworda);
 					$needle = $searchwords[0];
				}

				$row = SearchHelper::prepareSearchContent($row, $needle);
				$searchwords = array_unique($searchwords);
				$searchRegex = '#(';
				$x = 0;

				foreach ($searchwords as $k => $hlword)
				{
					$searchRegex .= ($x == 0 ? '' : '|');
					$searchRegex .= preg_quote($hlword, '#');
					$x++;
				}
				$searchRegex .= ')#iu';

				$row = preg_replace($searchRegex, '<span class="highlight">\0</span>', $row);

				$result = &$results[$i];
				if ($result->created) {
					$created = JHtml::_('date', $result->created, JText::_('DATE_FORMAT_LC3'));
				}
				else {
					$created = '';
				}

				$result->text		= JHtml::_('content.prepare', $result->text, '', 'com_search.search');
				$result->created	= $created;
				$result->count		= $i + 1;
			}


$content = $result->text;
*/

//$params['content'] = '0:'.$contentdavorab[0].'<br>1:'.$contentdavorab[1].'<br>2:'.$contentdavorab[2].'<br>3:'.$contentdavorab[3];
$params['content'] = $content;
// Change the order of "if" statements to change the order of article metadata footer items.
if (strlen($article->category))
  $params['metadata-footer-icons'][] = "<span class=\"my-postcategoryicon\">"
    . $article->categories($article->parentCategory, $article->parentCategoryLink, $article->category, $article->categoryLink)
    . "</span>";
// Render article
echo $article->article($params);
echo $component->endPageContainer();



