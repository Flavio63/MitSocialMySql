        <?php
            $URL = $_GET['URL'];
            $URL = rawurldecode($URL);
            $URL = stripslashes($URL);
            if (function_exists('curl_init')) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $URL);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
                $content = curl_exec($ch);
                echo $content;
                curl_close($ch);
            } else {
                echo 'not exists "curl_init" quindi ciccia';
            }
