<?php
/**
 * Created by PhpStorm.
 * User: qihao
 * Date: 2018/7/17
 * Time: 18:07
 */

namespace Summergeorge\GitBookLib\Gitbook;


use App\Http\Controllers\Controller;
use App\PublishInfoModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;


class ConfigBookJson extends Controller
{
    protected $publish_info,$config;

    public function analysisConfig($publish_info,$path){
        $config = [];
        $config['title'] = $publish_info['title'];
        $config['description'] = $publish_info['description'];

        $base_url = str_finish(config('book.base_url'),'/');

        if(isset($links)){
//            $config['links'] = [
//                'sidebar' => [
//                    "<i class='fa fa-fw fa-file-pdf-o fa-lg'></i>下载pdf" => "/v4/book.pdf",
//                ]
//            ];
            $config['links'] = unserialize($publish_info['links']);
        }else{
            $config['links'] = [
                'sidebar' => [
                    "<i class='fa fa-fw fa-file-pdf-o fa-lg'></i>下载pdf" =>  $base_url.$publish_info['web_dir']."/book.pdf",
                ]
            ];
        }



        //启用github链接（在文档右上角展示）
        if(isset($publish_info['github_url'])){
            $config['github'] =[
                'url' => $publish_info['github_url'],
            ];
        }
//        $config['github'] =[
//            'url' => "https://git.ishopex.cn/onex-doc/bbc-manual.git",
//        ];

        //启用版本跳转（对于有多个版本的文档使用）
        if(isset($publish_info['versions_select'])){
            $config['versions-select'] = unserialize($publish_info['versions_select']);
        }

//        $config['versions-select'] = [
//            'gitbookConfigURL' => "https://git.ishopex.cn/onex-doc/bbc-manual/blob/v4.0/book.json",
//            'options' => [
//                [
//                    "value" => "http://192.168.75.100:81/v4",
//                    "text" => "商派B2B2C v4.0操作文档",
//                ],
//                [
//                    "value" => "http://192.168.75.100:81/v4",
//                    "text" => "商派B2B2C v4.0操作文档",
//                ]
//            ]
//        ];


        //启用编辑文档链接（在左上角展示）
        if(isset($publish_info['edit_link'])){
            $config['edit-link'] = [
                'base' => $publish_info['edit_link'],
                'label' => "编辑本页面"
            ];
        }
//        $config['edit-link'] = [
//            'base' => "https://git.ishopex.cn/onex-doc/bbc-manual/blob/v4.0/",
//            'label' => "编辑本页面"
//        ];

        // 设置首页地址
        // if(file_exists($path.'/styles/header.html')){
        //     $content = file_get_contents($path.'/styles/header.html');
        //     $content1 = str_replace("%URL%",$base_url,$content);
        //     file_put_contents($path.'/styles/header.html',$content1);
        // }
        //设置header等信息
        $this->makeCustomFile($path,$publish_info);

        return $this->setConfig($config);

    }

    /** 生成versions_select对应的序列化内容
     * @param $ids
     * @return string
     */
    public function makeVersionSelect($versions){
        $option = [];
        foreach ($versions as $item){
//            $infoModel = PublishInfoModel::find($id);
            if($item){
                $option[] = [
                    "value" => config('book.base_url').'/'.$item->web_dir."/",
                    "text" => $item->title,
                ];
            }
        }
        $config = [
//            'gitbookConfigURL' => "https://git.ishopex.cn/onex-doc/bbc-manual/blob/v4.0/book.json",
            'options' => $option
        ];
        return serialize($config);
    }

    /**
     * 生成gitbook header footer 等自定义的html
     *
     * @param $path
     * @param $publishInfo
     * @return bool
     */
    public function makeCustomFile($path,$publishInfo){
        $base_url = str_finish(config('book.base_url'),'/');
        // 设置首页地址
        if(View::exists('vendor.gitbook.styles.header')){
            $content = View::make('vendor.gitbook.styles.header',['base_url' => $base_url]);
            file_put_contents(str_finish($path,'/').'styles/header.html',$content);
        }

        // 设置footer
        if(View::exists('vendor.gitbook.styles.footer')){
            $content = View::make('vendor.gitbook.styles.footer',['base_url' => $base_url]);
            file_put_contents(str_finish($path,'/').'styles/footer.html',$content);
        }
        // 设置样式
        if(file_exists(resource_path('views/vendor/gitbook/styles/website.css'))){
            $content = file_get_contents(resource_path('views/vendor/gitbook/styles/website.css'));
            file_put_contents(str_finish($path,'/').'styles/website.css',$content);
        }
        return true;
    }

    /**
     *  设置book.json
     * @param array $config
     */
    public function setConfig(array $config){
        $baseConfig = config('book.json');
//        $c = stripslashes($c);
        if(!isset($config)){
            throw new \RuntimeException('config 不能为空',500);
        }
        if(isset($config['title'])){
            $baseConfig['title'] = $config['title'];
        }

        if(isset($config['description'])){
            $baseConfig['description'] = $config['description'];
        }

        if(isset($config['links'])){
            $baseConfig['links']['sidebar'] = $config['links']['sidebar'];
        }

        if(isset($config['github'])){
            $baseConfig['plugins'][] = "github";
            $baseConfig['pluginsConfig']['github'] = [
                'url' => $config['github']['url']
            ];
        }

        if(isset($config['versions-select'])){
            $baseConfig['plugins'][] = "versions-select";
            $baseConfig['pluginsConfig']['versions'] = $config['versions-select'];
        }

        if(isset($config['edit-link'])){
            $baseConfig['plugins'][] = "edit-link";
            $baseConfig['pluginsConfig']['edit-link'] = $config['edit-link'];
        }


        $json = json_encode($baseConfig,JSON_UNESCAPED_UNICODE);
//        file_put_contents(storage_path('publisher/book.json'),$json);
//        Storage::disk('publisher')->put('book.json', $json);
        return $json;
    }

    public function setPdfConfig($infoModel){
        $baseConfig = config('book.pdf');

        if(!isset($infoModel)){
            throw new \RuntimeException('infomodel 不能为空',500);
        }
        $baseConfig['title'] = $infoModel['title'];
        $baseConfig['description'] = $infoModel['description'];


        $json = json_encode($baseConfig,JSON_UNESCAPED_UNICODE);
        return $json;
//        file_put_contents($path."/pdf.json",$json);
    }
}
