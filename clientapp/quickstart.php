<?php
require 'google-api/src/Google/autoload.php';
require '../database/dbOperation.php';
$dboperationObj= new dboperation();
$issueId=$_POST['issueId'];
$details=$dboperationObj->getDetailsForUploadingInGoogleDrive($issueId);

$path='../services/uploads/';
$fileName=$details['name'];
DEFINE("TESTFILE", $path.$fileName);
define('APPLICATION_NAME', 'Drive API Quickstart');
define('CREDENTIALS_PATH', 'drive-api-quickstart.json');
define('CLIENT_SECRET_PATH', 'client_secret.json');
define('SCOPES', implode(' ', array(
  Google_Service_Drive::DRIVE)
));

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfigFile(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');
  $client->setApprovalPrompt('force');



  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);

  //delete credential file if token issue arises
  /*if(file_exists($credentialsPath)){
    unlink($credentialsPath);
  }*/

  if (file_exists($credentialsPath)) {
    $accessToken = file_get_contents($credentialsPath);
    //print $accessToken;
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->authenticate($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, $accessToken);
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->refreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, $client->getAccessToken());
  }
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Drive($client);
$ch = curl_init();
curl_setopt($ch, CURLOPT_TIMEOUT,0);
// Print the names and IDs for up to 10 files.
/*$optParams = array(
  'maxResults' => 10,
);
$results = $service->files->listFiles($optParams);*/


 $file = new Google_Service_Drive_DriveFile();
$file->title = $fileName;
$chunkSizeBytes =  1* 1024 * 1024;

// Call the API with the media upload, defer so it doesn't immediately return.
$client->setDefer(true);
$request = $service->files->insert($file);

// Create a media file upload to represent our upload process.
$media = new Google_Http_MediaFileUpload(
  $client,
  $request,
  'application/pdf',
  null,
  true,
  $chunkSizeBytes
);
$media->setFileSize(filesize(TESTFILE));

// Upload the various chunks. $status will be false until the process is
// complete.
$status = false;
$handle = fopen(TESTFILE, "rb");
while (!$status && !feof($handle)) {
  $chunk = fread($handle, $chunkSizeBytes);
  $status = $media->nextChunk($chunk);
 }

// The final value of $status will be the data from the API for the object
// that has been uploaded.
$result = false;
if($status != false) {
  $result = $status;
}

fclose($handle);
// Reset to the client to execute requests immediately in the future.
$client->setDefer(false);
$fileId=$result->getId();
$dboperationObjFileId=new dboperation();
$dboperationObjFileId->insertFileIdInTempIssueUpload($fileId,$issueId);
$dboperationObjInsertInIssue=new dboperation();
$dboperationObjInsertInIssue->insertDetailsIntoIssuesTable($issueId);


/*
if (count($results->getItems()) == 0) {
  print "No files found.\n";
} else {
  print "Files:\n";
  foreach ($results->getItems() as $file) {
    printf("%s (%s)\n", $file->getTitle(), $file->getId());
  }
}*/
?>
