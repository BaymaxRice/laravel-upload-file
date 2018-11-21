<?php

namespace Baymax\LaravelUploadFile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileStore
{
    /**
     * 将图片数组从tmp目录转到正式目录
     * @param string|array $url 图片
     * @param bool $is_array 是否是图片数组
     * @return array
     */
    public static function tmpStore($url, $is_array = false)
    {
        $url = (array)$url;
        if (count($url) == 1 && !$is_array) {
            return self::moveImg($url[0]);
        }

        $images = collect($url)->map(function ($item) {
            try {
                return self::moveImg($item);
            } catch (\Exception $exception) {
                return null;
            }
        })->values()->toArray();
        $images = array_filter($images);

        return $images;
    }

    /**
     * 将单个图片从tmp目录转到正式目录
     * @param string $img
     * @return null|string
     */
    public static function moveImg($img)
    {
        if ( !starts_with($img, 'tmp')) {
            return $img;
        }
        $path = 'image/' . Carbon::now()->format('Y-m-d');
        $result = Storage::move(
            'public/' . $img,
            'public/' . Str::replaceFirst('tmp', $path, $img)
        );
        return $result ? '/storage/' . Str::replaceFirst('tmp', $path, $img) : null;
    }

    /**
     * 删除图片
     * @param string|array $img 图片链接
     */
    public static function deleteStorageImg($img)
    {
        $img = (array)$img;
        foreach ($img as $value) {
            $pos = strpos($value, 'storage');
            if ($pos !== false) {
                $value = mb_substr($value, $pos + mb_strlen('storage'));
            }
            Storage::delete('public' . $value);
        }
    }
}
