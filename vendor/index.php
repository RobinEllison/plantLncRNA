<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 8/24/17
 * Time: 2:08 PM
 */
require "./autoload.php";
$app = new \Slim\Slim(
   array('debug' => true)  
);
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});
$app->get('/', function () {
    echo "Hello";
});
/*$app->get('/express_matrix/:userID/:species',function ($userID,$species){
    $userID = trim($userID);
    $species = trim($species);
    $pattern = '/^[\d\w]+$/';
    if(preg_match($pattern,$userID) && preg_match($pattern,$species)){
        chdir("tmpfile");
        $filename= $userID.'_'.$species;
        system("Rscript drawheatmap.r $userID $species > /dev/null");
        $filename_files = $filename."_files";
        $filename_html = $filename.".html";
        system("sed -i 's/$filename_files/jslibrary/' $filename_html");
        system("mv $filename_html usertmpfile");
        echo "/vendor/tmfile/usertmpfile/$filename_html";
	//echo $filename;
    }else{
        echo "error";
        return;
    }
});*/
$app->get('/express_matrix/:species',function($species){
    global $app;
    $sql = 'select COLUMN_NAME as value from information_schema.COLUMNS where TABLE_SCHEMA="plant" and TABLE_NAME="sorghumIsoformsResult"';
    try{
        $db = getConnection();
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    }catch(PDOException $e){
        echo $e;
    }
});
$app->get('/ts_hk_detection/:specie',function ($species){
    global $app;
    $sql = "select COLUMN_NAME as sample from information_schema.columns where TABLE_SCHEMA='plant' and TABLE_NAME = 'sorghumIsoformsCount'";
    try{
        $db = getConnection();
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    }catch (PDOException $e){
        echo $e;
    }
});
$app->get('/express_matrix_basic_data/:specie',function ($specie){
    $sql = "select tissue,count(tissue) as tissueNumber from summary where latinName='$specie' group by tissue";
    try{
        $db = getConnection();
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    }catch (PDOException $e){
        echo $e;
    }
});
$app->get('/summary/:specie',function ($specie){
    $sql = "select * from summary where latinName='$specie'";
    try{
        $db = getConnection();
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    }catch (PDOException $e){
        echo $e;
    }
});
$app->post("/co_expression_detail_edge/:specie",function($specie){
    global $app;
    $data = json_decode($app->request()->getBody());
    $sql1 = "select * from sbiCoexpression where source='".$data->data->source."' and target='".$data->data->target."'";
    $sql2 = "select * from sorghumIsoformsResult where transID='".$data->data->source."' or transID='".$data->data->target."'";
    try{
        $db = getConnection();
        $stmt1 = $db->query($sql1);
        $data1 = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $stmt2 = $db->query($sql2);
        $data2 = $stmt2->fetchAll(PDO::FETCH_OBJ);
        // $result = array("co_expression_data"=>"test1","expression_data"=>"test2");
        echo json_encode(array("co_expression_data"=>$data1,"expression_data"=>$data2));
        // echo json_encode($result);
    }catch(PDOException $e){
        echo $e;
    }
});
$app->post('/co_expression_detail/:specie',function($specie){
    global $app;
    $data = json_decode($app->request()->getBody());
    preg_match_all("/\w+/", $data->textarea, $matches);
    $transcriptArray = $matches[0];
    
    if($data->optionType == "vague" && count($transcriptArray)==1){
        $tmpString = $transcriptArray[0];
        $sql = "select source,target from sbiCoexpression where source ='".$tmpString."' or target ='".$tmpString."'";
    }elseif($data->optionType == "vague"){
        $tmpString = "('".implode("','", $transcriptArray)."')";
        $sql = "select source,target from sbiCoexpression where source in ".$tmpString." or target in ".$tmpString;
    }else{
        $tmpString = "('".implode("','", $transcriptArray)."')";
        $sql = "select source,target from sbiCoexpression where source in ".$tmpString." and target in ".$tmpString;
    }
    try{
        $db = getConnection();
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    }catch (PDOException $e){
        echo $e;
    }
});
$app->post('/expressionHeatmap/:specie',function ($specie){
    global $app;
    $data = json_decode($app->request()->getBody());
    $heatmapColor = implode(',',$data->heatmapColor);
    // error_log("$heatmapColor");
    $sql = "select transID,".implode(',',$data->selectedPrivateSampleID)." from sorghumIsoformsResult where transID in ('".implode("','", $data->selectedTransID)."')";
    // error_log($sql);
    $content = "transID\t".implode("\t",$data->selectedPrivateSampleID) . "\n";
    $userID = userrand(10);
    try{
        $db = getConnection();
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_NUM);
        foreach ($data as $index=>$value){
            $value = array_map(function ($v){if(preg_match('/^\d/',$v)){return floatval($v);}else{return $v;}},$value);
            $mean = array_sum(array_slice($value,1))/count($value);
            $sd = stats_standard_deviation(array_slice($value,1),$sample=TRUE);
            if($sd == 0){
                foreach ($value as $i=>$v){
                    if(is_string($v)){
                        continue;
                    }else{
                        $value[$i] = -3;
                    }
                }
            }else{
                foreach ($value as $i=>$v){
                    if(is_string($v)){
                        continue;
                    }else{
                        $n = ($v-$mean)/$sd;
                        $n= ($n>3?3:$n);$n=($n<-3?-3:$n);
                        $value[$i] = $n;
                    }
                }
            }
            $data[$index] = $value;
        }
        foreach ($data as $value){
            $content.=implode("\t",$value)."\n";
        }
        error_log($content);
        file_put_contents('heatmap/tmpfile/'.$userID,$content);
//        echo json_encode($content);
    }catch (PDOException $e){
        echo $e;
    }
    chdir('heatmap');
    system("Rscript heatmap.r ".$userID." '$heatmapColor'");
    system("sed -i 's/${userID}_files/jslibrary/' ${userID}.html");
    system("rm -r ${userID}_files");
    system("rm tmpfile/${userID}");
    echo("/vendor/heatmap/${userID}.html");
});
$app->post('/expression_matrix/:specie',function ($specie){
    global $app;
    $data = json_decode($app->request()->getBody());
    $sql = "select transID,".implode(',',$data->selectedPrivateSampleID)." from sorghumIsoformsResult";
    try{
        $db = getConnection();
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    }catch (PDOException $e){
        echo $e;
    }

});
$app->post('/miRNA_lncRNA_interaction/:specie',function($specie){
    global $app;
    $data = json_decode($app->request()->getBody());
    if($data->miRNAID){
        $miRNAIDString = "('".implode("','",$data->miRNAID)."')";
    }else{
        $miRNAIDString = '';
    };
    if($data->lncRNAID){
        $lncRNAIDString = "('".implode("','",$data->lncRNAID)."')";
    }else{
        $lncRNAIDString = '';
    };
    if($miRNAIDString && $lncRNAIDString){
        $sql = "select * from sorghumMirnaTarget where miRna_Acc in ".$miRNAIDString." and target_Acc in ".$lncRNAIDString;
    }elseif ($miRNAIDString){
        $sql = "select * from sorghumMirnaTarget where miRna_Acc in ".$miRNAIDString;
    }elseif ($lncRNAIDString){
        $sql = "select * from sorghumMirnaTarget where target_Acc in ".$lncRNAIDString;
    }else{
        $sql = "select * from sorghumMirnaTarget";
    };
    error_log($sql);
    try{
        $db = getConnection();
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    }catch(PDOException $e){
        echo $e;
    };
});
$app->post('/ts_hk_detection/:specie',function ($specie){
    global $app;
    $sql = "select * from sorghumIsoformsResult";
    try{
        $db = getConnection();
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    }catch(PDOException $e){
        echo $e;
    };
});
/*$app->post('/express_matrix/:species',function ($species){
    global $app;
    $sql = "select sorghumIsoformsResult.*,sorghumTransLncRNABasicInfo.category from sorghumIsoformsResult inner join sorghumTransLncRNABasicInfo on sorghumIsoformsResult.transID = sorghumTransLncRNABasicInfo.transID";
    $data = json_decode($app->request()->getBody());
    if($data->selectedTypes){
        $sql = "$sql and sorghumTransLncRNABasicInfo.category in ('".implode("','",$data->selectedTypes)."')";
    }else{

    };
    try{
        $db = getConnection();
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    }catch(PDOException $e){
        echo $e;
    }
});*/
/*$app->post('/drawheatmap/:species',function ($species){
    global $app;
    $data = json_decode($app->request()->getBody());
    $userID = userrand(10);
    chdir("tmpfile");
    $tmpfile = fopen($userID."_".$species.".txt","w");
    if($data->selectedSamples){
        $samples = implode(",",array_map(function ($v){return "sorghumIsoformsResult.$v";},$data->selectedSamples));
        $sql = "select $samples from sorghumIsoformsResult";
    }else{
        $sql = "select sorghumIsoformsResult.* from sorghumIsoformsResult ";
    }
    if($data->selectedTypes){
        $sql = "$sql inner join sorghumTransLncRNABasicInfo on sorghumIsoformsResult.transID = sorghumTransLncRNABasicInfo.transID and sorghumTransLncRNABasicInfo.category in ('".implode("','",$data->selectedTypes)."')";
    }
    $db = getConnection();
    $stmt = $db->query($sql);
    $datebaseData = $stmt->fetchAll(PDO::FETCH_OBJ);
//    $datebaseData = $stmt->fetchAll();
    $header = array_keys(get_object_vars($datebaseData[0]));
//    error_log(implode(",",$header));
    $rowNumber = explode(",",$data->heatmapRowNumber);
    $rowArray = [];
    foreach ($rowNumber as $value){ //将用户输入的行数转化为数组
        if(strpos($value,":")!==false){
            $tmp = explode(":",$value);
            $rowArray = array_merge($rowArray,range(intval($tmp[0]),intval($tmp[1])));
        }else{
            $rowArray[] = intval($value);
        }
    }
    fwrite($tmpfile,(implode("\t",$header))."\n"); //加上header
    foreach ($rowArray as $v){
        $tmpArray = [];
        foreach ($header as $index => $value){
            $tmpArray[] = $datebaseData[$v] -> $value;
        }
        $kpmArray = array_map(function ($v){return floatval($v);},array_slice($tmpArray,1));
        global $mean;
        global $sd;
        $mean = array_sum($kpmArray)/count($kpmArray);
        $sd = sqrt(array_sum(array_map(function ($v){global $mean;return pow($v-$mean,2);},$kpmArray))/(count($kpmArray)-1));
        $processedArray = array_map(function ($v){global $mean;global $sd;$t = ($v-$mean)/$sd;$t= ($t>3?3:$t);$t=($t<-3?-3:$t);return $t;},$kpmArray);
        array_splice($tmpArray,1,count($tmpArray),$processedArray);
        fwrite($tmpfile,implode("\t",$tmpArray)."\n");
    }
    fclose($tmpfile);
    $heatmapColor = "'".implode("','",$data->heatmapColor)."'";
    error_log($heatmapColor);
    system("Rscript drawheatmap.r $userID $species $heatmapColor >/dev/null");

    $filename= $userID.'_'.$species;
    $filename_files = $filename."_files";
    $filename_html = $filename.".html";
    system("sed -i 's/$filename_files/jslibrary/' $filename_html");
    system("mv $filename_html usertmpfile");
    system("rm $filename.txt");
    echo "/vendor/tmpfile/usertmpfile/$filename_html";
});*/
function userrand($len){
    $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $string=time();
    for(;$len>=1;$len--)
    {
        $position=rand()%strlen($chars);
        $position2=rand()%strlen($string);
        $string=substr_replace($string,substr($chars,$position,1),$position2,0);
    }
    return $string;
};
function stats_standard_deviation(array $a, $sample = false) {
    $n = count($a);
    if ($n === 0) {
        trigger_error("The array has zero elements", E_USER_WARNING);
        return false;
    }
    if ($sample && $n === 1) {
        trigger_error("The array has only 1 element", E_USER_WARNING);
        return false;
    }
    $mean = array_sum($a) / $n;
    $carry = 0.0;
    foreach ($a as $val) {
        $d = ((double) $val) - $mean;
        $carry += $d * $d;
    };
    if ($sample) {
        --$n;
    }
    return sqrt($carry / $n);
};
function getConnection() {
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "123456";
    $dbname = "plant";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
};
$app->run();
