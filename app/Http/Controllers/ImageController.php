<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Image;
class ImageController extends Controller
{
    /**
     * 文件上传类
     * @param Request $request
     * @return array
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('Filedata') and $request->file('Filedata')->isValid()) {

            //数据验证
            $allow = array('image/jpeg', 'image/png', 'image/gif');

            $mine = $request->file('Filedata')->getMimeType();
            if (!in_array($mine, $allow)) {
                return ['status' => 0, 'msg' => '文件类型错误，只能上传图片'];
            }

            //文件大小判断$filePath
            $max_size = 1024 * 1024 * 3;
            $size = $request->file('Filedata')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过3M'];
            }

            $date = date("Y_m");
            $path = getcwd() . '/images/' . $date;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            //生成新文件名
            $extension = $request->file('Filedata')->getClientOriginalExtension();      //取得之前文件的扩展名

            $file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $extension;
            $request->file('Filedata')->move($path, $file_name);
            $file_path = $path.'/'.$file_name;
            //生成缩略图
            $this->clip($file_path,$path);
            qiniu_upload($file_path);

            $file_name = basename($file_path);
            unlink($file_path);
            return ['status' => 1, 'medium' => config('qiniu.medium') . '/thumb_' . $file_name,'thumb' => config('qiniu.medium').'/' . $file_name];
        }
    }

    public function delete(Request $request)
    {
        qiniu_delete($request->url,$request->thumb);
    }
    /**
     * 生成缩略图 thumb medium
     * @param $file_path
     */
    private function clip($file_path,$path)
    {
        /**
         * thumb
         */
        $thumb_name = $path. '/thumb_'  . basename($file_path);
        $thumb = Image::make($file_path);
        $thumb->resize(config('images.image.thumb.width'), config('images.image.thumb.height'));
        $thumb->save($thumb_name);
        qiniu_upload($thumb_name);

        /**
         * medium
         */
//        $medium_name = $path . '/medium_' . basename($file_path);
//        $medium = Image::make($file_path);
//        $medium->resize(config('admin.image.medium.width'), config('admin.image.medium.height'));
//        $medium->save($medium_name);
//        qiniu_upload($medium_name);
    }


