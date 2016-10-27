<?php

$app->post('/api/YelpAPI/getBusinesses', function ($request, $response, $args) {
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
    
    $error = [];
    if(empty($post_data['args']['accessToken'])) {
        $error[] = 'accessToken cannot be empty';
    }
    if(empty($post_data['args']['location']) && empty($post_data['args']['latitude']) && empty($post_data['args']['longitude'])) {
        $error[] = 'please, provide location or provide latitude and longitude';
    }
    if(!empty($post_data['args']['location']) && !empty($post_data['args']['latitude']) && !empty($post_data['args']['longitude'])) {
        $error[] = 'please, provide either location or latitude and longitude';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }
    
    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $query_str = $settings['api_url'] . '/businesses/search';
    
    $body = [];
    if(!empty($post_data['args']['term'])) {
        $body['term'] = $post_data['args']['term'];
    }
    if(!empty($post_data['args']['location'])) {
        $body['location'] = $post_data['args']['location'];
    }
    if(!empty($post_data['args']['latitude'])) {
        $body['latitude'] = $post_data['args']['latitude'];
    }
    if(!empty($post_data['args']['longitude'])) {
        $body['longitude'] = $post_data['args']['longitude'];
    }
    if(!empty($post_data['args']['radius'])) {
        $body['radius'] = $post_data['args']['radius'];
    }
    if(!empty($post_data['args']['categories'])) {
        $body['categories'] = $post_data['args']['categories'];
    }
    if(!empty($post_data['args']['locale'])) {
        $body['locale'] = $post_data['args']['locale'];
    }
    if(!empty($post_data['args']['limit'])) {
        $body['limit'] = $post_data['args']['limit'];
    }
    if(!empty($post_data['args']['offset'])) {
        $body['offset'] = $post_data['args']['offset'];
    }
    if(!empty($post_data['args']['sortBy'])) {
        $body['sort_by'] = $post_data['args']['sortBy'];
    }
    if(!empty($post_data['args']['price'])) {
        $body['price'] = $post_data['args']['price'];
    }
    if(!empty($post_data['args']['openNow'])) {
        $body['open_now'] = $post_data['args']['openNow'];
    }
    if(!empty($post_data['args']['openAt'])) {
        $body['open_at'] = $post_data['args']['openAt'];
    }
    if(!empty($post_data['args']['attributes'])) {
        $body['attributes'] = $post_data['args']['attributes'];
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
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody();
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    } catch (GuzzleHttp\Exception\BadResponseException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to'] = json_decode($responseBody);

    }
    
    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});
