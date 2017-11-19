<?php
header('Content-type:text/html; charset=utf-8');
require_once "phpQuery.php";

try
  {
    $pdo = new PDO('mysql:host=localhost;dbname=check', 'root', '');
    }
    catch (PDOException $e)
  {
  
  echo "No connection to DB is possible";
  
    }



function getFile($url){

  $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            $result = curl_exec($ch); 
            curl_close($ch); 
            return $result;

}
// aLL parsed data is stored in this array
$allData = [];
$i = 0;

function parser($url, $pages, &$allData, &$i, $start = 0){

if($start < $pages){

$file = getFile($url);
$doc = phpQuery::newDocument($file);

foreach ($doc->find('.articles-container .post-excerpt') as $article){
  
  $article = pq($article);
  
  //$article->find('.cat')->remove();
  $allData[$i]['category'] = trim($article->find('.cat')->text());
  $allData[$i]['title'] = trim($article->find('.pe-title')->text());
  //$article->find('.cat')->append('<p>Date: '.date('Y-m-d').'</p>');
  $allData[$i]['img'] = trim($article->find('.img-cont img')->attr('src'));
  $allData[$i]['description'] = trim($article->find('.post-desc p')->text());
  
  $i++;
}


 $next = $doc->find('.pages-nav .current')->next()->attr('href');
  if(!empty($next)){
    $start++;
    parser($next, $pages, $allData, $i, $start);
  }
    
}
  
}

$url = "http://www.kolesa.ru/news";

parser($url, 3, $allData, $i);

//print_r($allData);

foreach ($allData as $data){

$stmt = $pdo->prepare("INSERT INTO parse (category, title, img, description) VALUES (:category, :title, :img, :description )");
$stmt->execute($data);

}







/*
$dir = scandir('idea');

$array= array();

function test($dir, &$array){
	
	$dh = opendir($dir);
  while($file = readdir($dh)) {
    if($file != "." && $file != "..") {
      if(is_dir("$dir/$file")) {
    
        test("$dir/$file", $array);
      } elseif(strpos($file, '.txt')) {
        $array[] = $file;
      }
    }
  }
  closedir($dh);
	
}

//test('idea', $array);

//print_r($array);



$path = realpath('idea');

$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('idea'));
foreach($objects as $name => $object){
	
	if(strpos($name, '.txt')){
		$array[] =  basename($name);
	}
    
}
echo count($array);

echo '<hr>';

function throughTheDoor($which) {echo "(get through the $which door)"; } 
$func =new ReflectionFunction('throughTheDoor'); 
$func->invoke("left"); 
*/
?>
<div></div>
