<?php

namespace Tests\Functional;

require_once __DIR__ . '/../../src/Models/paginationClass.php';

class YelpAPITest extends BaseTestCase {
    
    public function testGetAccessToken() {
        
        $var = '{
                        "args": {
                                "appId": "oBUx4lK97HWCYbYDhL-HNA",
                                "appSecret": "Dbt1f3Qd47xaiDkptJfG5Waq2OgJryk4z2EBpQCkH8YBeOU5szRYi3pSKZudtSs1"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/YelpAPI/getAccessToken', $post_data);
        
        $token = json_decode($response->getBody())->contextWrites->to->access_token;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
        
        return $token;
    }
     
    /**
     * @depends testGetAccessToken
     */
    public function testGetBusinesses($token) {
        
        $var = '{
                        "args": {
                                "accessToken": "'.$token.'",
                                "longitude": "-122.399972",
                                "latitude": "37.786882"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/YelpAPI/getBusinesses', $post_data);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    /**
     * @depends testGetAccessToken
     */
    public function testGetSingleBusiness($token) {
        
        $var = '{
                        "args": {
                                "accessToken": "'.$token.'",
                                "bussinessId": "t-we-tea-san-francisco"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/YelpAPI/getSingleBusiness', $post_data);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    /**
     * @depends testGetAccessToken
     */
    public function testGetBusinessesByPhoneNumber($token) {
        
        $var = '{
                        "args": {
                                "accessToken": "'.$token.'",
                                "phone": "+14157492060"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/YelpAPI/getBusinessesByPhoneNumber', $post_data);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    /**
     * @depends testGetAccessToken
     */
    public function testGetBusinessesByTransaction($token) {
        
        $var = '{
                        "args": {
                                "accessToken": "'.$token.'",
                                "transactionType": "delivery",
                                "latitude": "37.786882",
                                "longitude": "-122.399972"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/YelpAPI/getBusinessesByTransaction', $post_data);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    /**
     * @depends testGetAccessToken
     */
    public function testGetBusinessReviews($token) {
        
        $var = '{
                        "args": {
                                "accessToken": "'.$token.'",
                                "bussinessId": "t-we-tea-san-francisco"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/YelpAPI/getBusinessReviews', $post_data);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }
    
    /**
     * @depends testGetAccessToken
     */
    public function testGetAutocomplete($token) {
        
        $var = '{
                        "args": {
                                "accessToken": "'.$token.'",
                                "text": "del",
                                "longitude": "-122.399643",
                                "latitude": "37.786942"
                        }
                }';
        $post_data = json_decode($var, true);

        $response = $this->runApp('POST', '/api/YelpAPI/getAutocomplete', $post_data);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
    }

}
