<?php
require_once(dirname(__DIR__) . '/config/mrbs.php');
require_once(dirname(__DIR__) . '/config/config.php');

function getAccessCode(): string
{
    $roomNo = str_replace('-', '', $_SESSION['username']);
    $roomNo = str_replace('0', '8', $roomNo);
    $userId = str_replace('0', '8', $_SESSION['userID']);
    $to_append = substr($userId, 0, 1);
    return $roomNo . $to_append;
}

function formatUnixTimestamp($timestamp): string
{
    $date = new DateTime();
    $date->setTimestamp($timestamp);
    $date->setTimezone(new DateTimeZone('Europe/Berlin')); // Set the correct time zone
    $formatted_date = $date->format('Y-m-d\TH:i:s.vP'); // Use 'P' to include the timezone offset
    return $formatted_date;
}

function getKitchenReservationsForUser($username){
    global $mrbs;

    $one_day_ago = time() - 86400;

    $stmt = $mrbs->prepare("SELECT * FROM `mrbs_entry` WHERE room_id=4 AND create_by=:username AND start_time >= :oneDayAgo");
    $stmt->bindParam('username', $username);
    $stmt->bindParam('oneDayAgo', $one_day_ago, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function grantAccess($reservationId, $startTime, $endTime, $code){
    $curl = curl_init();
    $post_data = [
        'name' => $reservationId.'-'.$_SESSION['userID'],
        'type' => 13,
        'allowedFromDate' => $startTime,
        'allowedUntilDate' => $endTime,
        'allowedFromTime' => 0,
        'allowedUntilTime' => 0,
        'allowedWeekDays' => 127,
        'remoteAllowed' => false,
        'enabled' => true,
        'code' => $code
    ];

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.nuki.io/smartlock/".SMARTLOCK_ID."/auth",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => json_encode($post_data),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . NUKI_API_KEY,
            "Content-Type: application/json",
            "User-Agent: insomnia/10.0.0"
        ],
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    http_response_code($httpCode);
    $curlError = curl_error($curl);

    return $response;
}

function filterAccessCodes($objects, $userId) {
    $filteredObjects = [];

    foreach ($objects as $object) {
        // Check if the name contains a dash
        if (strpos($object->name, '-') !== false) { // Accessing name property as object
            // Isolate the part behind the dash
            $nameParts = explode('-', $object->name);
            $partBehindDash = $nameParts[1];

            // Check if the part behind the dash matches the given number (userId)
            if ($partBehindDash == $userId) {
                $filteredObjects[] = $object; // Add the object to the filtered list
            }
        }
    }

    return $filteredObjects;
}

function getGrants(){
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.nuki.io/smartlock/".SMARTLOCK_ID."/auth",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . NUKI_API_KEY,
            "Content-Type: application/json",
            "User-Agent: insomnia/10.0.0"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response);
}

function getGrantsForUser($user_id){
    return filterAccessCodes(getGrants(), $user_id);
}

function getBookingId($bookingName){
    $nameParts = explode('-', $bookingName);
    return $nameParts[0];
}

function deleteGrant($authId){
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.nuki.io/smartlock/".SMARTLOCK_ID."/auth/" . $authId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . NUKI_API_KEY,
            "Content-Type: application/json",
            "User-Agent: insomnia/10.0.0"
        ],
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);
    return $httpCode;
}