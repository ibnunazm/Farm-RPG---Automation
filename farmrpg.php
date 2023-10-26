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

    function plantAll(){
        $header = array(
            'Origin: https://farmrpg.com',
            'Referer: https://farmrpg.com/index.php',
        );
    
        $html = _retriever('https://farmrpg.com/worker.php?go=plantall&id=340441', NULL, $header, 'POST');
        return $html;
    }

    function harvestAll(){
        $header = array(
            'Origin: https://farmrpg.com',
            'Referer: https://farmrpg.com/index.php',
        );
        
        $html = _retriever('https://farmrpg.com/worker.php?go=harvestall&id=340441', NULL, $header, 'POST');
        return $html;
    }

    function buySeed(){
        $header = array(
            'Origin: https://farmrpg.com',
            'Referer: https://farmrpg.com/index.php',
        );
        
        $html = _retriever('https://farmrpg.com/worker.php?go=buyitem&id=12&qty=8', NULL, $header, 'POST');
        return $html;
    }

    function sellCrop(){
        $header = array(
            'Origin: https://farmrpg.com',
            'Referer: https://farmrpg.com/index.php',
        );
        
        $html = _retriever('https://farmrpg.com/worker.php?go=sellitem&id=11&qty=8', NULL, $header, 'POST');
        return $html;
    }

    function getFish(){
        $header = array(
            'Origin: https://farmrpg.com',
            'Referer: https://farmrpg.com/index.php',
        );
        
        $html = _retriever('https://farmrpg.com/worker.php?go=fishcaught&id=1&r=470289', NULL, $header, 'POST');
        return $html; 
    }

    function buyBait(){
        $header = array(
            'Origin: https://farmrpg.com',
            'Referer: https://farmrpg.com/index.php',
        );
        
        $html = _retriever('https://farmrpg.com/worker.php?go=buyitem&id=18&qty=20', NULL, $header, 'POST');
        return $html; 
    }

    function sellFish(){
        $header = array(
            'Origin: https://farmrpg.com',
            'Referer: https://farmrpg.com/index.php',
        );
        
        $html = _retriever('https://farmrpg.com/worker.php?go=sellalluserfish', NULL, $header, 'POST');
        return $html; 
    }
    
    function autoFarm(){
        $data = array();
        $data['harvest'] = harvestAll();
        $data['sell'] = sellCrop();
        $data['buy'] = buySeed();
        $data['plant'] = plantAll();
        return json_encode($data);
    }

    function autoFish(){
        $data = array();
        $bait = 20;
        $data['bait'] = buyBait();
        while($bait > 0){
            $data['getfish'] = getFish();
            $bait--;
        }
        $data['sellfish'] = sellFish();
        return json_encode($data);
    }

    function explore(){
        $header = array(
            'Origin: https://farmrpg.com',
            'Referer: https://farmrpg.com/index.php',
        );
        
        $html = _retriever('https://farmrpg.com/worker.php?go=explore&id=1', NULL, $header, 'POST');
        return $html;
    }

    function autoExplore(){
        $data = array();
        $counter = 0;
        while ($counter < 20) {
            $data['exploring'][] = explore();
            $counter++;
        }
        return json_encode($data);
    }

    // $result = autoFarm();
    // $result = autoFish();
    $result = autoExplore();
    print_r($result);
?>