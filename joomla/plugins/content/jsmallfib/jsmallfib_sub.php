<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$dir_old = $dir;
//$dir = $dir."/test3/";
//$vertiz= "1";
//$vertiz=$_GET["vertiz"];
//$vertiz=$a_dir;
$dir = $dir."/".$a_dir;
$a1_dir=$a_dir;
//echo $vertiz;
//echo $dir;
//echo "12";
$vertiz1=0;
$vertiz--;
//$vertiz=0;



if($open_dir = @opendir(html_entity_decode(str_replace("\\", "/", $dir."/"))))
		{
			$dirssub = array();
			$filessub = array();
			$dirssub[$vertiz] = array();
			$filessub[$vertiz] = array();
			$i = 0;
			while ($it = @readdir($open_dir)) 
			{
				if($it != "." && $it != "..")
				{
					if(is_dir($dir.DS.$it))
					{
						if(!in_array($it, $hidden_folders))
							$dirssub[$vertiz][] = htmlspecialchars($it);
					}
					//else if(!in_array($it, $hidden_files) && !in_array("*.".$this->fileExtension($it), $hidden_extensions[0]))
					else if(!in_array($it, $hidden_files))
					{
						$matched_prefix = 0;
						for ($k = 0; $k < count($hidden_prefixes[0]); $k++)
						{
							if (!strncasecmp($hidden_prefixes[0][$k], $it, strlen($hidden_prefixes[0][$k]) - 1))
								$matched_prefix = 1;
						}

						$matched_extension = 0;
						for ($k = 0; $k < count($hidden_extensions[0]); $k++)
						{
							if (!strncasecmp(strrev($hidden_extensions[0][$k]), strrev($it), strlen($hidden_extensions[0][$k]) - 1))
								$matched_extension = 1;
						}

						// file list filtering
						$file_filter_pattern_matched = 0;
						if ($file_filter_pattern_required)
						{
							$pattern_array = explode(";", $this->chosen_decoding($_COOKIE['current_filter_list']));
							for ($k = 0; $k < count($pattern_array); $k++)
							{
								if (stristr($it, trim($pattern_array[$k])))
								{
									$file_filter_pattern_matched = 1;
								}
							}
						}

						if (!$matched_prefix && !$matched_extension && (!$file_filter_pattern_required || $file_filter_pattern_matched))
						{
							//$files[$i] = $files.$vertiz[$i];
						
							$filessub[$vertiz][$i]["name"]	= htmlspecialchars($it);
							$it			= $dir."/".$it;
							$filessub[$vertiz][$i]["extension"]	= $this->fileExtension($it);
							$filessub[$vertiz][$i]["size"]	= $this->fileRealSize($it);
							$filessub[$vertiz][$i]["changed"]	= filemtime($it);							
							$i++;
						}
					}
				}
			}
			@closedir($open_dir);
		}
		else
		{
			$text  = "<div id='JS_MAIN_DIV'><div id='JS_ERROR_DIV'><table><tr>"
				."<td class='alertIcon'><img src=\"".$this->imgdirNavigation."warning.png\"></td><td>".JText::sprintf('dir_not_found', $this->chosen_encoding($current_position), $this->default_absolute_path)."</td>"
				."</tr></table></div></div>";

			$article->text = $article->fulltext = $article->introtext = $text_array[0].$text.$text_array[1];
			return;
		}
		


		
		
