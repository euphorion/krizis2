<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Selver discounts</title>
	</head>
	<body>
		<div class="wrapper">
		<h1>Selver discounts</h1> 
		<pre>
		<?php require_once 'simple_html_dom.php'; 
		$html = new simple_html_dom();
		$url_base_str = "https://www.selver.ee/soodushinnaga-tooted";
		
		$i=1;
		//foreach subpage	
		do {
			$url_str = $url_base_str . "?p={$i}";
			$html->load_file($url_str);
				
			foreach($html->find(".col-xs-6") as $product) {
	            $price = $product->find(".special-price", 0);
				if ( $price != null) {
					$item['type'] = 'price';
					$t1 = $product->find("span",1);
					$str_price = $t1->plaintext;	
					/*remove trailing nbsp and euro sign
					*/
					$str_price = substr($str_price,0,strlen($str_price) - 6); 
					$str_price = str_replace(',','.',$str_price);
					$item['price'] = $str_price;
	
					
					$t2 = $product->find("span",4);
					$str_price = $t2->plaintext;	
					/*remove trailing nbsp and euro sign
					*/
					$str_price = substr($str_price,0,strlen($str_price) - 6); 
					$str_price = str_replace(',','.',$str_price);
					$item['prev_price'] = $str_price;				
				}
				else {
					$item['type'] = 'percents';
					//$item['value'] = $product->find("span.value",0)->plaintext;	
				}
	
				$item['title']    = $product->find('.product-name', 0)->find('a',0)->plaintext;
				$item['image'] = $product->find('img', 0)->src;
			    $products[] = $item;
				
				
			}
			
			$i++;
			
		} while ($html->find(".i-next") != null && $i!=4);
		
		
		print_r($products);
		?>
		</pre>
	</div>
	</body>
</html>

