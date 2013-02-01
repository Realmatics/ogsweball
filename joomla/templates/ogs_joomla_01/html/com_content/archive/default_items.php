<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers'); 

require_once dirname(__FILE__) . str_replace('/', DIRECTORY_SEPARATOR, '/../../../functions.php');

$component = new ArtxContent($this, $this->params);
?>
<ul id="archive-items">
<?php foreach ($this->items as $i => $item) : ?>
    <li class="row<?php echo $i % 2; ?>">
<?php
$article = $component->article('archive', $item, $this->params);
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
if (strlen($article->hits))
    $params['metadata-header-icons'][] = $article->hitsInfo($article->hits);
// Build article content
$content = '';
if (strlen($article->intro))
    $content .= $article->intro($article->intro);
	

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


$params['content'] = $content;
// Change the order of "if" statements to change the order of article metadata footer items.
if (strlen($article->category))
  $params['metadata-footer-icons'][] = "<span class=\"my-postcategoryicon\">"
    . $article->categories($article->parentCategory, $article->parentCategoryLink, $article->category, $article->categoryLink)
    . "</span>";
// Render article
echo $article->article($params);

?>
    </li>
<?php endforeach; ?>
</ul>
<div class="pagination">
    <p class="counter">
        <?php echo $this->pagination->getPagesCounter(); ?>
    </p>
    <?php echo $this->pagination->getPagesLinks(); ?>
</div>
