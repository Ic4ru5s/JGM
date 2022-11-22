<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JGM serious eXperiences</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&amp;display=swap" rel="stylesheet">
    <meta name="description" content="JGM serious eXperiences">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js"></script>
</head>
<body>
    <div id="main">
        <div class="headerblock">
		    <a href="index.php">Sessies</a> |  
            <a href="overviews.php">Overzichten</a> | 
            <a href="company.php">Mijn gegevens</a> | 
            <a href="sources.php">Hoe werkt het?</a>
        </div>
    </div>
    <div>
		<div class="inner"><h1>Rapporten</h1><button class="btn line_button_black float_right " style="margin-top:15px;" onclick="window.location.href='new_report.php'">+ Rapport</button><h2>Alle rapporten</h2><p></p><form action="" method="GET">
		<div style="white-space:nowrap;padding-bottom:15px;display:inline-block;"><input type="radio" name="check" value="1" checked="" id="12" onchange="this.form.submit()"> <label for="12"> Alle </label>
		<div style="white-space:nowrap;padding-bottom:15px;display:inline-block;"><input type="radio" name="check" value="2" id="13"> <label for="13">Datum <input type="date" name="date" value="2022-11-21" onclick="checkRadio13()">  </label></div><br class="mobile">
		<div style="white-space:nowrap;padding-bottom:0px;display:inline-block;"><input type="radio" name="check" value="3" id="r14"> <label for="r14"><input type="text" onclick="checkRadio14()" placeholder="Zoek op bedrijfs- of teamnaam" name="search"></label> 
		<button class="btn button_black small_btn" onclick="this.form.submit()">Zoeken</button></div>
				
		<p></p><script>
			function checkRadio14(){  
				document.getElementById('r14').checked = "true";
			}
			function checkRadio13(){  
				document.getElementById('13').checked = "true";
			}
			function checkRadio12(){  
				document.getElementById('12').checked = "true";
			}
		 </script>
            <p>1 rapport gevonden.</p>
            <p><small><a href="index.php?&amp;check=1&amp;order=1">Oudste eerst</a></small></p>
            <table class="stylish" width="100%">
				<tbody><tr>
					<th>Datum</th>
					<th>Teamnaam</th>
					<th class="desktop">Bedrijfsnaam hi</th>
					<th class="desktop">Vaardigheden</th>
					<th>Status</th>
					<th></th>
				</tr><tr>
					<td> 15 november  2022</td>
					<td><a href="report.php?report_id=54&amp;edit"></a></td>
					<td class="desktop"><a href="report.php?report_id=54&amp;edit"></a></td>
					<td class="desktop">Leiderschap</td>
					<td class="desktop">Afgerond</td>
					<td>
						<a class="button_link btn button_black  small_btn" onclick="window.location.href='report.php?report_id=54&amp;edit'">Gegevens</a>
						<a class="button_link btn button_black  small_btn desktop" onclick="window.location.href='report.php?report_id=54'">Resultaten</a>
					</td>
				 </tr></tbody>
            </table>
            <p><a href="index.php?&amp;page=1.&amp;check=1">Start.</a>  Pagina 1 van 1    <a href="index.php?&amp;page=1&amp;check=1">Einde</a></p><br></div></form>			
			</div>
		</div>
</body>
</html>