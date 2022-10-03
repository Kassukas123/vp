<?php
	require_once "../../config.php";
	echo $server_host;
	$author_name = "Kevin-Kaspar Einsok";
	$full_time_now =  date("d.m.Y H:i:s");
	$weekday_now = date("N");
	//echo $weekday_now;
	$weekdaynames_et = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	//echo $weekdaynames_et [$weekday_now - 1];
	$hours_now = date("H");
	//echo $hours_now
	$part_of_day = "suvaline päeva osa";
 	// <       >   =<    >=    =    ==    !=     
	 if ($weekday_now >= 1 and $weekday_now <= 5) { 
		// esmaspaev kuni reede
		if($hours_now < 7){
			$part_of_day = "tuduaeg";
		}
		//   and   or
		else if($hours_now >= 8 and $hours_now < 18){
			$part_of_day = "koolipäev";
		}
		else {
			$part_of_day = "mine tuttu";
		}
	}
	else if ($weekday_now == 6){
		// laupaev
		$part_of_day = "pohmellipäev";
	}
	else {
		// puhapaev
		$part_of_day = "täielik tiks";
	}

		//echo toob commenti lehe ülaserva

	$vanasonad = [
		"Amet ei riku meest, kui mees ametit ei riku.",
		"Kuri keel on teravam kui nuga.",
		"Sõbrale laenad, vaenlaselt nõuad.",
		"Mis täna tehtud, see homme hooleta.",
		"Ära kiida iseennast, vaid lase teistel kiita.",
		"Kes naeru kardab, see peeru kooleb.",
		"Inimene õpib eluea, aga targemaks ei saa ilmaski."
	];
	$vanasona_loos = mt_rand(0, count($vanasonad)-1);
	
	//uurime semestri kestmist
	$semester_begin = new DateTime ("2022-9-5");
	$semester_end = new DateTime ("2022-12-18");
	$semester_duration = $semester_begin->diff($semester_end);
	//echo $semester_duration;
	$semester_duration_days = $semester_duration->format("%r%a");
	$from_semester_begin = $semester_begin->diff(new DateTime("now"));
	$from_semester_begin_days = $from_semester_begin->format("%r%a");
	
	//juhuslik arv
	//küsin massiivi pikkust
	//echo count($weekdaynames_et);
	//echo mt_rand(0, count($weekdaynames_et) -1);
	//echo $weekdaynames_et[mt_rand(0, count($weekdaynames_et) -1)];

	//juhuslik foto
	$photo_dir = "photos";
	//loen kataloogi sisu
	//$all_files = scandir($photo_dir);
	//var_dump($all_files);
	$all_files = array_slice(scandir($photo_dir), 2);
	//kontrollin, kas ikka tegu fotoga
	$allowed_photo_types = ["image/jpeg", "image/png"];
	//tsükkel
	//muutuja väärtuse suurendamine  $muutuja = $muutuja + 5
	// $muutuja += 5
	//kui on vaja liita 1
	// $muutuja ++
	//samamoodi $muutuja -= 5    $muutuja --
	/*for($i = 0;$i < count($all_files); $i ++){
		echo $all_files[$i];
	}
	*/
	$photo_files = [];
	foreach($all_files as $file_name){
		//echo $filename;
		$file_info = getimagesize($photo_dir ."/" .$file_name);
		//var_dump($file_info);
		//kas on lubatud tüüpide nimekirjas
		if(isset($file_info["mime"])){
			if(in_array($file_info["mime"], $allowed_photo_types)){
				array_push($photo_files, $file_name);
			}//if in_array
		}//if isset
	}//foreach

	//var_dump($all_real_files);
	// <img src="kataloog/fail" alt="tekst">
	$photo_html = '<img src="' .$photo_dir ."/" .$photo_files[mt_rand(0, count($photo_files)-1)] .'"';
	$photo_html .= ' alt="Tallinna pilt">';
	
	//vaatame, mida vormis sisestati
	//var_dump($_POST);
	//echo $_POST["todays_adjective_input"];
	$todays_adjective = "pole midagi sisestatud";
	if(isset($_POST["todays_adjective_input"]) and !empty($_POST["todays_adjective_input"])){
		$todays_adjective = $_POST["todays_adjective_input"]; 
	}
	
	//loome rippmenüü valikud
	//<option value="0">tln_6.JPG</option>
	//<option value="1">tln_33.JPG</option>
	$select_html = '<option value="" selected disabled>Vali pilt</option>';
	for($i = 0;$i < count($photo_files); $i ++){
			$select_html .= '<option value="' .$i .'">';
			$select_html .= $photo_files[$i];
			$select_html .= "</option>";
	}

	if(isset($_POST["photo_select"]) and !empty($_POST["photo_select"] >= 0)) {
		//echo "Valiti pilt nr: " .$_POST["photo_select"];
	}

	$comment_error = null;
	$grade = 7;
	//kas klikiti päeva kommentaari nuppu
	if(isset($_POST["comment_submit"])){
		if(isset($_POST["comment_input"]) and !empty($_POST["comment_input"])){
			$comment = $_POST["comment_input"];
		} else {
			$comment_error = "Kommentaar jäi kirjutamata";
		}
		$grade = $_POST["grade_input"];

		if(empty($comment_error)){
		
			//loon andmebaasiga ühenduse
			//server, kasutaja, parool, andmebaas
			$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
			//määran suhtlemisel kasutatava kooditabeli
			$conn->set_charset("utf8");
			//valmistame ette andmete saatmise SQL käsu
			//prepare käsk tähistab modernse koodi aegunud koodist!!!!!!
			$stmt = $conn->prepare("INSERT INTO vp_daycomment (comment, grade) values(?,?)");
			echo $conn->error;
			//seome SQL käsu õigete andmetega
			//andmetüübid i - integer d - decimal s - string
			$stmt->bind_param("si", $comment, $grade);
			if($stmt->execute()){
				$grade = 7;
				$comment = null;
			}
			//sulgeme käsu
			$stmt->close();
			//andmebaasiühendus kinni
			$conn->close();
		}
	}

