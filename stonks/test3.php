<?php
        $request = 'https://finance.yahoo.com/quote/'.$ticker;
        $html = file_get_contents($request);
        $start = stripos($html, 'class="Trsdu(0.3s) Fw(b) Fz(36px) Mb(-4px) D(ib)"');
        $end = stripos($html, '</span>', $offset = $start);
        $length = $end - $start;
        $price = substr($html, $start+50, $length);
        // $pattern ="/>(.+)/";
        // preg_match_all($pattern, $price, $matches);
        // preg_match('(.+)', $matches[1][0], $match);
        // $price = (float) $match[0];
        echo $price;
?>