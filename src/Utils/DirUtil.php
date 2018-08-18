<?php
/**
 * Created by PhpStorm.
 * User: qihao
 * Date: 2018/7/20
 * Time: 10:13
 */

namespace Summergeorge\GitBookLib\Utils;


use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DirUtil
{
    /**
     * 用于遍历所有文件目录
     *
     * @param $dir 遍历的目标文件夹
     * @param $arr 文件路径集合
     * @return bool
     */
    public function read_all ($dir,&$arr){
        if(!is_dir($dir)) return false;
        $handle = opendir($dir);
        if($handle){
            while(($fl = readdir($handle)) !== false){
                $temp = $dir.DIRECTORY_SEPARATOR.$fl;
                //如果不加  $fl!='.' && $fl != '..'  则会造成把$dir的父级目录也读取出来

                if(is_dir($temp) && $fl!='.' && $fl != '..'){
                    $this->read_all($temp,$arr);
                }else{
                    if($fl!='.' && $fl != '..'){
                        $arr[] = $temp;
                    }
                }

            }
        }
    }

    /**
     * 将目录中中文命名的图片改为英文
     *
     * @param $dir 遍历的目标文件夹
     * @return array
     */
    public function ChangeZh($dir){
        $this->read_all($dir,$tmps);

        //存放图片路径
        $imgs = [];

        //存放md文件路径
        $mds = [];
        foreach ($tmps as $index => $tmp){
            if(ends_with($tmp,'.md')){
                $mds[] = $tmp;
            }
            if(ends_with($tmp,'.png')){
                $imgs[] = $tmp;
            }
        }
        if(count($imgs) == 0 || count($mds) == 0){
            return ["code" => 1,"message" => "没有文件需要更改！"];
        }

        foreach ($imgs as $img){
            if(str_finish($img,'.png')){
                $name = basename($img);
                if(preg_match('/[\x7f-\xff]/', $name)){
                    $new_name = "new_".str_random('8')."_".time().".png";
                    $new_path = str_replace($name,$new_name,$img);
                    if(file_exists($img)){
                        if(rename($img,$new_path)){
                            foreach ($mds as $dir){
                                if(file_exists($dir)){
                                    $content = file_get_contents($dir);
                                    if(str_contains($content,$name)){
                                        $new_content = str_replace($name,$new_name,$content);
                                        file_put_contents($dir,$new_content);
                                    }
                                }
                            }
                        }else{
                            return ["code" => -1,"message" => "修改失败！"];
                        }
                    }
                }
            }
        }
        return ["code" => 0,"message" => "修改成功！"];
    }

    /**
     * 执行shell脚本
     *
     * @param $command 命令
     * @return array 返回output内容
     */
    public function runCommand($commands,&$command = null)
    {
        if(is_array($commands)){
            $command = implode(" && ",$commands);
        }else if(is_string($commands)){
            $command = $commands;
        }else{
            throw new \RuntimeException('Commands can not exec!');
        }

        $output = '';
        $process = new Process($command);
        $process->setTimeout(3600);
        $process->setIdleTimeout(1200);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output =  $process->getOutput();
        Log::debug('command:'.$command);
        Log::debug('output:'.$output);
        return $output;
    }
}
