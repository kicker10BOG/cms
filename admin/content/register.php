          <?
            echo($current_location);
                if (isset($_REQUEST['cehckRegister']))
                {
                    include($php_function_dir."checkRegister.php");
                }
                else
                {
                    include($php_function_dir."register.php");
                }
          ?>