?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name;?> programmeerib veebi</title>
</head>
<body>
	<img src="pics/vp_banner_gs.png" alt="Veebiprogrammeerimine">
	<h1>Kevin-Kaspar Einsok programmeerib veebi</h1>
	<p>See leht on loodud õppetöö raames ja ei sisalda tõsiselt võetavat sisu! Päriselt ka! </p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee" target="_blank">Tallinna Ülikoolis</a></p> 
	<p>Lehe avamise hetk: <?php echo $weekdaynames_et [$weekday_now - 1] . ", ". $full_time_now; ?></p>
	<p>Praegu on <?php echo $part_of_day;?></p>
	<p>Semestri pikkus on <?php echo $semester_duration_days;?> päeva. See on kestnud juba <?php echo $from_semester_begin_days; ?> päeva.</p>
	<p>Vanasõna loos: <?php echo $vanasonad[$vanasona_loos];?></p>
<img src="pics/tlu_29.jpg" alt="Astra hoone"></a>
<hr>
<form method="POST">
	<label for="comment_input">Kommentaar tänase päeva kohta (140 tähte)</label>
	<br>
	<textarea id="comment_input" name="comment_input" cols="35" rows="4" 
	placeholder="kommentaar"></textarea>
	<br>
	<label for="grade_input">Hinne tänasele päevale (0 - 10)</label>
	<input type="number" id="grade_input" name="grade_input" min="0" max="10" step="1" value="<?php echo $grade; ?>">
	<input type="submit" id="comment_submit" name="comment_submit" value="Salvesta">
	<span><?php echo $comment_error; ?></span>
</form>
<hr>
<form method="POST">
	<input type="text" id="todays_adjective_input" name="todays_adjective_input" 
	placeholder="Kirjuta siia omadussõna tänase päeva kohta">
	<input type="submit" id="todays_adjective_submit" name="todays_adjective_submit" value="Saada omadussõna!">
</form>
<p>Omadussõna tänase kohta: <?php echo $todays_adjective; ?></p>
<hr>
<form method="POST">
	<select id="photo_select" name="photo_select">
		<?php echo $select_html; ?>
	</select>
	<input type="submit" id="photo_submit" name="photo_submit" value="Määra foto">
</form>
<?php echo $photo_html; ?>
<hr>
</body>
</html>