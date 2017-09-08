<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
 exit; // finish preflight CORS requests here
}
if ( !empty($_REQUEST[ 'debug' ]) ) {
 $random = rand(0, intval($_REQUEST[ 'debug' ]) );
 if ( $random === 0 ) {
  header("HTTP/1.0 500 Internal Server Error");
  exit;
 }
}

// header("HTTP/1.0 500 Internal Server Error");
// exit;
// 最大执行时间为5分钟
@set_time_limit(5 * 60);
// Uncomment this one to fake upload time
// usleep(5000);
// Settings
// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
$targetDir = __DIR__.'\uploads'.DIRECTORY_SEPARATOR.'file_material_tmp';
$uploadDir = __DIR__.'\uploads'.DIRECTORY_SEPARATOR.'file_material';
$cleanupTargetDir = true; // Remove old files
//临时文件存在的最长时间
$maxFileAge = 5 * 3600; // Temp file age in seconds
// Create target dir 常见缓存目录
if (!file_exists($targetDir)) {
 @mkdir($targetDir);
}
// Create target dir 创建目标文件夹
if (!file_exists($uploadDir)) {
 @mkdir($uploadDir);
}
// Get a file name
if (isset($_REQUEST["name"])) {
 $fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
 $fileName = $_FILES["file"]["name"];
} else {
 $fileName = uniqid("file_");
}
//保存文件名字 便于后期存储 恢复文件名称
$oldName = $fileName;
$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
// $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
// Chunking might be enabled
//当前文件是第几片
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
//文件一共有几片
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
// Remove old temp files
if ($cleanupTargetDir) {
    //文件夹打开失败
 if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
  die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
 }
 while (($file = readdir($dir)) !== false) {
  $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
  // If temp file is current file proceed to the next
  // filename+_0.parttmp
  if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
   continue;
  }
  // Remove temp file if it is older than the max age and is not the current file
  if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
   @unlink($tmpfilePath);
  }
 }
 closedir($dir);
}

// Open temp file
if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
 die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}
if (!empty($_FILES)) {
 if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
  die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
 }
 // Read binary input stream and append it to temp file
 if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
  die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
 }
} else {
 if (!$in = @fopen("php://input", "rb")) {
  die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
 }
}
//将分片的文件进行 拼接
while ($buff = fread($in, 4096)) {
 fwrite($out, $buff);
}
@fclose($out);
@fclose($in);
rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");
$index = 0;
$done = true;
for( $index = 0; $index < $chunks; $index++ ) {
 if ( !file_exists("{$filePath}_{$index}.part") ) {
  $done = false;
  break;
 }
}



if ( $done ) {
 $pathInfo = pathinfo($fileName);
 $hashStr = substr(md5($pathInfo['basename']),8,16);
 $hashName = time() . $hashStr . '.' .$pathInfo['extension'];
 $uploadPath = $uploadDir . DIRECTORY_SEPARATOR .$hashName;

 if (!$out = @fopen($uploadPath, "wb")) {
  die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
 }
 if ( flock($out, LOCK_EX) ) {
  for( $index = 0; $index < $chunks; $index++ ) {
   if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
    break;
   }
   while ($buff = fread($in, 4096)) {
    fwrite($out, $buff);
   }
   @fclose($in);
   @unlink("{$filePath}_{$index}.part");
  }
  flock($out, LOCK_UN);
 }
 @fclose($out);
 $response = [
  'success'=>true,
  'oldName'=>$oldName,
  'filePaht'=>$uploadPath,
  'fileSize'=>$_REQUEST['size'],
  'fileSuffixes'=>$pathInfo['extension'],
//   'file_id'=>$data['id'],
  'file_id'=>$_REQUEST['id'],

  ];

 die(json_encode($response));
}

// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
?>