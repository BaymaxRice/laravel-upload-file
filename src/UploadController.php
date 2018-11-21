<?php

namespace Baymax\LaravelUploadFile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadFileController
{
    public function index(Request $request)
    {
        $uploaddir = config('upload-file.tmp') ? 'tmp' : 'images/' . Carbon::now()->format('Y-m-d');

        if ( !empty(\request()->file('file'))) {
            $this->uploadFile($request);
        }

        if (empty(\request()->file('img'))) {
            return $this->failed('上传内容为空！');
        }

        if ($request->has('editor') && $request->get('editor')) {
            $uploaddir = 'images/' . Carbon::now()->format('Y-m-d');
        }

        try {
            $file_extension = \request()->file('img')->extension();

            if ( !in_array(strtolower($file_extension), config('upload-file.img.supported_formats'))) {
                return $this->failed('上传图片格式错误！');
            }

            if (\request()->file('img')->getSize() > 10 * 1024 * 1024) {
                return $this->failed('上传图片不能超过10M！');
            }

            $path = $request->file('img')->store($uploaddir, 'public');

            if ($request->has('editor') && $request->get('editor')) {
                return $this->message(url(Storage::url($path)));
            }
            return $this->message($path);
        } catch (\Exception $exception) {
            return $this->failed('上传失败，请稍后再试！', 500);
        }
    }

    public function music(Request $request)
    {
        $uploaddir = 'musics/' . Carbon::now()->toDateString();

        if (empty(\request()->file('music'))) {
            return $this->failed('上传内容为空！');
        }

        try {
            $file_extension = \request()->file('music')->extension();

            if ( !in_array(strtolower($file_extension), ['mp3', 'mp4', 'cda', 'wav', 'mpeg', 'wma', 'm4a', 'mpga'])) {
                return $this->failed('上传音频格式错误！');
            }

            if (\request()->file('music')->getSize() > 50 * 1024 * 1024) {
                return $this->failed('上传音频不能超过50M！');
            }

            $path = $request->file('music')->store($uploaddir, 'public');

            return $this->message('/storage/' . $path);
        } catch (\Exception $exception) {
            return $this->failed('上传失败，请稍后再试！');
        }
    }

    public function uploadFile(Request $request)
    {
        $uploaddir = 'files/' . Carbon::now()->toDateString();

        if (empty(\request()->file('file'))) {
            return $this->failed('上传内容为空！');
        }

        try {
            $file_extension = \request()->file('file')->extension();

            // todo 添加自己需要上传的格式自己的格式
            if ( !in_array(strtolower($file_extension), ['.exe', '.doc',])) {
                return $this->failed('上传格式错误！');
            }

            if (\request()->file('file')->getSize() > 50 * 1024 * 1024) {
                return $this->failed('上传文件不能超过50M！');
            }

            $path = $request->file('file')->store($uploaddir, 'public');

            return $this->message('/storage/' . $path);
        } catch (\Exception $exception) {
            return $this->failed('上传失败，请稍后再试！', 500);
        }
    }

    public function failed($msg, $code = 400)
    {
        return response()->json([
            'status'  => 'error',
            'code'    => $code,
            'message' => $msg,
        ], $code);
    }

    public function message($msg, $code = 200)
    {
        return response()->json([
            'status'  => 'success',
            'code'    => $code,
            'message' => $msg,
        ], $code);
    }
}
