<?php

/*
 * This file is part of the overtrue/laravel-ueditor.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Bestlang\LaravelUEditor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class UEditorController.
 */
class UEditorController extends Controller
{
    public function serve(Request $request)
    {
        $upload = config('ueditor.upload');
        $storage = app('ueditor.storage');

        $callback = $request->input('callback', null);

        switch ($request->get('action')) {
            case 'config':
                if($callback){
                    return response()->jsonp('callback', config('ueditor.upload'))->setCallback($callback);
                }
                return config('ueditor.upload');
            // lists
            case $upload['imageManagerActionName']:
                return $storage->listFiles(
                    $upload['imageManagerListPath'],
                    $request->get('start'),
                    $request->get('size'),
                    $upload['imageManagerAllowFiles']);
            case $upload['fileManagerActionName']:
                return $storage->listFiles(
                    $upload['fileManagerListPath'],
                    $request->get('start'),
                    $request->get('size'),
                    $upload['fileManagerAllowFiles']);
            case $upload['catcherActionName']:
                return $storage->fetch($request);
            default:
                return $storage->upload($request);
        }
    }
}
