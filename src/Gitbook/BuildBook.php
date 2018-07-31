<?php
/**
 * Created by PhpStorm.
 * User: qihao
 * Date: 2018/7/17
 * Time: 18:07
 */

namespace Summergeorge\GitBookLib\Gitbook;


use App\Http\Controllers\Controller;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Log;
use Summergeorge\GitBookLib\Utils\DirUtil;

class BuildBook extends Controller
{
    protected $dirutil,$publish_info;

    /**
     * @var Repository
     */
//    protected $config;


    /**
     * BuildBook constructor.
     * @param $publish_info
     */
    public function __construct($publish_info)
    {
        $this->dirutil = new DirUtil();
        $this->publish_info = $publish_info;
//        $this->config = new config();
    }

    /**
     * 执行build操作
     *
     * @return array 返回日志
     */
    public function build(){
        $git_path = storage_path('gitbook/'.$this->publish_info['id']."/".str_random(6));
        $git_cache_path = storage_path('gitcache/'.$this->publish_info['id']);
        $path = $git_path;
        if(isset($git_path)){
            $path = $git_path."/".$git_path;
        }
        $web_dir = public_path($this->publish_info['web_dir']);
        $pdf_path =$web_dir."/book.pdf";
        $branch = $this->publish_info['git_branch'];
        $user = $this->publish_info['git_user'];
        $password = $this->publish_info['git_password'];
        $git_url = $this->publish_info['git_url'];
        if(!empty($password)){
            $git_url = str_replace("://","://$user:".urlencode($password)."@",$git_url);
        }

        // 更新自己
//        $commandUpdateSelf = [
//            "cd ".base_path(''),
//            "git pull"
//        ];
//        $this->Runner($commandUpdateSelf);



        $commands = [];

        // 启用cache模式时，检查目录是否存在
        if(config('book.cache')){
            if(is_dir(str_finish($git_cache_path,"/").".git")){
                //准备代码
                $commands[] =  [
                    "cd $git_cache_path",
                    "git checkout $branch",
                    "git pull",
                ];
            }else{
                //准备代码
                $commands[] =  [
                    "rm -rf $git_cache_path",
                    "mkdir -p $git_cache_path",
                    "git clone -b $branch $git_url $git_cache_path --single-branch -q",

                ];
            }
            $commands[] = [
                "rm -rf $path",
                "mkdir -p $path",
                "\cp -R $git_cache_path/* $path",
            ];
        }else{
            //准备代码
            $commands[] =  [
                "rm -rf $path",
                "mkdir -p $path",
                "git clone -b $branch $git_url $git_path --single-branch -q",
            ];
        }



        //注意：当图片路径存在中文时，pdf生成会出现问题，所以要把中文名称的图片重命名
//        if(config('book.change-zh')){
//            $dirUtil = new DirUtil();
//            $res = $dirUtil->ChangeZh($path);
//            Log::info($path,$res);
//        }


        //1. 生成book.json配置文件for web
        $builder = new ConfigBookJson();
        $book_json = $builder->analysisConfig($this->publish_info);

        $commands[] = [
            "rm -rf $path/styles/",
            "rm -rf $path/book.json",
            "\cp -Rv ".base_path('publisher')."/* $path",
            "rm -rf $path/styles/header.html",
            "\cp -Rv ".base_path('publisher/header.html')." $path/styles/header.html",
        ];

        //2. 生成book.json配置文件for pdf
        $builder = new ConfigBookJson();
        $builder->setPdfConfig($this->publish_info);

        switch (config('book.engine')){
            case "docker":
                // 执行build docker
                $commands[] =  [
                    "docker run --rm -v \"$path:/gitbook\" billryan/gitbook:zh-hans gitbook install",
                    "docker run --rm -v \"$path:/gitbook\" billryan/gitbook:zh-hans gitbook build",
                ];

                $commands[] =  [
                    "rm -rf $path/book.json",
                    "\cp -Rv ".base_path('publisher')."/pdf.json $path/book.json",
                    "docker run --rm -v \"$path:/gitbook\" billryan/gitbook:zh-hans gitbook pdf",
                ];

                break;
            case "shell":
                // 执行build shell
                $commands[] =  [
                    "cd $path && gitbook install",
                    "cd $path && gitbook build",
                ];

                $commands[] =  [
                    "rm -rf $path/book.json",
                    "\cp -Rv ".base_path('publisher')."/pdf.json $path/book.json",
                    "cd $path && gitbook pdf",
                ];
                break;
        }


        // 搬运代码和清理现场
        $commands[] =  [
            "rm -rf $web_dir",
            "mkdir -p $web_dir",
            "mv $path/_book/* $web_dir",
            "mv $path/book.pdf $pdf_path",
            "rm -rf $path",
        ];
//        $this->Runner($commands);
//     执行
        $uuid = str_random();
        Log::info("$uuid:build start-".$this->publish_info['title']);
        $publishlog = [
            'pid' => $this->publish_info['id'],
            'book_json' => $book_json,
        ];
        $output = [];
        try{
            chdir(base_path());
            Log::info("getcwd:".getcwd());
            foreach ($commands as $command){
                $this->Runner($command,$output);
            }
            $publishlog['status'] = 'success';
            Log::info("$uuid:build success!-".$this->publish_info['title']);
        }catch (\Exception $exception){
            $output[] = [
                'command' => '',
                'output' => $exception->getMessage()
            ];
            $publishlog['status'] = 'failed';

            Log::info("$uuid:build error!-".$this->publish_info['title']);
            Log::error($exception);
        }


        //格式化shell output
        $log = [];
        foreach ($output as $item){
            if(empty($item['output'])){
                $log[] = "<p><strong>".$item['command']."</strong></p>null";
            }else{
                $log[] = "<p><strong>".$item['command']."</strong></p>".implode("<p>",$item['output']);
            }

        }
        $logs = implode("<HR>",$log);

        //隐藏密码
        if(!empty($password)){
            $logs = str_replace(":$password@",":******@",$logs);
        }

        $publishlog['log'] = $logs;
//        PublishBuildLog::create($publishlog);
        return $publishlog;
    }


    /**
     * @param array $commandLine
     * @return array
     */
    protected function Runner(array  $commandLine,&$output){
        $command = implode(" && ",$commandLine);
        $res = $this->dirutil->runCommand($command);
        $output[] = [
            "command" => $command,
            "output" => $res
        ];
        return $res;
    }
}
