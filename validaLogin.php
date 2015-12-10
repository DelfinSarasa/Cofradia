<html>
		<head><title>Area privada</title>
			<meta charset="UTF-8">
				<style type="text/css">
						table { 
						    display: table;
						    border-collapse: separate;
						    border-spacing: 20px;
						    border-color: white;
						    font-size:20px;
						    border-radius: 20px;
						    font-family: Helvetica, Arial, Sans-Serif;

						}
						a{
							color:white	;	
						}
						body{
							font-size:50px;
							color:white	;	
						}
						input[type="submit"],button, input[type="button"]{
						   border-top: 1px solid #ffffff;
						   background: #ffffff;
						   background: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#ffffff));
						   background: -webkit-linear-gradient(top, #ffffff, #ffffff);
						   background: -moz-linear-gradient(top, #ffffff, #ffffff);
						   background: -ms-linear-gradient(top, #ffffff, #ffffff);
						   background: -o-linear-gradient(top, #ffffff, #ffffff);
						   padding: 9.5px 19px;
						   -webkit-border-radius: 19px;
						   -moz-border-radius: 19px;
						   border-radius: 19px;
						   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
						   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
						   box-shadow: rgba(0,0,0,1) 0 1px 0;
						   text-shadow: rgba(0,0,0,.4) 0 1px 0;
						   color: #000000;
						   font-size: 18px;
						   font-family: Helvetica, Arial, Sans-Serif;
						   text-decoration: none;
						   vertical-align: middle;
						   }
						input[type="submit"]:hover,button:hover,input[type="button"]:hover {
						   border-top-color: #2d1839;
						   background: #2d1839;
						   color: #ccc;
						   }
						button:active {
						   border-top-color: #403485;
						   background: #403485;
						   }
				</style>
		</head>

		<body class="blurBg-true" style="background-color:#2d1839">
					<link rel="stylesheet" href="areaprivada_files/formoid1/formoid-solid-green.css" type="text/css" />
					<div align="center">
					<img style="margin:0px auto;display:block" src="background2.png"/>

					<table align=center border=1>
					<?php
						include('conexion.php');
						$usuario=mysql_real_escape_string($_POST['user']);
						$pass=mysql_real_escape_string($_POST['pass']);


						$sql="select cofrade.ID_COFRADE as id_cofrade, id_barcode, nombre,apellidos,ano_nacimiento,Tipo_instrumento,hueco_cuarto from cofrade where '$usuario'=user and '$pass'=pass";
						$resultado=mysql_query($sql);
						$totalfilas=mysql_num_rows($resultado);

						if($resultado){

							while($fila=mysql_fetch_array($resultado)){
										$ensayos=mysql_query("select count(id_barcode) as total from ensayo where id_barcode='$fila[id_barcode]'");
										$ensayo=mysql_fetch_array($ensayos);
										echo "<tr><td style='border:0'>$fila[nombre] $fila[apellidos]</td></tr>";
										echo "</table><table align=center border=1 >";
										
										//echo "<tr><td style='border:0'>Año de nacimiento:$fila[ano_nacimiento]</td>";
										echo "<tr><td style='border:0'>Instrumento: $fila[Tipo_instrumento]</td>";
										
										if(empty($fila['hueco_cuarto'])){
												
												echo "<td style='border:0'>Hueco en el cuarto: No hay</td>";

										}
										else{
											
												echo "<td style='border:0'>Hueco en el cuarto: $fila[hueco_cuarto]</td>";

										}

										echo "<td style='border:0'>Total Ensayos: $ensayo[total]</td></tr>";
										$tabla=0;
										echo "<table border=0 align=center>";
											echo "<tr><td>ENSAYOS</td></tr>";
											echo "</table>";
										echo "<table border=1 align=center>";
										echo "<tr>";
										$year=date('y');
										$ensayos=mysql_query("select Fecha from maestro_fechas where Ano='$year'");
										
										while($ensayo=mysql_fetch_array($ensayos)){

											$sql=mysql_query("select ensayo, ensayo.ano as ano from ensayo where id_barcode='$fila[id_barcode]' and ensayo='$ensayo[Fecha]'");

											if($tabla%5!=0){ //Controlamos que salga 5 ensayos por fila.
												if(mysql_num_rows($sql)==0){
														$sql2=mysql_query("SELECT date_format(Fecha,'%d/%m/%Y') as fechas FROM maestro_fechas where Fecha='$ensayo[Fecha]'");
														$sql3=mysql_fetch_array($sql2);
														echo "<td><input type='TEXT' value='$sql3[fechas]' style='background-color:#B74242; font-weight:bold; font-size:16px; text-align:center;' readonly></td>"; //CONTROLAR SI CLICA POR JAVASCRIPT QUE ACTUALICE
													}
												if(mysql_num_rows($sql)>0){
														$sql2=mysql_query("SELECT date_format(Fecha,'%d/%m/%Y') as fechas FROM maestro_fechas where Fecha='$ensayo[Fecha]'");
														$sql3=mysql_fetch_array($sql2);
														echo "<td><input type='TEXT' value='$sql3[fechas]' style='background-color:#35FF00; font-weight:bold; font-size:16px; text-align:center;' readonly></td>";

													}
											}
											else{
													echo "</tr><tr>";
													if(mysql_num_rows($sql)==0){
															
															$sql2=mysql_query("SELECT date_format(Fecha,'%d/%m/%Y') as fechas FROM maestro_fechas where Fecha='$ensayo[Fecha]'");
															$sql3=mysql_fetch_array($sql2);
															echo "<td><input type='TEXT' value='$sql3[fechas]' style='background-color:#B74242; font-weight:bold; font-size:16px; text-align:center;' readonly></td>"; //CONTROLAR SI CLICA POR JAVASCRIPT QUE ACTUALICE

														}
													if(mysql_num_rows($sql)>0){

														$sql2=mysql_query("SELECT date_format(Fecha,'%d/%m/%Y') as fechas FROM maestro_fechas where Fecha='$ensayo[Fecha]'");
														$sql3=mysql_fetch_array($sql2);
														echo "<td><input type='TEXT' value='$sql3[fechas]' style='background-color:#35FF00; font-weight:bold; font-size:16px; text-align:center;' readonly></td>";

													}
											}
											$tabla++;
										}
								
							
							echo "</table><table>";
						}
					}
					

					if($totalfilas==0){ //Si la consulta que muestra los datos tiene 0 resultados

						echo "<script>alert('Usuario/Contraseña incorrecta');window.location.replace('areaprivada.html');</script>";
						
					}
					
					else{ 

						echo "<tr><td><a href='areaprivada.html'><input type='button' value='VOLVER'></a></td>";
						echo"<td><a href='cambiarpass.php'><button>CAMBIAR CONTRASEÑA</button></a></td>";
						
					}

					?>
					</table>
		</body>
</html>