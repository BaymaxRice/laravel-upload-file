<?php

Route::group(['middleware' => config('upload-file.middleware')], function () {
    Route::post('upload/file', '\Baymax\LaravelUploadFile\UploadFileController@index');
});
