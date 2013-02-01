<?php
/**
* LaTeX Plugin for phpBB - by Hui Chen
* --------------------------------------------------------------------
* @author Hui Chen <usa.chen@gmail.com> http://huichen.org
* @version v0.1 (modified 8/8/11)
* @package phpbb-latex
*/

// Set latex server. If below fails, try: "http://tex.72pines.com/latex.php?latex="
$latex_server="http://tex.72pines.org/latex.php?latex=";

// Find the needle in a haystack
preg_match_all("#\[latex\](.*?)\[/latex\]#si", $message, $tex_matches);

for ($i=0; $i < count($tex_matches[0]); $i++)
{
        $pos = strpos($message, $tex_matches[0][$i]);
        $latex_formula = html_entity_decode($tex_matches[1][$i]);
        $alt_latex_formula = htmlentities($latex_formula, ENT_QUOTES);
        $alt_latex_formula = str_replace("\r","&#13;",$alt_latex_formula);
        $alt_latex_formula = str_replace("\n","&#10;",$alt_latex_formula);
        $url=$latex_server.'$'.urlencode($latex_formula).'$';
        $message = substr_replace($message, "<img src=\"".$url."\" title='".$alt_latex_formula."' alt='".$alt_latex_formula."' class=\"latex\">",$pos,strlen($tex_matches[0][$i]));
}

/** To Install:
1. Upload latex.php to 'includes' folder
2. Open includes/bbcode.php, place: include('latex.php'); at the end (but still inside) bbcode_second_pass function
3. Create new bbcode, adding [latex]{TEXT}[/latex] to BOTH bbcode usage and html replacement. Help line: [latex]e=mc^2[/latex]
4. Use LaTeX in posts like: [latex]E=mc^2[/latex]
*/

?>
