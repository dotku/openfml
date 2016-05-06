<?php
namespace Api\Controller;
use Think\Controller;
class SearchController extends Controller {
    public function index() {
        echo 'welcome to search API!';
    }
    public function bestbuy() {
        // key: mv4ragc2ke4rm3fgsm3p97r7
        $apiKey = 'mv4ragc2ke4rm3fgsm3p97r7';
        $q = split(' ', $_GET['q']);
        foreach ($q as $k => $v) {
            $q[$k] = 'search=' . $v;
        }
        $search = join('&', $q);
        //var_dump($search);
        $data = file_get_contents('http://api.bestbuy.com/v1/products('.$search.')?show=name,sku,salePrice,image&format=json&apiKey='.$apiKey);
        echo $data;
    }
    public function amazon() {
    
    // Your AWS Access Key ID, as taken from the AWS Your Account page
    $aws_access_key_id = "AKIAI3ETQLUIPHZMRHNQ";

    // Your AWS Secret Key corresponding to the above ID, as taken from the AWS Your Account page
    $aws_secret_key = "VUxjtQEVF+x1SktYTvMVivglzLN+Zd0Rnk2xKePU";

    // The region you are interested in
    $endpoint = "webservices.amazon.com";

    $uri = "/onca/xml";

    $params = array(
        "Service" => "AWSECommerceService",
        "Operation" => "ItemSearch",
        "AWSAccessKeyId" => "AKIAI3ETQLUIPHZMRHNQ",
        "AssociateTag" => "soeasy-20",
        "SearchIndex" => "All",
        "Keywords" => "shoe",
        "ResponseGroup" => "Images,ItemAttributes,Offers"
    );
    if ($_GET['q']) {
        $params['Keywords'] = $_GET['q'];
    }
    // Set current timestamp if not set
    if (!isset($params["Timestamp"])) {
        $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
    }

    // Sort the parameters by key
    ksort($params);

    $pairs = array();

    foreach ($params as $key => $value) {
        array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
    }

    // Generate the canonical query
    $canonical_query_string = join("&", $pairs);

    // Generate the string to be signed
    $string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

    // Generate the signature required by the Product Advertising API
    $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));

    // Generate the signed URL
    $request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

    // echo "Signed URL: \"".$request_url."\"";
    // echo "<iframe src=$request_url height='100%' width='100%'><iframe>";
    $xml_string = file_get_contents($request_url);
    // header ("Content-Type:text/xml");
    $xml = simplexml_load_string($xml_string);
    $json = json_encode($xml, JSON_PRETTY_PRINT);
    echo $json;

    }
    public function macys() {
        $q = $_GET['q'];
        $url = "http://api.macys.com/v4/catalog/search?searchphrase=".$q;
        try {
        // sendRequest
        // note how referer is set manually
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            'x-macys-webservice-client-id: xmj9js4jkdpe1983fmwu98gh',
            'Accept: application/json'
        ));
        // curl_setopt($ch, CURLOPT_REFERER, /* Enter the URL of your site here */);
        
            $body = curl_exec($ch);
            var_dump($body);
            var_dump(curl_error($ch));
        } catch (Exception $e) {
            echo "error";
            
        }

        // now, process the JSON string
        $json = json_decode($body);
        echo $json;
        // now have some fun with the results...
        
    }
}