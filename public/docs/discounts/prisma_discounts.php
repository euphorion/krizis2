<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Prisma discounts</title>
	</head>
	<body>
		<div class="wrapper">
		<h1>Prisma discounts</h1> 
		<h2>Doesn't load the whole list from a large discount container</h2>

		<pre>
		<?php require_once 'simple_html_dom.php'; 
		$html = new simple_html_dom();
		$url_str = "https://www.prismamarket.ee/products/offers/16930";
		
		$html->load_file($url_str);
				
		foreach($html->find(".js-shelf-item") as $product) {
			$item['type'] = 'price';
			$item['price'] = $product->find("span.whole-number",0)->plaintext;	
			$item['price'] += $product->find("span.decimal",0)->plaintext / 100.0;	
			$str = $product->find(".discount-price",0)->find("span",0)->plaintext;
			$str = substr($str, 0, strlen($str)-5);
			$str = str_replace(',','.',$str);
			$item['prev_price'] = $str;				

			$item['title']    = $product->find('.name', 0)->plaintext;
			$item['image'] = $product->find('img', 0)->src;
		    $products[] = $item;
			
		}
		
		print_r($products);
		?>
		</pre>
	</div>
	</body>
</html>

