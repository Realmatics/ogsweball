<?php
/**
 * LaTeX Plugin for phpBB - by Hui Chen
 * --------------------------------------------------------------------
 * @author Hui Chen <usa.chen@gmail.com> http://huichen.org
 * @version v0.1
 * @package phpbb-latex
 */
    $latex_server="http://tex.72pines.org/latex.php?latex=";
// if above server fails, try following
//    $latex_server="http://tex.72pines.com/latex.php?latex=";
    preg_match_all("#\[tex\](.*?)\[/tex\]#si",$text,$tex_matches);
    for ($i=0; $i < count($tex_matches[0]); $i++) {
        $pos = strpos($text, $tex_matches[0][$i]);
        $latex_formula = html_entity_decode($tex_matches[1][$i]);
	$alt_latex_formula = htmlentities($latex_formula, ENT_QUOTES);
	$alt_latex_formula = str_replace("\r","&#13;",$alt_latex_formula);
	$alt_latex_formula = str_replace("\n","&#10;",$alt_latex_formula);
	$url=$latex_server.'$'.urlencode($latex_formula).'$';
        $text = substr_replace($text, "<img src=\"".$url."\" title='".$alt_latex_formula."' alt='".$alt_latex_formula."' class=\"latex\">",$pos,strlen($tex_matches[0][$i]));
    }
?>
