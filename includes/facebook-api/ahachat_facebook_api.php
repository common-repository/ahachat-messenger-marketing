<?php

class AhaChatFacebookApi {
    public function request($method, $path, $data, $token)
    {
        $params = [
            'url' => $path,
            'method' => $method,
            'data' => $data,
            'token' => $token
        ];

        $response = wp_remote_post( AHACHAT_BASE_URL . 'wp-cart/send-graph-request', array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded'
            ],
            'body' => $params,
            'cookies' => []
            )
        );

        $body = json_decode(json_encode($response['body']), true);
        return json_decode($body, true)['data'];
    }
}

?>