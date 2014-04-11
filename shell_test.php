<?php
shell_exec("tar -cvf files.tar * --exclude 'shell_test.php' --exclude 'files.tar' > /dev/null 2>/dev/null &");
?>