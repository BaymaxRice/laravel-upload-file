

# install

`composer require baymaxrice/laravel-upload-file`

# usage 

- 发布配置文件

`php artisan vendor:publish --provider="Baymax\LaravelUploadFile\UploadFileServiceProvider"`

- 系统会自动创建一条路由： `/upload/file`

- 访问该接口时候，如上传文件，则携带参数：file=1，如上传图片，则携带参数：img=1。。。

--- 

- 注意事项：

开启缓存之后，上传图片，返回json格式回复，具体内容如下：

```json
{
    "status": "success",
    "code": 200,
    "message": "tmp/RmxBSXl5EKtd6BBZEr338SQqBo4CLGafadK0t0LK.jpeg"
}
```
需要在用户提交该字段之后，假如上传的为用户头像字段，则在用户Model当中做如下处理：

```php
    public function getAvatarAttribute($value)
    {
        return FileStore::showImages($value);
    }

    public function setAvatarAttribute($value)
    {
        return $this->attributes['avatar'] = FileStore::tmpStore($value);
    }
```

如果参数是图片数组，则传入第二个参数为：`true`


如不开启缓存，则直接返回图片实际存储路径：

```json
{
    "status": "success",
    "code": 200,
    "message": "images/2018-11-20/0jas5bd2VimrydJCvOeXQ1biTbzAiHN3Mm6zhWid.jpeg"
}
```



## License

MIT
