<?php 

//$key_path = "../../resources/storage/shcp_files/CSD_Escuela_Kemper_Urgate_EKU9003173C9_20190617_131753.key";
//$cmd = "openssl pkcs8 -inform DET -in ".$key_path." -passin pass:12345678a -out ../../resources/storage/shcp_files/llave.key.pem";

$key_path = "../../resources/storage/shcp_files/CSD_Escuela_Kemper_Urgate_EKU9003173C9_20190617_131753s.cer";
$cmd = "openssl pkcs8 -inform DET -in ".$key_path." -passin pass:12345678a -out ../../resources/storage/shcp_files/certi.cer.pem";

shell_exec($cmd);

?>