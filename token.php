<?php
    class Token{
        static function Sign($payload, $key){
            $header = ['algo' => 'HS256','type'=> 'HWT'];
            $header_encoded = base64_encode(json_encode($header));

            $payload_encoded = base64_encode(json_encode($payload));

            $signature = hash_hmac('SHA256',$header_encoded.$payload_encoded,$key);
            $signature_encoded = base64_encode($signature);
            return $header_encoded. '.' . $payload_encoded . '.' .$signature_encoded;
        }

        static function Verify($token,$key){
            $token_parts = explode('.',$token);

            $signature = base64_encode(hash_hmac('SHA256',$token_parts[0] . $token_parts[1], $key));

            if($signature != $token_parts[2]){
                return false;
            }

            $payload = json_decode(base64_decode($token_parts[1]),true);
            return $payload;
        }
    }
?>