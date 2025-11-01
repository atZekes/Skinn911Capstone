@<?php\n$lines = file("storage/logs/laravel.log");\n$last = array_slice($lines, -400);\nfile_put_contents("lastlog.txt", implode("", $last));\n?>
