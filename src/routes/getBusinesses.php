<?php

$app->post('/api/YelpAPI/getBusinesses', function ($request, $response, $args) {
    $settings = $this->settings;

    $data = $request->getBody();

    if ($data == '') {
        $post_data = $request->getParsedBody();
    } else {
        $toJson = $this->toJson;
        $data = $toJson->normalizeJson($data);
        $data = str_replace('\"', '"', $data);
        $post_data = json_decode($data, true);
    }

    if (json_last_error() != 0) {
        $error[] = json_last_error_msg() . '. Incorrect input JSON. Please, check fields with JSON input.';
    }

    if (!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'JSON_VALIDATION';
        $result['contextWrites']['to']['status_msg'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    $error = [];
    if (empty($post_data['args']['accessToken'])) {
        $error[] = 'accessToken';
    }
    if (empty($post_data['args']['location']) && empty($post_data['args']['coordinate']) && empty($post_data['args']['longitude']) && empty($post_data['args']['latitude']) ) {
        $error[] = 'please, provide location or provide coordinate';
    }
    if (!empty($post_data['args']['location']) && (!empty($post_data['args']['coordinate']) || (!empty($post_data['args']['longitude']) && !empty($post_data['args']['latitude'])))) {
        $error[] = 'please, provide either location or coordinate';
    }

    if (!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = "REQUIRED_FIELDS";
        $result['contextWrites']['to']['status_msg'] = "Please, check and fill in required fields.";
        $result['contextWrites']['to']['fields'] = $error;
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }

    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $query_str = $settings['api_url'] . '/businesses/search';

    $body = [];
    if (!empty($post_data['args']['term'])) {
        $body['term'] = $post_data['args']['term'];
    }
    if (!empty($post_data['args']['coordinate'])) {
        $body['latitude'] = explode(',', $post_data['args']['coordinate'])[0];
        $body['longitude'] = explode(',', $post_data['args']['coordinate'])[1];
    } else {
        $body['latitude'] = $post_data['args']['latitude'];
        $body['longitude'] = $post_data['args']['longitude'];
    }
    if (!empty($post_data['args']['location'])) {
        $body['location'] = $post_data['args']['location'];
    }

    if (!empty($post_data['args']['radius'])) {
        $body['radius'] = $post_data['args']['radius'];
    }
    if (!empty($post_data['args']['categories'])) {
        $body['categories'] = $post_data['args']['categories'];
    }
    if (!empty($post_data['args']['locale'])) {
        $body['locale'] = $post_data['args']['locale'];
    }
    if (!empty($post_data['args']['limit'])) {
        $body['limit'] = $post_data['args']['limit'];
    }
    if (!empty($post_data['args']['offset'])) {
        $body['offset'] = $post_data['args']['offset'];
    }
    if (!empty($post_data['args']['sortBy'])) {
        $body['sort_by'] = $post_data['args']['sortBy'];
    }
    if (!empty($post_data['args']['price'])) {
        $body['price'] = $post_data['args']['price'];
    }
    if (!empty($post_data['args']['openNow'])) {
        $body['open_now'] = $post_data['args']['openNow'];
    }
    if (!empty($post_data['args']['openAt'])) {
        if (is_numeric($post_data['args']['openAt'])){
            $body['open_at'] = $post_data['args']['openAt'];
        } else {
            $dateTime = new DateTime($post_data['args']['openAt']);
            $body['open_at'] = $dateTime->format('U');
        }

    }
    if (!empty($post_data['args']['attributes'])) {
        $body['attributes'] = implode(",", $post_data['args']['attributes']);
    }

    $client = $this->httpClient;

    try {

        $resp = $client->get($query_str,
            [
                'headers' => $headers,
                'query' => $body
            ]);
        $responseBody = $resp->getBody()->getContents();

        if ($resp->getStatusCode() == '200') {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if (empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if (empty(json_decode($responseBody))) {
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
