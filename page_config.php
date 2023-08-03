<?php
                          if(isset($_GET["page"]))

						  	$page = @$_GET["page"];

						  else

						  	$page = @$_POST["page_no"];

						  

                          if ($page=='') $page = 1;

                          if ($count % $showrecs != 0) {

                            $pagecount = intval($count / $showrecs) + 1;

                          }

                          else {

                            $pagecount = intval($count / $showrecs);

                          }

                          $startrec = $showrecs * ($page - 1);

                       //   if ($startrec < $count) {mysql_data_seek($res, $startrec);}

                          $reccount = min($showrecs * $page, $count);
?>