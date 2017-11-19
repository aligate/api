

<!DOCTYPE html>
<html>
    <head>
       <meta charset="utf-8">
       <title>Абзацы</title>
    </head>
    <body>
    
    <ul></ul>

    
    <button id="load">Show users</button>
    
    <script src="jquery-3.2.1.min.js"></script>
        <script>
        
        $('#load').on('click', loadUsers);
        
        function getUrl(method,params){
        	params = params || {};
        	params['access_token'] = '546d2bca498113dfadc2ed696b00b4779661a2e54e5812de6ccd2df886da65743940382c64686b6974b35';
        	return 'https://api.vk.com/method/'+method+'?'+$.param(params);
			
		}
		
		function sendRequest(method, params, func){
			$.ajax({
				url: getUrl(method, params),
        		method: 'get',
        		dataType: 'JSONP',
        		success: func
			
			});
		}
       function loadUsers(){
	   		sendRequest('users.search', {fields:'photo_100', count:20}, function(data){
	   			console.log(data);
	   		});
	   }
        	
        </script>
    </body>
</html>












<?php
/*
$fields = ['connections', 'site', 'education', 'contacts', 'status','photo_max', 'city'];

$params = [

	'group_id' => 'apiclub',
	'sort'=>'id_asc',
	'offset'=>0,
	'display'=> 'page',
	'count'=>30,
	'fields' =>implode(',', $fields),
	'access_token' =>'a5b0725beb3dd65b912c87e1825fef433021af67ad3c2d83da7a852d0bdca2581e196db9bba0400d407ce'
	
];

$request = 'https://api.vk.com/method/groups.getMembers?'.http_build_query($params);
$response = json_decode(file_get_contents($request),true );
print_r($response['response']['users']);

*/
?>