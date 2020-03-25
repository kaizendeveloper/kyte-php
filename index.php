<?php

require_once __DIR__.'/initializer.php';

/* CORS VALIDATION */
// get origin of requester
if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $origin = $_SERVER['HTTP_ORIGIN'];
} else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
    $origin = $_SERVER['HTTP_REFERER'];
} else {
    $origin = $_SERVER['REMOTE_ADDR'];
}

// get request type
$request = $_SERVER['REQUEST_METHOD'];

// Access-Control headers are received during OPTIONS requests
if ($request == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

header("Access-Control-Allow-Origin: $origin");
header('Access-Control-Allow-Credentials: true');
header("Content-Type: application/json; charset=utf-8");

// initialie empty array for response data
$response = [];

try {
    // read in data and parse into array
    parse_str(file_get_contents("php://input"), $data);

    /* parse URI        ** remember to add the following in .htaccess 'FallbackResource /index.php'
    * URL formats:
    * POST     /{token}/{key}/{signature}/{time}/{model}
    * PUT      /{token}/{key}/{signature}/{time}/{model}/{field}/{value}
    * GET      /{token}/{key}/{signature}/{time}/{model}/{field}/{value}
    * DELETE   /{token}/{key}/{signature}/{time}/{model}/{field}/{value}
    */
    // Trim leading slash(es)
    $path = ltrim($_SERVER['REQUEST_URI'], '/');
    // Split path on slashes
    $elements = explode('/', $path);

    // If minimum params are not passed, then generate signature and return
    if(count($elements) < 5) {
        if(count($elements) == 1) {
            /* POST     /{key} */
            $obj = new \Kyte\ModelObject(APIKey);
            if ($obj->retrieve('public_key', $elements[0])) {
            } else throw new Exception("Invalid API access key");
    
            $date = new DateTime($data['kyte-time'], new DateTimeZone('UTC'));
    
            $hash1 = hash_hmac('SHA256', $date->format('U'), $obj->getParam('secret_key'), true);
            $hash2 = hash_hmac('SHA256', $data['kyte-identifier'], $hash1, true);
            $response['signature'] = hash_hmac('SHA256', $elements[0], $hash2);
        } else {
            $response['version'] = \Kyte\ApplicationVersion::get();
        }
    }
    // if there are elements then process api request based on request type
    else {

        $api = new \Kyte\API(APIKey);
        // init new api with key
        $api->init($elements[1]);

        // check if signature is valid - signature and signature datetime
        $date = new DateTime(urldecode($elements[3]), new DateTimeZone('UTC'));
        $api->validate($elements[2], $date->format('U'));

        // initialize controller for model or view ("abstract" controller)
        $controllerClass = class_exists($element[4]{'Controller'}) ? $element[4]{'Controller'} : 'ModelController';
        $controller = new $controllerClass($element[4], APP_DATE_FORMAT, urldecode($element[0]));
        if (!$controller) throw new Exception("[ERROR] Unable to create controller for model: $controllerClass.");

        switch ($request) {
            case 'POST':
                // new  :   {data}
                $response = $controller->new($data);
                break;

            case 'PUT':
                // update   :   {field}, {value}, {data}
                $response = $controller->update($element[5], $element[6], $data);
                break;

            case 'GET':
                // get  :   {field}, {value}
                $response = $controller->get($element[5], $element[5]);
                break;

            case 'DELETE':
                // delete   :   {field}, {value}
                $response = $controller->delete($element[5], $element[5]);
                break;
            
            default:
                throw new Exception("[ERROR] Unknown HTTP request type: $request.");
                break;
        }

    }

} catch (Exception $e) {
	error_log($e->getMessage());
	http_response_code(400);
	echo json_encode(['status' => 400, 'error' => $e->getMessage()]);
	exit(0);
}

// return response data
echo json_encode($response);

?>
