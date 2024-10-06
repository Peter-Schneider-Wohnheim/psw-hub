<?php
require_once(dirname(__DIR__) . '/config/tenantlist.php');
function searchUser($searchQuery){
    global $tenantlist;

    if($searchQuery == ""){
        $stmt = $tenantlist->prepare("SELECT * FROM `users`");
        $stmt->execute();
        return $stmt->fetchAll();
    } else {
        $stmt = $tenantlist->prepare("SELECT * FROM `users` WHERE wordpress_id LIKE :search OR first_name LIKE :search OR last_name LIKE :search OR room LIKE :search");
        $stmt->bindParam('search', $searchQuery);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

function getUserByID($id){
    global $tenantlist;

    $stmt = $tenantlist->prepare("SELECT * FROM `users` WHERE id = :id");
    $stmt->bindParam('id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function getWordPressUserDetails($wpId){
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => WP_API_BASE . "/users/" . $wpId ."?context=edit",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => [
            "Authorization: Basic " . WP_API_KEY,
            "User-Agent: insomnia/10.0.0"
        ],
    ]);

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response, true);
}