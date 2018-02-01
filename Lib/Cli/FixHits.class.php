<?php
namespace Lib\Cli ;

class Fixhits{



    public function run(){

        echo '修复点击次数记录 process ...' , PHP_EOL ;

        $hitsRecords = M('artlog')->field("articleid, count(*) as c")->group("articleid")->select();

        if (empty($hitsRecords)){
            echo '没有记录可修复 ' , PHP_EOL ;
            exit();
        }

        $articleModel = M("article") ;
        foreach ($hitsRecords as $item) {
            $articleModel->where('id='.$item['articleid'])->update(['hits'=>$item['c']]) ;
            echo 'fix id '.$item['articleid'].' ok total hits '.$item['c'] , PHP_EOL ;
        }


        echo 'done', PHP_EOL ;
        exit();
    }



}