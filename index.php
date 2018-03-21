<?php
/*
	array of relative (to php file) directories to compare
	jpgs each directory should match
	first value is the directory name
	second value is the label to display when viewing this set

	use your arrow keys or number pad to navigate the image sets
*/
$dirList = array(
	array('uncompressed','Uncompressed'),
	array('kraken','kraken lossy compression'),
	array('imageoptim','Imageoptim lossy (99% quality)'),
);




/*
	no need to configure further
*/
$finalText = array();
if(!empty($dirList) && !empty($dirList[0])){
	$dir    = './'.$dirList[0][0];
	$files1 = scandir($dir);
	$dirCount = count($dirList);

	if(!empty($files1)){
		$outputMarkup = '';
		foreach($files1 as $file){
			if (strpos($file, '.jpg') !== false) {
				foreach($dirList as $key => $dirSingle){
					if(isset($dirList[$key]) && !empty($dirSingle)){
						if(isset($finalText[$key])){
							$finalText[$key] .= '<img src="'.$dirList[$key][0].'/' . $file . '" border="0" /><br />';
						} else {
							$finalText[$key] = '<img src="'.$dirList[$key][0].'/' . $file . '" border="0" /><br />';
						}
					}
				}
			}
		}
?>
		<style>
			html,body { padding:0; margin:0; }
			.group { position:absolute;top:0;left:0;width:100%; }
			.group:BEFORE {
				content:"";
				position:fixed;
				top:0;
				left:50%;
				transform:translateX(-50%);
				background:black;
				color:white;
				font-family:Arial;
				font-size:14px;
				text-transform: uppercase;
				padding:5px 10px;
			}
			<?php
				foreach($dirList as $key => $dirSingle){
					$tempNum = $key+1;
					if($tempNum === 0){
						echo '.group:BEFORE { content:"'.$dirList[$key][1].'"; }';
					} else {
						echo '.group-'.$tempNum.' { display:none; }
						.group-'.$tempNum.':BEFORE { content:"'.$dirList[$key][1].'"; }
						body[data-group="'.$tempNum.'"] .group-'.$tempNum.' { display:block; }';
					}
					if(isset($finalText[$key])){
						$outputMarkup .= '<div class="group group-'.$tempNum.'">'. $finalText[$key] . '</div>';
					}
				}
			?>
		</style>
		<html>
		<body>
		<?php echo $outputMarkup; ?>

		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script>
			var currentlyViewing = 1;
			var totalSets = <?php echo $dirCount; ?>;
			$("body").on("click",function(){
				currentlyViewing++;
				if(currentlyViewing > totalSets){
					currentlyViewing = 1;
				}
				$("body").attr("data-group",currentlyViewing);
			});
			$("body").attr("data-group",currentlyViewing);

			$("body").keydown(function(e) {
				if(e.keyCode == 37) { // left
					e.preventDefault();
					currentlyViewing--;
					if(currentlyViewing < 1){
						currentlyViewing = totalSets;
					}
					$("body").attr("data-group",currentlyViewing);
				} else if(e.keyCode == 39) { // right
					e.preventDefault();
					currentlyViewing++;
					if(currentlyViewing > totalSets){
						currentlyViewing = 1;
					}
					$("body").attr("data-group",currentlyViewing);
				} else if(e.keyCode == 49) {
					currentlyViewing = 1;
					$("body").attr("data-group",currentlyViewing);
				} else if(e.keyCode == 50) {
					currentlyViewing = 2;
					$("body").attr("data-group",currentlyViewing);
				} else if(e.keyCode == 51) {
					currentlyViewing = 3;
					$("body").attr("data-group",currentlyViewing);
				} else if(e.keyCode == 52) {
					currentlyViewing = 4;
					$("body").attr("data-group",currentlyViewing);
				} else if(e.keyCode == 53) {
					currentlyViewing = 5;
					$("body").attr("data-group",currentlyViewing);
				} else {
					// console.log(e.keyCode);
				}
			});
		</script>
<?php 
	}
}
?>
</body>
</html>
