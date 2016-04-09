<html>
<head>
<!-- start meta -->
<meta content="text/html" charset="UTF-8" http-equiv="Content-Type"/>
<link rel="author" href="https://plus.google.com/+TranKing" />
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"/>
<link rel="canonical" href="http://myweb.pro.vn/book/all/" />
<link  rel="stylesheet" type="text/css" href="/css/ebook.css"/>
</head>

<body>
<table id="ebook_wrapper_table">					  			
<?php $condition = empty($book) || !is_array($book) ? 0 : count($book); ?>
<?php if ($condition) {
$loop = -1;
foreach ($book as $key) {                    
$loop++; ?>
<?php if ($loop && $loop % 10 == 0) { ?>
<tr>
<?php } ?>
<td style="cursor: pointer"  align="center" valign="top" width="<?php echo 100 / 10 ?>%">
<?php if ($key["thumb"]) { ?>
<img alt="<?= $key['name'] ?>" class="ebook_thumbs" src="<?=$key['thumb'] ?>" >
<div class="ebook_div_item" id="ebook_div_item_<?= $key['id'] ?>">                          
<a href="http://myweb.pro.vn/video/view?id=<?=$key['id']?>"><?= $key['name'] ?></a>
</div>
<?php } ?>
</td>
<?php }
} ?>
</tr>		
</table>      
</body>
<html>
