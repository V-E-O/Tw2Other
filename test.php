<?php

$fileHandler = fopen ( 'test', 'w+' );

if (! fwrite ( $fileHandler, 'test' )) {
	echo '请设置tw2other所在文件夹及cookies文件夹可写';

}
@fclose ( $fileHandler );

if (! function_exists ( 'curl_init' )) {
	exit ( '服务器不支持curl lib，无法使用' );
}


echo '很好，服务器环境可以运行TW2OTHER！';
?>