// Subfolders first
		if ($dirssub[$vertiz])
		{
			foreach ($dirssub[$vertiz] as $a_dir)
			{
				$row_style = ($row ? "odd" : "even"); 
				$htref="/";
				$realdir=$dir.$htref.$a_dir;
				
				if ($this->line_height)
				{
					$text .= "<tr class='jsmalline'><td colspan='$rowColspan'></td></tr>";
				}

				// different line if editing name or not
				if (isset($_GET['old_foldername']) && strlen($_GET['old_foldername']) && !strcmp($_GET['old_foldername'], $a_dir))   // Removed urldecode on _GET /ErikLtz
				{
					$text .= "<form action='".$this->baselink."&dir=".urlencode($masked_dir)."' method='post'>"
						."<tr class='row $row_style'>"
						."	<td class='fileIcon'>"
						."	<img src=\"".$this->imgdirNavigation."folder.png\" width='".$this->icon_width."' />"
						."	</td>"
						."	<td class='fileName'>"
						."	<input name='new_foldername' type='text' value=\"".$this->chosen_encoding($a_dir)."\" />"
						."	</td>"
						."	<td colspan='3' class='emptyTd'></td>"
						."	<td class='fileAction'>"
						."	<input type='image' src=\"".$this->imgdirNavigation."tick.png\" title=\"".JText::_('rename_folder_title')."\" />"
						."	</td>"
						."	<td class='fileAction'><a href='".$this->baselink."&dir=".$this->urlEncodePreserveForwardSlashes($masked_dir)."'>".JText::_('rename_folder_cancel')."</a></td>"
						."</tr>"
						."	<input type='hidden' name='old_foldername' value=\"".urlencode($a_dir)."\" />"
						."</form>";
				}
				else
				{
					$text .= "<tr class='row $row_style' onmouseover='this.className=\"highlighted\"' onmouseout='this.className=\"row $row_style\"'>"
						."	<td width='100px'><img src=\"".$this->imgdirNavigation."subs.png\" width='18' style='margin:0; padding:0px 0px 6px 40px;'/>"
						."	<a href='".$this->baselink."&dir=".$this->urlEncodePreserveForwardSlashes($masked_dir."/".$a1_dir."/".$a_dir)."'>"
                                                            ."<img src=\"".$this->imgdirNavigation."folder.png\" width='".$this->icon_width."' /></a>"
						."	</td>"
						."	<td class='fileName'>"
						."	<a href='".$this->baselink."&dir=".$this->urlEncodePreserveForwardSlashes($masked_dir."/".$a1_dir."/".$a_dir)."'>".$this->chosen_encoding($a_dir)."</a>"
						//."	<a href='".$this->baselink."&dir=".str_replace("%2F", "/", urlencode($masked_dir))."/".str_replace("%2F", "/", urlencode($a_dir))."'>".$this->chosen_encoding($a_dir)."</a>"
						//."	<a href='".$this->baselink."&dir=".urlencode($masked_dir).DS.urlencode($a_dir)."'>".$this->chosen_encoding($a_dir)."</a>" // THIS WAS THE ORIGINAL LINE (changed for Paul Tease 20110909)
						//."	<a href='".$this->baselink."&dir=".urlencode($masked_dir."/".$a_dir)."'>".$this->chosen_encoding($a_dir)."</a>"
						."	</td>"
						."	<td colspan='3' class='emptyTd'></td>";
					if($access_rights > 2)
					{
						$text .= "<td class='fileAction'>"
							."<a href='".$this->baselink."&dir=".$this->urlEncodePreserveForwardSlashes($masked_dir)."&old_foldername=".$this->urlEncodePreserveForwardSlashes($a_dir)."'>"
							."<img src=\"".$this->imgdirNavigation."rename.png\" border='0' title=\"".JText::sprintf('folder_rename', $this->chosen_encoding($a_dir))."\" /></a>"
							."</td>";
					}
					else
					{
						$text .= "<td class='emptyTd'></td>";
					}
					if($access_rights > 4)
					{
						// we need to utf-8 encode potential special characters to be passed to javascript, because Firefox does not handle this (it works in IE)
						$text .= "<td class='fileAction'>"
							."<a href=\"javascript:confirmDelfolder('".addslashes($this->baselink)."','".urlencode(addslashes($this->chosen_encoding($masked_dir)))."','".urlencode(addslashes($this->chosen_encoding($a_dir)))."','".addslashes(JText::sprintf('about_to_remove_folder', $this->chosen_encoding($a_dir)))."')\">"
							."<img src=\"".$this->imgdirNavigation."delete.png\" border='0' title=\"".JText::sprintf('remove_folder', $this->chosen_encoding($a_dir))."\" /></a>"
							."</td>";
					}
					else
					{
						$text .= "<td class='emptyTd'></td>";
					}
					$text .= "</tr>";
				}
				$row = 1 - $row;
				$incli = "jsmallfib_sub1.php";	
				include ($incli);
				$vertiz1++;
			}
		}

		// Now the subfiles
		if($filessub[$vertiz])
		{
			foreach ($filessub[$vertiz] as $a_file)
			{
				$htref="/";
				$realdir=$dir.$htref.$a_file;
				if($a_file["name"]){
				$row_style = ($row ? "odd" : "even");

				if ($this->line_height)
				{
					$text .= "<tr class='jsmalline'><td colspan='$rowColspan'></td></tr>";
				}

				// makeThumbnail will only make a new thumbnail if required, and will return one if the right thumbnail is available
				if ($is_current_position_inside_webroot && $this->makeThumbnail($a_file["name"], $a_file["extension"], $dir, $this->thumbsize, $this->thumbsize))
				{
					$file_icon_td_begin	= "<td class='fileThumb'>";
					$file_icon_image	= "<img src=\"".$this->makeForwardSlashes($this->chosen_encoding($relative_dir."/"."JS_THUMBS"."/".$a_file["name"]))."\" border='0' />";
					$file_icon_td_end	= "</td>";
				}
				else
				{
					$file_icon_td_begin	= "<td width='100px'><img src=\"".$this->imgdirNavigation."subs.png\" width='18' style='margin:0; padding:0px 0px 1px 40px;'/>";
					$file_icon_image	= "<img src=\"".$this->fileIcon($a_file["extension"])."\" width='".$this->icon_width."' style='margin:0; padding:0px 0px 1px 11px;' border='0' />";
					$file_icon_td_end	= "</td>";
				}

				// different line if editing name or not
				if (isset($_GET['old_filename']) && strlen($_GET['old_filename']) && !strcmp($_GET['old_filename'], $a_file["name"]))   // Removed urldecode on _GET /ErikLtz
				{
					$text .= "<form action='".$this->baselink."&dir=".urlencode($masked_dir)."' method='post'>"
						."<tr class='row $row_style'>"
						.	$file_icon_td_begin.$file_icon_image.$file_icon_td_end
						."	<td class='fileName'>"
						."	<input name='new_filename' type='text' value=\"".$this->chosen_encoding($a_file["name"])."\" />"
						."	</td>"
							.($this->display_filesize ? "<td class='fileSize'>".$this->fileSizeF($a_file["size"])."</td>" : "<td class='emptyTd'></td>")
							.($this->display_filedate ? "<td class='fileChanged'>".$this->fileChanged($a_file["changed"])."</td>" : "<td class='emptyTd'></td>")
						."	<td class='emptyTd'></td>"
						."	<td class='fileAction'>"
						."	<input type='image' src=\"".$this->imgdirNavigation."tick.png\" title=\"".JText::_('rename_file_title')."\" />"
						."	</td>"
						."	<td class='fileAction'><a href='".$this->baselink."&dir=".$this->urlEncodePreserveForwardSlashes($masked_dir)."'>".JText::_('rename_file_cancel')."</a></td>"
						."</tr>"
						."	<input type='hidden' name='old_filename' value=\"".urlencode($a_file["name"])."\" />"
						."</form>";
				}
				else
				{
					if($access_rights == 1)
					{
						$file_link = $this->chosen_encoding($a_file["name"]);
						$file_link_a_tag_begin = "";
						$file_link_a_tag_end = "";
					}
					else
					{
						// now uses absolute path in download file (relative path returns false to file_exists() on certain unix configurations 

						// set the <a href...> tag for the file link (depends on the linking method, direct or through the open/download box)
						if ($is_current_position_inside_webroot && $is_direct_link_to_files)
						{
							$file_link_a_tag_begin = "<a href=\"".$this->makeForwardSlashes($this->chosen_encoding($relative_dir.DS.$a_file["name"]))."\" ".($is_direct_link_to_files > 1 ? "target='_blank'" : "").">";
						}
						else
						{
							$file_link_a_tag_begin = "<a href='".$this->baselink."&dir=".$this->urlEncodePreserveForwardSlashes($masked_dir)."&download_file=".$this->urlEncodePreserveForwardSlashes($masked_dir."/".$a1_dir."/".$a_file["name"])."'>";
							//$file_link_a_tag_begin = "<a href=\"".$this->makeForwardSlashes($this->chosen_encoding($relative_dir.DS.$a1_dir."/".$a_file["name"]))."\" ".($is_direct_link_to_files > 1 ? "target='_blank'" : "").">";
						}
						$file_link_a_tag_end = "</a>";

						// display normal open/download link if either outside of an archive or inside, but with no right to restore a file
						if (!$is_current_position_an_archive || $access_rights <= 3)
						{
							// normal link
							$file_link = $file_link_a_tag_begin.$this->chosen_encoding($a_file["name"]).$file_link_a_tag_end;
						}
						else
						{
							// link in case of an archived file
							$file_link = "<br />".$this->chosen_encoding($a_file["name"])
								    ."<br />"
								    .$file_link_a_tag_begin.JText::_('download_or_open_file').$file_link_a_tag_end;

							if ($access_rights > 3)
							{
								$file_link .= "&nbsp;|&nbsp;<a href=\"javascript:confirmRestoreFile('".addslashes($this->baselink)."','"
									.urlencode(addslashes($this->chosen_encoding($masked_dir)))."','".urlencode(addslashes($this->chosen_encoding($a_file["name"])))."','"
									.addslashes(JText::sprintf('about_to_restore_archived_file', $this->chosen_encoding($a_file["name"])))."')\">"
									.JText::_('restore_archived_file')."</a>"
									."<br /><br />";
							}
						}
					}

					$text .= "<tr class='row $row_style' onmouseover='this.className=\"highlighted\"' onmouseout='this.className=\"row $row_style\"'>"
						.$file_icon_td_begin.$file_link_a_tag_begin.$file_icon_image.$file_link_a_tag_end.$file_icon_td_end
						."	<td class='fileName'>"
						.$file_link
						."	</td>"
						.($this->display_filesize ? "<td class='fileSize'>".$this->fileSizeF($a_file["size"])."</td>" : "<td class='emptyTd'></td>")
						.($this->display_filedate ? "<td class='fileChanged'>".$this->fileChanged($a_file["changed"])."</td>" : "<td class='emptyTd'></td>");

					if($access_rights > 3 && !$is_current_position_an_archive)
					{
						// for zipped files
						$supported_zip_extensions = array("BZ2", "BZIP2", "GZ", "GZIP", "TAR", "TBZ2", "TGZ", "ZIP");

						if($this->unzip_allow && !$is_current_position_an_archive && in_array(strtoupper($a_file["extension"]), $supported_zip_extensions))
						{
							$text .= "<td class='fileAction'>"
								."<a href=\"javascript:confirmExtractfile('".addslashes($this->baselink)."','".urlencode(addslashes($this->chosen_encoding($masked_dir)))."','".urlencode(addslashes($this->chosen_encoding($a_file["name"])))."','".addslashes(JText::sprintf('about_to_extract_file', $this->chosen_encoding($a_file["name"])))."')\">"
								."<img src=\"".$this->imgdirNavigation."unzip.png\" border='0' nowidth='23' title=\"".JText::sprintf('extract_file', $this->chosen_encoding($a_file["name"]))."\" /></a>"
								."</td>";
						}
						else
						{
							$text .= "<td class='emptyTd'></td>";
						}
					}
					else
					{
						$text .= "<td class='emptyTd'></td>";
					}
					
					if($access_rights > 2 && !$is_current_position_an_archive)
					{
						$text .= "<td class='fileAction'>"
							."<a href='".$this->baselink."&dir=".$this->urlEncodePreserveForwardSlashes($masked_dir)."&old_filename=".$this->urlEncodePreserveForwardSlashes($a_file["name"])."'>"
							."<img src=\"".$this->imgdirNavigation."rename.png\" border='0' title=\"".JText::sprintf('file_rename', $this->chosen_encoding($a_file["name"]))."\" /></a>"
							."</td>";
					}
					else
					{
						$text .= "<td class='emptyTd'></td>";
					}
					if($access_rights > 3)
					{
						// we need to utf-8 encode potential special characters to be passed to javascript, because Firefox does not handle this (it works in IE)
						$text .= "<td class='fileAction'>"
							."<a href=\"javascript:confirmDelfile('".addslashes($this->baselink)."','".urlencode(addslashes($this->chosen_encoding($masked_dir)))."','".urlencode(addslashes($this->chosen_encoding($a_file["name"])))."','".addslashes(JText::sprintf('about_to_remove_file', $this->chosen_encoding($a_file["name"])))."')\">"
							."<img src=\"".$this->imgdirNavigation."delete.png\" border='0' title=\"".JText::sprintf('remove_file', $this->chosen_encoding($a_file["name"]))."\" /></a>"
							."</td>";
					}
					else
					{
						$text .= "<td class='emptyTd'></td>";
					}
					$text .= "</tr>";
				}
				$row = 1 - $row;}
			}
		}
	$dir = $dir_old;	
?>