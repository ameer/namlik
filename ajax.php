<?php
require_once('OpenGraph.php');
$response_array = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST["data"];
    $json = json_decode($data);
    $url = $json->url;
    $host = parse_url($url, PHP_URL_HOST);
    if ($host == "namlik.me") {
        $graph = OpenGraph::fetch($url);
        
        foreach ($graph as $key => $value) {
            $response_array[$key] = $value;
        }
        $response_array["success"] = true;

    } else {
        $response_array["success"] = false;
        $response_array["error"] = "ما فعلا فقط از سایت ناملیک پادکست دانلود میکنیم!";
    }
    
} else {
    $response_array["success"] = false;
    $response_array["error"] = "Method not supported";
}
echo json_encode($response_array);