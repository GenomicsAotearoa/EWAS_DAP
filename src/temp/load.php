
<html>
<?php

# option 1
shell_exec("LD_LIBRARY_PATH=/lib64:/usr/lib64:/usr/lib64/R/lib nohup Rscript /opt/lampp/htdocs/ewas/ewas_pip/temp/my_script.R > file.out 2> file.err < /dev/null &");

#option 2
#shell_exec("nohup ./Rapper.sh /opt/lampp/htdocs/ewas/ewas_pip/temp/my_script.R > file.out 2> file.err < /dev/null &");

#shell_exec("Rscript /opt/lampp/htdocs/ewas/ewas_pip/temp/my_script.R > file.out 2> file.err < /dev/null");


?>
</html>
