<?php
    $dourl = $_GET["url"] . '?'. md5(uniqid(rand(), true)) . '=' . md5(uniqid(rand(), true));
    error_reporting(0);
    header("Access-Control-Allow-Origin: *");
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $dourl);
    curl_setopt($c, CURLOPT_HEADER, TRUE);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($c, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($c, CURLOPT_CERTINFO, TRUE);
    curl_setopt($c, CURLOPT_TIMEOUT, 25);
    curl_setopt($c, CURLOPT_COOKIESESSION, TRUE);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($c, CURLOPT_MAXREDIRS, 15);
    curl_setopt($c, CURLOPT_FORBID_REUSE, TRUE);
    curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Ping Bot/1.0; +https://useping.ga/bot)');
    
    if (!curl_exec($c) | (int)curl_getinfo($c)['http_code'] === 408) {
        $return = array(
            "1" => "timeout",
            "latency" => (curl_getinfo($c)['namelookup_time']+curl_getinfo($c)['connect_time']+curl_getinfo($c)['appconnect']+curl_getinfo($c)['pretransfer_time']+curl_getinfo($c)['redirect_time']+curl_getinfo($c)['starttransfer_time'])*1000,
            "3" => curl_getinfo($c)['http_code'],
            "speed" => curl_getinfo($c)['speed_download'] * 8 / 1024 / 1024,
            "size" => curl_getinfo($c)['size_download'],
            "6" => curl_getinfo($c)['namelookup_time']*1000,
            "7" => curl_getinfo($c)['connect_time']*1000,
            "8" => explode("CN = ", curl_getinfo($c)['certinfo'][1]['Subject'])[1],
            "9" => curl_getinfo($c)['certinfo'][0]['Expire date']
        );
        curl_close($c);
        echo json_encode($return);
    } else {
        $code = (int)curl_getinfo($c)['http_code'];
        if ($code < 399) {
            $return = array(
                "1" => "up",
                "latency" => (curl_getinfo($c)['namelookup_time']+curl_getinfo($c)['connect_time']+curl_getinfo($c)['appconnect']+curl_getinfo($c)['pretransfer_time']+curl_getinfo($c)['redirect_time']+curl_getinfo($c)['starttransfer_time'])*1000,
                "3" => curl_getinfo($c)['http_code'],
                "speed" => curl_getinfo($c)['speed_download'] * 8 / 1024 / 1024,
                "size" => curl_getinfo($c)['size_download'],
                "6" => curl_getinfo($c)['namelookup_time']*1000,
                "7" => curl_getinfo($c)['connect_time']*1000,
                "8" => explode("CN = ", curl_getinfo($c)['certinfo'][1]['Subject'])[1],
                "9" => curl_getinfo($c)['certinfo'][0]['Expire date'],
            );
            curl_close($c);
            echo json_encode($return);
        } else {
            $return = array(
                "1" => "down",
                "latency" => (curl_getinfo($c)['namelookup_time']+curl_getinfo($c)['connect_time']+curl_getinfo($c)['appconnect']+curl_getinfo($c)['pretransfer_time']+curl_getinfo($c)['redirect_time']+curl_getinfo($c)['starttransfer_time'])*1000,
                "3" => curl_getinfo($c)['http_code'],
                "speed" => curl_getinfo($c)['speed_download'] * 8 / 1024 / 1024,
                "size" => curl_getinfo($c)['size_download'],
                "6" => curl_getinfo($c)['namelookup_time']*1000,
                "7" => curl_getinfo($c)['connect_time']*1000,
                "8" => explode("CN = ", curl_getinfo($c)['certinfo'][1]['Subject'])[1],
                "9" => curl_getinfo($c)['certinfo'][0]['Expire date'],
            );
            curl_close($c);
            echo json_encode($return);
        }
    }