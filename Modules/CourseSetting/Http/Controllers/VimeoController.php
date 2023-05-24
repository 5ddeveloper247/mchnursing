<?php

namespace Modules\CourseSetting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Vimeo\Vimeo;

class VimeoController extends Controller
{
    public function getAllVimeoData(Request $request)
    {
        try {
            $video_list = [];
            if (empty($this->configVimeo())) {
                return $video_list;
            }
            if ($request->page) {
                $page = $request->page;
            } else {
                $page = 1;
            }

            if ($request->search) {
                $search = $request->search;
            } else {
                $search = '';
            }
            $vimeo_video_list = $this->getVideoFromVimeoApi($page, $search);

            if (isset($vimeo_video_list['body']['data'])) {
                if (count($vimeo_video_list['body']['data']) != 0) {
                    foreach ($vimeo_video_list['body']['data'] as $data) {
                        $video_list[] = $data;
                    }
                }
            }


        } catch (\Exception $e) {
        }


        $response = [];
        foreach ($video_list as $item) {
            $response[] = [
                'id' => $item['uri'],
                'text' => $item['name'],
            ];
        }
        $output['results'] = $response;
        $output['pagination'] = ["more" => count($response) != 0];

        return response()->json($output);

    }

    public function getSingleVimeoData(Request $request)
    {
        try {
            if ($this->configVimeo()) {
                $item = $this->configVimeo()->request('/videos', [
                    'uris' => $request->uri,
                ], 'GET');
                $result = null;
                if (isset($item['body']['data'])) {
                    if (count($item['body']['data']) != 0) {
                        foreach ($item['body']['data'] as $data) {
                            $result = $data;
                        }
                    }
                }
                return response()->json($result);
            } else {
                return null;
            }

        } catch (\Exception $e) {
            return null;
        }
    }


    public function uploadFileIntoVimeo($course_title, $file)
    {
        try {
            $response = $this->configVimeo()->upload($file, [
                'name' => $course_title,
                'privacy' => [
                    'view' => 'disable',
                    'embed' => 'whitelist'
                ],
                'embed' => [
                    'title' => [
                        'name' => 'hide',
                        'owner' => 'hide',
                    ]
                ]
            ]);
            $this->configVimeo()->request($response . '/privacy/domains/' . request()->getHttpHost(), [], 'PUT');
            return $response;
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), trans('common.Failed'));
            return null;
        }
    }

    public function configVimeo()
    {
        try {

            if (config('vimeo.connections.main.common_use')) {
                $vimeo_client = saasEnv('VIMEO_CLIENT');
                $vimeo_secret = saasEnv('VIMEO_SECRET');
                $vimeo_access = saasEnv('VIMEO_ACCESS');
            } else {
                $vimeos = Cache::rememberForever('vimeoSetting_' . SaasDomain(), function () {
                    return \Modules\VimeoSetting\Entities\Vimeo::all();
                });
                $vimeo = $vimeos->where('created_by', Auth::user()->id)->first();
                if ($vimeo) {
                    $vimeo_client = $vimeo->vimeo_client;
                    $vimeo_secret = $vimeo->vimeo_secret;
                    $vimeo_access = $vimeo->vimeo_access;
                }

            }
            if (empty($vimeo_secret) || empty($vimeo_client)) {
                return null;
            }
            $lib = new  Vimeo($vimeo_client, $vimeo_secret);
            $lib->setToken($vimeo_access);
            return $lib;
        } catch (\Exception $e) {
            return null;
        }
    }


    public function getVideoFromVimeoApi($page = 1, $search = null)
    {
        try {
            if (config('vimeo.connections.main.upload_type') == "Direct") {
                return [];
            }
            if ($this->configVimeo()) {
                return $this->configVimeo()->request('/me/videos', [
                    'per_page' => 10,
                    'page' => $page,
                    'query' => $search
                ], 'GET');
            } else {
                return [];
            }

        } catch (\Exception $e) {
            return [];
        }
    }
}
