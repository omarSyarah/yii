<?php

namespace console\controllers;

use common\models\Make;
use common\models\Post;
use Yii;
use yii\console\Controller;

/**
 * Test controller
 */
class TestController extends Controller {

    public function actionIndex() {
        echo "cron service runnning";



    }

    public function body($messages)
    {
        $x="";
         foreach ($messages as $message)
    {
        $x=$x. "<tr>
             <td >".
            $message['name'].
            " </td>
             <td>".
             $message['CountOfPosts'].
                "   
             </td>
             <td>
             ".
             $message['InactivePosts']
             ."
             
            </td>
            <td>
            ".
            $message['ActivePosts']
            ."
            </td>
         </tr>";
    };
        return"<html>
                    <body>
                            
                        <table border='1' cellpadding='0' width='335'>
                            <tr>
                                    <td >
                                    Make Name
                                    </td>
                                    <td >
                                    all count
                                    </td>
                                    <td >
                                    active count
                                    </td>
                                    <td >
                                    inactive count
                                    </td>
                                    
                                </tr>
                        ".
                           $x
                        ."
                            
                        </table>
                    </body>
                </html>";
    }
    public function mail($message)
    {
        $this->body($message);
        Yii::$app->mailer->compose()
            ->setFrom('bla@bla.com')
//            setTo('r.allfageer@syarah.com')
            ->setTo('o.hamdan@syarah.com')
            ->setSubject('monthly state email')
//            ->setTextBody()
            ->setHtmlBody($this->body($message))
            ->send();
    }


    public function actionEmail()
    {
//        return 'dasd';
//        echo 'dsd';
//        die;
//                $lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
//        echo $lastmonth ;
//        echo 'current time is: '.Yii::$app->formatter->asDate('now', 'y-M-d ');
        $today = date('Y-m-d');
        $x= date('Y-m-d',strtotime($today)-60*60*24*30).'00:00:00';
        $time= strtotime(Yii::$app->formatter->asDate('now', 'y-M-d HH:MM:SS'));
        echo 'time is:  '.$time;
//        print_r( Post::find()->all());


        //to check if its wokring change the 30 to a definitive date
        $newTime=$time-30* 60 * 60 * 24;

        echo 'new time is:   '.$newTime;
        $newTime=date("Y-m-d  H:i:s", $newTime);
//                              H:i:s
// 'sum(
//                CASE
//                    WHEN
//                        p.status =1 THEN 1
//                END AS Activeposts
//                )'

        $rows = new \yii\db\Query();

//        ['c' => new \yii\db\Expression("CASE  p.status =1 THEN 1 END")];
        $makes = $rows->select([
            'm.name',
            'sum(
                CASE
                    WHEN
                        p.status =1 THEN 1
                END 
                ) AS ActivePosts    ',
            'sum(
                CASE
                    WHEN
                        p.status =0 THEN 1
                END 
                ) AS InactivePosts',
            'count(p.id) AS CountOfPosts'


        ])
            ->from(['p' => 'posts'])
            ->innerJoin(['m' => 'makes'], '`p`.`make_id` = `m`.`id`')
            ->where(['>=','created_at',$newTime])
            ->groupBy(['m.name'])
            ->all();
        $messages=$makes;
//
////                var_dump($makes);
//        $makeNames=array();
//        $makePosts=array();
//        $makeInactives=array();
//        $makeActives=array();
//
//        foreach ($makes as $make) {
//            $makeNames[] = $make["name"];
//            $makePosts[] = $make["CountOfPosts"];
//            $makeInactives[] = $make["InactivePosts"];
//            $makeActives[] = $make["ActivePosts"];
//        }
//////            var_dump($make['name']);
////            echo "-----";
////            print_r($makeNames) ;
////            echo "-----";
////            print_r($makePosts) ;
////            echo "-----";
////            print_r($makeInactives) ;
////            echo "-----";
////            print_r($makeActives) ;
////
//////            $makeName=$makeName."  ".$make["name"];
//////            print_r() ;
////        }
////        echo "last make names is:";
////        print_r($makeNames);
////        die();
//        if($makeNames[0]==null)
//            $makes=0;
//        else
//             $makes=implode(' ',$makeNames);
//        if($makePosts[0]==null)
//            $posts=0;
//        else
//            $posts=implode(' ',$makePosts);
//        if($makeInactives[0]==null)
//            $Inactives=0;
//        else
//            $Inactives=implode(' ',$makeInactives);
//
//        if(!$makeActives[0]==null)
//            $actives=0;
//        else
//            $actives=implode(' ',$makeActives);
////        echo $makeName;
////        die();
//
//        //QUERY AND ACTIVE RECORD TRIES==============================================================================
////        echo "<pre>";
////        print_r($rows);
////        $posts=Post::find()->count();
////////        print_r($makes);
//////
////        echo "new date is:   ".$newTime;
////////         $time=date('Y-M-d', $newTime);
////         var_dump($posts) ;
//
//
////         $makeNames=Post::find()->select(['make_id'])->where(['>=','created_at',$newTime]);
////         print_r($makeNames);
////         foreach ($makeNames as $makeName)
////         {
////             var_dump( $makeName);
////         }
////        print_r(
////                (new \yii\db\Query())
////                ->select(['makes.name'])
////                ->from('posts')
////                ->join('INNER','makes','makes.id=posts.make_id')
////                ->all()
////                );
//
//        //        $rows = Post::find()
////            ->select(['makes.name'])
//////            ->from('posts as p')
////            ->leftJoin('makes', '`makes`.`id` = `posts`.`make_id`')
////            ->all();
////
////        $rows = Post::find()
//////            ->select(['name'])
////            ->joinWith('make', 'posts.make_id = makes.id')
//////            ->where('posts.make_id = makes.id')
////            ->all();
//
////        $rows = new \yii\db\Query();
////        $rows->select(['m.id'])->from('posts as p')
////                ->join('INNER JOIN', 'makes as m', 'p.make_id = m.id')->all();
////
//////        $command = $rows->createCommand();
////        return $rows;
//
////        $model = new Post();
////        $model = new Make();
////        $rows = Post::find()
////            ->select(['makes.name'])
//////            ->from('posts as p')
////            ->leftJoin('makes', '`makes`.`id` = `posts`.`make_id`')
////            ->all();
//
////        $rows = Make::find()->all();
////print_r($rows);
////die;
////END OF QUERYS AND ACTIVE RECORD TRIES============================================================================


