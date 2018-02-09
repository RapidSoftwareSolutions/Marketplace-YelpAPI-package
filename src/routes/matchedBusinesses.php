<?php

$app->post('/api/YelpAPI/matchedBusinesses', function ($request, $response, $args) {
    $settings =  $this->settings;

    $data = $request->getBody();

    if($data=='') {
        $post_data = $request->getParsedBody();
    } else {
        $toJson = $this->toJson;
        $data = $toJson->normalizeJson($data);
        $data = str_replace('\"', '"', $data);
        $post_data = json_decode($data, true);
    }

    if(json_last_error() != 0) {
        $error[] = json_last_error_msg() . '. Incorrect input JSON. Please, check fields with JSON input.';
    }

    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'JSON_VALIDATION';
        $result['contextWrites']['to']['status_msg'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    $error = [];
    if(empty($post_data['args']['accessToken'])) {
        $error[] = 'accessToken';
    }

    if(empty($post_data['args']['type'])) {
        $error[] = 'type';
    }

    if(empty($post_data['args']['name'])) {
        $error[] = 'name';
    }

    if(empty($post_data['args']['city'])) {
        $error[] = 'city';
    }

    if(empty($post_data['args']['state'])) {
        $error[] = 'state';
    }

    if(empty($post_data['args']['country'])) {
        $error[] = 'country';
    }



    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = "REQUIRED_FIELDS";
        $result['contextWrites']['to']['status_msg'] = "Please, check and fill in required fields.";
        $result['contextWrites']['to']['fields'] = $error;
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $query_str = $settings['api_url'] . '/businesses/matches/'.$post_data['args']['type'];

    $body= [];

    $body['name'] = $post_data['args']['name'];
    $body['city'] = $post_data['args']['city'];
    $body['state'] = $post_data['args']['state'];
    $body['country'] = $post_data['args']['country'];


    if(!empty($post_data['args']['address1'])) {
        $body['address1'] = $post_data['args']['address1'];
    }
    if(!empty($post_data['args']['address2'])) {
        $body['address2'] = $post_data['args']['address2'];
    }
    if(!empty($post_data['args']['address3'])) {
        $body['address3'] = $post_data['args']['address3'];
    }
    if (!empty($post_data['args']['coordinates'])) {
        $body['latitude'] = trim(explode(",", $post_data['args']['coordinates'])[0]);
        $body['longitude'] = trim(explode(",", $post_data['args']['coordinates'])[1]);
    }
    if(!empty($post_data['args']['phone'])) {
        $body['phone'] = $post_data['args']['phone'];
    }
    if(!empty($post_data['args']['postalCode'])) {
        $body['postal_code'] = $post_data['args']['postalCode'];
    }
    if(!empty($post_data['args']['yelpBusinessId'])) {
        $body['yelp_business_id'] = $post_data['args']['yelpBusinessId'];
    }




    if (!empty($post_data['args']['coordinates'])) {
        $body['latitude'] = trim(explode(",", $post_data['args']['coordinates'])[0]);
        $body['longitude'] = trim(explode(",", $post_data['args']['coordinates'])[1]);
    }

    $client = $this->httpClient;

    try {

        $resp = $client->get( $query_str,
            [
                'headers' => $headers,
                'query' => $body
            ]);
        $responseBody = $resp->getBody()->getContents();

        if($resp->getStatusCode() == '200') {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ConnectException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'INTERNAL_PACKAGE_ERROR';
        $result['contextWrites']['to']['status_msg'] = 'Something went wrong inside the package.';

    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});
