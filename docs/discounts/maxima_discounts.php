<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Maxima discounts</title>
	</head>
	<body>
		<div class="wrapper">
		<h1>Maxima discounts</h1> 
		<pre>
		<?php require_once 'simple_html_dom.php'; 
		$html = new simple_html_dom();
		$html->load_file("http://www.maxima.ee/pakkumised");
		
					
		foreach($html->find("div.col-third") as $product) {
			
			$price = $product->find("span.cents", 0);
			if ( $price != null) {
				$item['type'] = 'price';
				$t1 = $product->find("div.t1",0);
				$item['price'] = $t1->find("span.value",0)->plaintext;	
				$item['price'] += $t1->find("span.cents",0)->plaintext / 100.0;	
				$t2 = $product->find("div.t2",0);
				if ($t2 != null)
					$item['prev_price'] = $t2->find("span.value",0)->plaintext;	
			}
			else {
				$item['type'] = 'percents';
				$item['value'] = $product->find("span.value",0)->plaintext;	
			}

			$item['title']    = $product->find('div.title', 0)->plaintext;
			$item['image'] = $product->find('img', 0)->src;
		    $products[] = $item;
			
		}
		
		
		print_r($products);
		?>
		</pre>
	</div>
	</body>
</html>

