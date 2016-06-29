<!--pagination navigation end-->
<div id="pagination">
        <div id="pagiCount">
            <?php
                if(isset($pages))
                {  
                    if($pages > 1)        
                    {    if($cur_page > $num_links)     ///////////to take to page 1 //////////
                        {   $dir = "first";
                            echo '<span id="prev"> <a href="'.$_SERVER['PHP_SELF'].'?page='.(1).'">'.$dir.'</a> </span>';
                        }
                       if($cur_page > 1) 
                        {
                            $dir = "Prev";
                            echo '<span id="prev"> <a href="'.$_SERVER['PHP_SELF'].'?page='.($cur_page-1).'">'.$dir.'</a> </span>';
                        }                 
                        
                        for($x=$start ; $x<=$end ;$x++)
                        {
                            
                            echo ($x == $cur_page) ? '<strong>'.$x.'</strong> ':'<a href="'.$_SERVER['PHP_SELF'].'?page='.$x.'">'.$x.'</a> ';
                        }
                        if($cur_page < $pages )
                        {   $dir = "Next";
                            echo '<span id="next"> <a href="'.$_SERVER['PHP_SELF'].'?page='.($cur_page+1).'">'.$dir.'</a> </span>';
                        }
                        if($cur_page < ($pages-$num_links) )
                        {   $dir = "last";
                       
                            echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$pages.'">'.$dir.'</a> '; 
                        }   
                    }
                }
            ?>
        </div>
    </div>
<!--pagination navigation end-->
