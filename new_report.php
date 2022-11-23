<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New report</title>
</head>
<body>
<div class="inner">
	<h1>Nieuw rapport aanmaken</h1>
		<form action="" method="POST">
			<table>
				<tbody>
                    <tr>
                        <td>Teamnaam*:</td>
                        <td><input type="text" value="" name="team_name" required=""></td>
					</tr>
					<tr>
						<td>Bedrijfsnaam:</td>
						<td><input type="text" value="" name="company_name"></td>
					</tr>
					<tr>
						<td>Escaperoom:
						</td><td><select name="escaperoom_id"><option value="1" selected="">Het kantoor</option><option value="2">Planetarium</option><option value="3">Planetarium</option><option value="4">Directeurskamer</option><option value="5">Elze's Zodiac</option><option value="6">Directeur</option></select></td>
					</tr>
					<tr>
						<td>Industrie:</td>
                        <td><select name="industry_id"><option value="1">Banken</option><option value="2">Onderwijs</option><option value="3">ICT</option><option value="4">Overig</option><option value="6">Prive</option></select></td>
					</tr>
				</tbody>
            </table>
            
            <h3>Modules/ vaardigheden</h3>
            <table class="stylish">
				<tbody><tr>
					<th></th>
					<th>Vaardigheid</th>
					<th>Beschrijving</th>
					<th>Prijs</th>
				</tr><tr>
					<td><input type="checkbox" name="module_id[]" value="4"></td>
					<td>Communiceren</td>
					<td></td>
					<td>1 credits</td>
				 </tr><tr>
					<td><input type="checkbox" name="module_id[]" value="5"></td>
					<td>Leiderschap</td>
					<td></td>
					<td>1 credits</td>
				 </tr><tr>
					<td><input type="checkbox" name="module_id[]" value="3"></td>
					<td>Samenwerken</td>
					<td>Hoe werkt de groep samen.</td>
					<td>1 credits</td>
				 </tr>
                </tbody>
            </table>
            
            <h3>Theoretische assesments</h3>
            <table class="stylish">
				<tbody><tr>
					<th></th>
					<th>Assesment</th>
					<th>Beschrijving</th>
					<th>Prijs</th>
                    <th></th>
				</tr><tr>
					<td><input type="checkbox" name="questionaire_id[]" value="1"></td>
					<td>Test vragenlijst</td>
					<td>Pizza</td>
					<td>1 credits</td>
                    <td><button class="btn line_button_black float_right " onclick="window.location.href='setup_questionaire.php'">Change questions</button></td>
				 </tr>
                </tbody>
            </table>
            
            <input type="hidden" name="create">
				<button class="btn button_black" onclick="this.form.submit()">Aanmaken</button>
				<a class="button_link btn button_black " onclick="window.location.href='index.php?'">Annuleren</a>
        </form>
	</div>
</body>
</html>