//        $message=
//            'Make names of from one month ago is: '.$makes.
//            ' & The number of post from one month ago is: '.$posts.
//            '  & The number of acitve posts is : '.$actives.
//            ' & Tumber of inactive posts is : '.$Inactives;

        $this->mail($messages);
////                var_dump($makes);
//        $makeNames=array();
//        $makePosts=array();
//        $makeInactives=array();
//        $makeActives=array();
//
//        foreach ($makes as $make) {
//            $makeNames[] = $make["name"];
//            $makePosts[] = $make["CountOfPosts"];
//            $makeInactives[] = $make["InactivePosts"];
//            $makeActives[] = $make["ActivePosts"];
//        }
//////            var_dump($make['name']);
////            echo "-----";
////            print_r($makeNames) ;
////            echo "-----";
////            print_r($makePosts) ;
////            echo "-----";
////            print_r($makeInactives) ;
////            echo "-----";
////            print_r($makeActives) ;
////
//////            $makeName=$makeName."  ".$make["name"];
//////            print_r() ;
////        }
////        echo "last make names is:";
////        print_r($makeNames);
////        die();
//        if($makeNames[0]==null)
//            $makes=0;
//        else
//             $makes=implode(' ',$makeNames);
//        if($makePosts[0]==null)
//            $posts=0;
//        else
//            $posts=implode(' ',$makePosts);
//        if($makeInactives[0]==null)
//            $Inactives=0;
//        else
//            $Inactives=implode(' ',$makeInactives);
//
//        if(!$makeActives[0]==null)
//            $actives=0;
//        else
//            $actives=implode(' ',$makeActives);
////        echo $makeName;
////        die();
//
//        //QUERY AND ACTIVE RECORD TRIES==============================================================================
////        echo "<pre>";
////        print_r($rows);
////        $posts=Post::find()->count();
////////        print_r($makes);
//////
////        echo "new date is:   ".$newTime;
////////         $time=date('Y-M-d', $newTime);
////         var_dump($posts) ;
//
//
////         $makeNames=Post::find()->select(['make_id'])->where(['>=','created_at',$newTime]);
////         print_r($makeNames);
////         foreach ($makeNames as $makeName)
////         {
////             var_dump( $makeName);
////         }
////        print_r(
////                (new \yii\db\Query())
////                ->select(['makes.name'])
////                ->from('posts')
////                ->join('INNER','makes','makes.id=posts.make_id')
////                ->all()
////                );
//
//        //        $rows = Post::find()
////            ->select(['makes.name'])
//////            ->from('posts as p')
////            ->leftJoin('makes', '`makes`.`id` = `posts`.`make_id`')
////            ->all();
////
////        $rows = Post::find()
//////            ->select(['name'])
////            ->joinWith('make', 'posts.make_id = makes.id')
//////            ->where('posts.make_id = makes.id')
////            ->all();
//
////        $rows = new \yii\db\Query();
////        $rows->select(['m.id'])->from('posts as p')
////                ->join('INNER JOIN', 'makes as m', 'p.make_id = m.id')->all();
////
//////        $command = $rows->createCommand();
////        return $rows;
//
////        $model = new Post();
////        $model = new Make();
////        $rows = Post::find()
////            ->select(['makes.name'])
//////            ->from('posts as p')
////            ->leftJoin('makes', '`makes`.`id` = `posts`.`make_id`')
////            ->all();
//
////        $rows = Make::find()->all();
////print_r($rows);
////die;
////END OF QUERYS AND ACTIVE RECORD TRIES============================================================================


    }


    public function actionDeactivate()
    {
        $time= strtotime(Yii::$app->formatter->asDate('now', 'y-M-d HH:MM:SS'));

        $newTime=$time-5* 60 * 60 * 24;
        $newTime=date("Y-m-d  H:i:s", $newTime);

        $posts=Post::find()->where(['<','created_at',$newTime])->all();

        $old_ids=array();
        foreach ($posts as $post)
            {
                if($post->status ==1)
                    $post->status=0;
                $old_ids[]=$post->id;
                $post->save();
            }
        $ids=implode(' ',$old_ids);
        $message="The post id's for the new deactivated posts are: ".$ids;

        Yii::$app->mailer->compose()
            ->setFrom('bla@bla.com')
//            setTo('r.allfageer@syarah.com')
            ->setTo('o.hamdan@syarah.com')
            ->setSubject('monthly state email')
            ->setTextBody($message)
            ->setHtmlBody('<b>HTML content</b>')
            ->send();

    }
    public function actionStatus()
    {
        $posts=Post::find()->all();
        foreach($posts as $post)
        {
            $post->status=1;
            $post->save();
        }
    }


}