<?php exit; ?>
1359586427
SELECT * FROM phpbb3010_bbcodes WHERE bbcode_id IN (19, 20)
1344
a:1:{i:0;a:10:{s:9:"bbcode_id";s:2:"20";s:10:"bbcode_tag";s:6:"codex=";s:15:"bbcode_helpline";s:34:"[codex={IDENTIFIER}]{TEXT}[/codex]";s:18:"display_on_posting";s:1:"0";s:12:"bbcode_match";s:34:"[codex={IDENTIFIER}]{TEXT}[/codex]";s:10:"bbcode_tpl";s:356:"<script type="text/javascript" src="syntaxh/scripts/shCore.js"></script>
   <script type="text/javascript" src="syntaxh/scripts/recolect.js"></script>
   <link type="text/css" rel="stylesheet" href="syntaxh/styles/shCoreDefault.css"/>
   <script type="text/javascript">
   loader();
   trans("{TEXT}","{IDENTIFIER}");
   SyntaxHighlighter.all(); 
</script>";s:16:"first_pass_match";s:47:"!\[codex\=([a-zA-Z0-9-_]+)\](.*?)\[/codex\]!ies";s:18:"first_pass_replace";s:143:"'[codex=${1}:$uid]'.str_replace(array("\r\n", '\"', '\'', '(', ')'), array("\n", '"', '&#39;', '&#40;', '&#41;'), trim('${2}')).'[/codex:$uid]'";s:17:"second_pass_match";s:55:"!\[codex\=([a-zA-Z0-9-_]+):$uid\](.*?)\[/codex:$uid\]!s";s:19:"second_pass_replace";s:346:"<script type="text/javascript" src="syntaxh/scripts/shCore.js"></script>
   <script type="text/javascript" src="syntaxh/scripts/recolect.js"></script>
   <link type="text/css" rel="stylesheet" href="syntaxh/styles/shCoreDefault.css"/>
   <script type="text/javascript">
   loader();
   trans("${2}","${1}");
   SyntaxHighlighter.all(); 
</script>";}}