    public function uploadFocus(Request $request)
    {
        if ($request->hasFile('Filedata') and $request->file('Filedata')->isValid()) {
            //数据验证
            $allow = array('image/jpeg', 'image/png', 'image/gif');

            $mine = $request->file('Filedata')->getMimeType();
            if (!in_array($mine, $allow)) {
                return ['status' => 0, 'msg' => '文件类型错误，只能上传图片'];
            }
            $extension = $request->file('Filedata')->getClientOriginalExtension();
            //文件大小判断
            $max_size = 1024 * 1024;
            $size = $request->file('Filedata')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过1M'];
            }
            //上传文件夹，如果不存在，建立文件夹
            $path = getcwd().'/homestyle/focus/';
            //取得之前文件的扩展名
            $file_name = time().'.'.$extension;
            $request->file('Filedata')->move($path, $file_name);
            $thumb_name = $path. '/'  . basename($file_name);
            $thumb = Image::make($path.'/'.$file_name);
            $thumb->resize('1800', '956');
            $thumb->save($thumb_name);

            $medium_name = $path . '/small_' . basename($file_name);
            $medium = Image::make($path.'/'.$file_name);
            $medium->resize('300','159');
            $medium->save($medium_name);
            return ['status' => 1,'thumb' => '/homestyle/focus/'.$file_name,'small' => '/homestyle/focus/small_'.$file_name];
        }
    }


    //礼物图片
    public function gift(Request $request, $name = 'Filedata')
    {
        if ($request->hasFile($name) and $request->file($name)->isValid()) {
            $result = array();

            //文件类型
            $allow = array('image/jpeg', 'image/png', 'image/gif');
            $mine = $request->file($name)->getMimeType();
            if (!in_array($mine, $allow)) {
                $result['status'] = 0;
                $result['info'] = '文件类型错误，只能上传图片';
                return $result;
            }

            //文件大小判断
            $max_size = 1024 * 1024;
            $size = $request->file($name)->getClientSize();
            if ($size > $max_size) {
                $result['status'] = 0;
                $result['info'] = '文件大小不能超过1M';
                return $result;
            }

            //上传文件夹，如果不存在，建立文件夹
            $date = date("Y_m");
            $path = getcwd() . '/gift/' . $date;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            //生成新文件名
            $extension = $request->file($name)->getClientOriginalExtension();      //取得之前文件的扩展名

            $file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $extension;
            $request->file($name)->move($path, $file_name);
//            if (in_array($mine, ['image/jpeg', 'image/png',])) {
//                $thumb_name = $path. '/'  . basename($file_name);
//                $thumb = Image::make($path.'/'.$file_name);
//                $thumb->resize('110', '110');
//                $thumb->save($thumb_name);
//            }
//            if (in_array($mine, ['image/gif'])) {
//                $thumb_name = $path. '/gif'  . basename($file_name);
//                $thumb = Image::make($path.'/'.$file_name);
//                $thumb->resize('60', '60');
//                $thumb->save($thumb_name);
//            }

            //返回新文件名
            $result['status'] = 1;
            $result['info'] = '/gift/' . $date . '/' . $file_name;
            return $result;
        }
    }
    /**
     * 上传网站ico图标
     * @param Request $request
     * @return array
     */
    public function upload_icon(Request $request)
    {
        if ($request->hasFile('Filedata') and $request->file('Filedata')->isValid()) {//数据验证
            $allow = array('image/jpeg', 'image/png');
            $mine = $request->file('Filedata')->getMimeType();
            if (!in_array($mine, $allow)) {
                return ['status' => 0, 'msg' => '文件类型错误，只能上传图片'];
            }
            //文件大小判断
            $max_size = 1024 * 1024;
            $size = $request->file('Filedata')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过1M'];
            }

            //上传文件夹，如果不存在，建立文件夹
            $path = getcwd().'/assets/images/';

            $file_name = "favicon.ico";
            $request->file('Filedata')->move($path, $file_name);
            return ['status' => 1,'ico' => '/assets/images/'.$file_name];
        }
    }


    /**
     * 上传网站logo图标
     * @param Request $request
     * @return array
     */
    public function upload_logo(Request $request)
    {
        if ($request->hasFile('Filedata') and $request->file('Filedata')->isValid()) {
            //数据验证
            $allow = array('image/jpeg', 'image/png', 'image/gif');

            $mine = $request->file('Filedata')->getMimeType();
            if (!in_array($mine, $allow)) {
                return ['status' => 0, 'msg' => '文件类型错误，只能上传图片'];
            }
            $extension = $request->file('Filedata')->getClientOriginalExtension();
            //文件大小判断
            $max_size = 1024 * 1024;
            $size = $request->file('Filedata')->getClientSize();
            if ($size > $max_size) {
                return ['status' => 0, 'msg' => '文件大小不能超过1M'];
            }
            //上传文件夹，如果不存在，建立文件夹
            $path = getcwd().'/assets/images/';
            //取得之前文件的扩展名

            $file_name = "logo.".$extension;
            $request->file('Filedata')->move($path, $file_name);
            return ['status' => 1,'logo' => '/assets/images/'.$file_name];
        }
    }

    public function upThumb(Request $request, $name = 'Filedata', $depath = '/finder/images/')
    {
        if ($request->hasFile($name) and $request->file($name)->isValid()) {
            $result = array();

            //文件类型
            $allow = array('image/jpeg', 'image/png', 'image/gif');
            $mine = $request->file($name)->getMimeType();
            if (!in_array($mine, $allow)) {
                $result['status'] = 0;
                $result['info'] = '文件类型错误，只能上传图片';
                return $result;
            }

            //文件大小判断
            $max_size = 1024 * 1024;
            $size = $request->file($name)->getClientSize();
            if ($size > $max_size) {
                $result['status'] = 0;
                $result['info'] = '文件大小不能超过1M';
                return $result;
            }

            //上传文件夹，如果不存在，建立文件夹
            $date = date("Y_m");
            $path = getcwd() . $depath . $date;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            //生成新文件名
            $extension = $request->file($name)->getClientOriginalExtension();      //取得之前文件的扩展名

            $file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $extension;
            $request->file($name)->move($path, $file_name);
            //返回新文件名
            $result['status'] = 1;
            $result['info'] = $depath . $date . '/' . $file_name;
            return $result;
        }
    }
}
