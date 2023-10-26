<?php
    function _retriever($url, $data = NULL, $header = NULL, $method = 'GET'){
        $cookie_file_path = dirname(__FILE__) . "/cookie/farmRPG.txt";
        $datas['http_code'] = 0;
        if ($url == "")
            return $datas;
        $data_string = '';
        if ($data != NULL) {
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $data_string .= $key . '=' . $value . '&';
                }
            } else {
                $data_string = $data;
            }
        }
    
        $ch = curl_init();
        if ($header != NULL)
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
        curl_setopt(
            $ch,
            CURLOPT_USERAGENT,
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36"
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    
        if ($data != NULL) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            // curl_setopt($ch, CURLOPT_POST, count($data));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        }
    
        $html = curl_exec($ch);
        //echo curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //echo $html;
        if (!curl_errno($ch)) {
            $datas['http_code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($datas['http_code'] == 200) {
                $datas['result'] = $html;
            }
        }
        curl_close($ch);
        return $datas;
    }

    $data = array(
        'username' => 'ibnunazm',
        'password' => '12345678',
    );
    
    $header = array(
        'Origin: https://farmrpg.com',
        'Referer: https://farmrpg.com/index.php',
    );
    
    $html = _retriever('https://farmrpg.com/worker.php?go=login', $data, $header, 'POST');
    $html = _retriever('https://farmrpg.com/index.php');
    print_r($html);
?>