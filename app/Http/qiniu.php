<?php
use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
/**
 * 上传到七牛
 * @param $filePath 文件的绝对路径
 * @return array ['文件信息', '错误信息']
 */
function qiniu_upload($file_path)
{
    $accessKey = config('qiniu.accessKey');
    $secretKey = config('qiniu.secretKey');
    $auth = new Auth($accessKey, $secretKey);
    $bucket = config('qiniu.bucket');
    // 上传文件到七牛后， 七牛将文件名和文件大小回调给业务服务器
    $policy = array(
        'callbackUrl' => config('qiniu.url'),
        'callbackBody' => 'filename=$(fname)&filesize=$(fsize)'
    );
    $uptoken = $auth->uploadToken($bucket, null, 3600, $policy);
    // 上传到七牛后保存的文件名
    $key = basename($file_path);
    $uploadMgr = new UploadManager();
    $uploadMgr->putFile($uptoken, $key, $file_path);
}

function qiniu_delete($file_path,$thumb)
{
    $accessKey = config('qiniu.accessKey');
    $secretKey = config('qiniu.secretKey');
    $auth = new Auth($accessKey, $secretKey);
    $bucket = 'yiwang';
    //初始化BucketManager
    $bucketMgr = new BucketManager($auth);
    //你要测试的空间， 并且这个key在你空间中存在
    // 上传到七牛后保存的文件名
    $key = basename($file_path);
    $k = basename($thumb);
    //删除$bucket 中的文件 $key
    $bucketMgr->delete($bucket,$key);
    $bucketMgr->delete($bucket,$k);
}