<?php
header('Content-Type: text/html; charset=utf-8');
$array = include_once ('path/arrayRaduga.php');
//$array = explode('ё', $arr);
//print_r($array);
$domen = 'https://raduga-ural.ru';
$domenRus = 'https://сургут.стройплатформа.рф';
$i = 0;
$o = 1;
$filename = 'всессылки.txt';
$filename1 = 'error404.txt';
$filename2 = 'code301.txt';
$filename3 = 'code200.txt';


function getHttpCode($http_response_header)
{
    if(is_array($http_response_header))
    {
        $parts=explode(' ',$http_response_header[0]);
        if(count($parts)>1) //HTTP/1.0 <code> <text>
            return intval($parts[1]); //Get code
    }
    return 0;
}

foreach ($array as $k => $item) {
    $url = $domen.$item[0];                     /* url */
//    $pushUrl =$domenRus.$item[0];
//    echo $url;
    @file_get_contents(''.$url.'');
    $headers = get_headers($url, true);    /* получаем данный от url от сервера */
    $code = getHttpCode($headers);                  /* проверяем какой код ответа */

    if ($code == 404) {

        filePutEr($url);
        echo 'первый 404 = ';

    } else if ($code == 301) {                 /* если 301 (редирект),  */

//        filePut($filename2, $url);
        echo 'первый 301, ';
        redir($headers, $url);                                /* то функция  */
//        print_r($headers);

    } else {

        echo 'код '.$code;

    }


    $i++;
    echo PHP_EOL.$i.'->'.PHP_EOL;
}

function redir($headers, $url) {
    $oneHttp = isset($headers[1]) ? $headers[1] : "";
    $twoHttp = isset($headers[2]) ? $headers[2] : "";
//    $threeHttp = $headers[3];
    $strOne = stristr($oneHttp, '404');
    $strTwo = stristr($twoHttp, '404');
//    $strThree = stristr($threeHttp, '404');

    if (($strOne == true) || ($strTwo == true)) {                 /* если ключ Location (url) существует, то */
        echo $strOne.$strTwo.' ';
        filePutE($url);
    } else if ((stristr($headers[1], '200') == true) || (stristr($headers[2], '200') == true)) {
        echo '200 '.$url;
        filePut($url);
    } else {
        echo 'no location';
        echo $url;
    }
}
function filePut ($url) {

    $filenameSuccess = 'successUrl.txt';
    file_put_contents($filenameSuccess, $url.PHP_EOL, FILE_APPEND); /* Запись в файл*/
    echo 'put-file-er '.$url;

}

function filePutE ($url) {

    $filenameError = 'errorUrl.txt';
    file_put_contents($filenameError, $url.PHP_EOL, FILE_APPEND); /* Запись в файл*/
    echo 'put-file-suc '.$url;

}
function filePutEr($url) {
    $filenameError = 'WithOut-redirect-404.txt';
    file_put_contents($filenameError, $url.PHP_EOL, FILE_APPEND); /* Запись в файл*/
    echo 'put-file-with-out-redirect '.$url;
}

//foreach ($array as $k => $item) {
//    $url = $domen.$item[0];
////    echo $url;
//
//    $filename = 'somefileUrl'.$o.'.txt';
////
//
//    if ($i <= 98) {
//        $o = 1;
//        fileput($filename, $url, $i);
//    } else if ($i > 98 && $i <= 198) {
//        $o = 2;
//        fileput($filename, $url, $i);
//    } else if ($i > 198 && $i <= 298) {
//        $o = 3;
//        fileput($filename, $url, $i);
//    } else if ($i > 298 && $i <= 398) {
//        $o = 3;
//        fileput($filename, $url, $i);
//    } else if ($i > 398 && $i <= 498) {
//        $o = 4;
//        fileput($filename, $url, $i);
//    } else if ($i > 498 && $i <= 598) {
//        $o = 5;
//        fileput($filename, $url, $i);
//    } else if ($i > 598 && $i <= 698) {
//        $o = 6;
//        fileput($filename, $url, $i);
//    }
//    $i++;
//
//}
