<?php
$db = mysqli_connect("localhost","root","root1234","magzhub"); //keep your db name
$sql = "SELECT issueThumbnail FROM tempissueupload WHERE issueId =31";
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);
echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['issueThumbnail'] ).'"/>';
?>