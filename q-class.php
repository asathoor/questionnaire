<?php 
/*
* file: q-class.php
* idea: easy questionnaire class - for evaluations, surveys and similar.
*/

class questionnaire {

	public $form = "<form action='#'>";
	public $formEnd = "</form>";
	public $n = 1; // numbering the questions

	public function aQuestion($da){
		$question = "<h3 class=\"question\">" . $this->n . ") " . $da . "</h3>\n";
		echo $question;
		$this->n++; // add one to the question number
	}

	public function janej($navn){
		?>
			<div class="question">
				<li><input type="radio" name="<?php echo $navn; ?>" value="Ja" required> Ja</li>
				<li><input type="radio" name="<?php echo $navn; ?>" value="Nej" required> Nej</li>
			</div>
		<?php
	}

	public function fiveRadio($bar,$max,$min){

		echo "<p class='fiveRadio'><strong>" . $bar . "</strong><br> " . $max; // maximum value

		// loop out five radio buttons
		for ($i=5;$i>0;$i--){
			?>
				<input type="radio" name="<?php echo $bar; ?>" value="<?php echo $i; ?>" required>
			<?php
		}

		echo $min . "</p>";
	}

	public function setMark($mark){
		echo '<input type="checkbox" name="'.$mark.'" value="'.$mark.'"> ' . $mark . '<br>';
	}

	public function write($text){
		echo '	<p><label>'.$text.'</label> <input type="text" name="'.$text.'" value=""> ' . '</p>';
	}
 
	public function submit($submit){
		?>
			<div id="buttons">
			<input type="reset" name="Reset" value="Reset">
			<button name="GemSave" value="save" type="submit"><?php echo $submit; ?></button>
			</div>
		<?php
	}

} // ends questions

/* << USAGE SAMPLE >> */

$how = new questionnaire();

include_once "header.php"; // html and bootstrap initiated

echo $how->form;

$how->aQuestion("Arbejder du med WordPress?");

	$how->janej("frontend");

$how->aQuestion("I hvor høj grad arbejder du med disse fag:");

	$how->fiveRadio("Design","I høj grad","Slet ikke");
	$how->fiveRadio("Business","I høj grad","Slet ikke");
	$how->fiveRadio("Interaction","I høj grad","Slet ikke");
	$how->fiveRadio("Communication","I høj grad","Slet ikke");

$how->aQuestion("FOSS CMS?");

include_once "cmsList.php"; // the list of the most used FOSS CMSs

	foreach ($cmsList as $row){
		$how->setMark($row); // loop out the option list
	}

	$how->write("Andre");

$how->aQuestion("Tak for dine svar. Gem dine svar ved at klikke på Gem.");

$how->submit("Gem");

echo $how->formEnd;

include_once "footer.php";

$ip = $_SERVER['REMOTE_ADDR']; // user ip (may be random or arbitrary)

/* ... whatever the form GETs ... */

$svar = $_REQUEST;
array_pop($svar); // remove the submit button
echo '<div class="alert alert-info" role="alert"><h3>Resultat</h3>Answers from: ' 
	. $ip . '<br><pre>'
	. json_encode($svar) 
	. '</pre></div>';
?>
