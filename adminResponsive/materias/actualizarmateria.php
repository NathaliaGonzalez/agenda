<?php
	session_start();

	$correo=$_SESSION["Correo"];

	include_once("../../conexion.php");

	$sql="select * from administrador where correo='$correo'";
        mysqli_set_charset( $con, 'utf8');
	$res=mysqli_query($con,$sql);

	$reg=mysqli_fetch_array($res);

	$id=$_GET['idmaterias'];
	$m="select * from materias where idmaterias='$id'";
	$modificar=$con->query($m);
	$dato = $modificar->fetch_array();
	//echo "<script>console.log('".$reg["cin"]."')</script>";
	if(isset($_SESSION["Correo"])&& isset($_SESSION["Nombre"])&& isset($_SESSION["Apellido"])
    ){
        $nombres = explode(" ", $_SESSION["Nombre"]);
        $apellidos = explode(" ", $_SESSION["Apellido"]);

?>


<!DOCTYPE html>
<html lang="es">
<head>
	<title>Mis Datos</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../css/main.css">
</head>
<body>
	<!-- SideBar -->
	<section class="full-box cover dashboard-sideBar">
		<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
		<div class="full-box dashboard-sideBar-ct">
			<!--SideBar Title -->
			<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
				AGENDA FCYT <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
			</div>
			<!-- SideBar User info -->
			<div class="full-box dashboard-sideBar-UserInfo">
				<figure class="full-box">
					<img src="../assets/avatars/AdminMaleAvatar.png" alt="UserIcon">
					<figcaption class="text-center text-titles">
						<?php echo $reg["nombre"]. " ".$reg["apellido"]; ?>
					</figcaption>
				</figure>
				<ul class="full-box list-unstyled text-center">
					<li>
						<a href="../my-data.php" title="Mis datos">
							<i class="zmdi zmdi-account-circle"></i>
						</a>
					</li>
					<li>
						<a href="../my-account.php" title="Mi cuenta">
							<i class="zmdi zmdi-settings"></i>
						</a>
					</li>
					<li>
						<a href="../../cerrarsesion.php" onclick="return confirm('Estás seguro que deseas quiere cerrar sesion?')" title="Salir del sistema">
							<i class="zmdi zmdi-power"></i>
						</a>
					</li>
				</ul>
			</div>
			<!-- SideBar Menu -->
			<ul class="list-unstyled full-box dashboard-sideBar-Menu">
				<li>
					<a href="../home.php">
						<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Inicio
					</a>
				</li>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-case zmdi-hc-fw"></i> Administración <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="../horarios/horariofinal.php"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Horarios de Examenes Finales</a>
						</li>
						<li>
							<a href="../horarios/horario-list.php"><i class="zmdi zmdi-watch zmdi-hc-fw"></i> Horario de Clases</a>
						</li>
						<li>
							<a href="materiahome.php"><i class="zmdi zmdi-assignment-o zmdi-hc-fw"></i> Materias</a>
						</li>
						<li>
							<a href="../profesores/profesores.php"><i class="zmdi zmdi-male-female zmdi-hc-fw"></i> Profesores</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Usuarios <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<?php
							if ($_SESSION["rol"]=="primario") {
								echo '<li>
								<a href="../admin.php"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Administradores</a>
								</li>';
								
							}
						?>
						<li>
							<a href="../alumno.php"><i class="zmdi zmdi-male-female zmdi-hc-fw"></i> Alumnos</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</section>
	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		<nav class="full-box dashboard-Navbar">
			<ul class="full-box list-unstyled text-right" style="background: linear-gradient(135deg, #71b7e6,#9b59b6);">
				<li class="pull-left">
					<a href="#!" class="btn-menu-dashboard"><i class="zmdi zmdi-more-vert"></i></a>
				</li>
			</ul>
		</nav>
		<!-- Content page -->
		<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-account-circle zmdi-hc-fw"></i> DATOS DE LA MATERIA</small></h1>
			</div>
		</div>

		<!-- Panel mis datos -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading" style="background: linear-gradient(135deg, #71b7e6,#9b59b6);">
					<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; DATOS DE LA MATERIA</h3>
				</div>
				<div class="panel-body">
					<form action="updatemateria.php" method="POST" >
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información</legend>
				    		<div class="container-fluid">
				    			<div class="row">
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
											<label class="control-label">Nombre de la materia*</label>
											<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre" id="nombre" required="" maxlength="30"
											value="<?php echo $dato["nombre"]; ?>">
										</div>

										<div class="form-group label-floating">
											<span class=details>Profesor</span>
											<select name="profesor" id="profesor" required>
												<option value="" disabled selected>Profesor</option>
												<?php 
														//02-generar instruccion SQL
														$sql = "SELECT * from profesores";
														
														//03-ejecutar SQL (matriz de resultado)
														$res1 = mysqli_query($con,$sql);
														//04-procesa el resultado
														while($reg2=mysqli_fetch_array($res1)){
															if ($reg2["idprofesores"] == $dato["idprofesores"]) {
																echo "<option selected='' value='".$reg2["idprofesores"]."'>".$reg2["nombre"]." ".$reg2["apellido"]."</option>";
															}else {
																echo "<option value='".$reg2["idprofesores"]."'>".$reg2["nombre"]." ".$reg2["apellido"]."</option>";
															};
		
															
														};
													
												?> 
											</select>
										</div>

									</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										<span class=details>Carrera</span>
										<select name="carreras" id="carreras"  disabled>
											<option value="" disabled selected>Seleccione una carrera*</option>
											<?php
												require("../../conexion.php");
												//02-generar instruccion SQL
												$sql = "SELECT * from carreras";
												
												//03-ejecutar SQL (matriz de resultado)
												$res1 = mysqli_query($con,$sql);
											
                                                while($reg2=mysqli_fetch_array($res1)){
                                                    if ($reg2["idcarreras"] == $dato["idcarreras"]) {
                                                        echo "<option selected='' value='".$reg2["idcarreras"]."'>".$reg2["nombre"]."</option>";
                                                    }else {
                                                        echo "<option value='".$reg2["idcarreras"]."'>".$reg2["nombre"]."</option>";
                                                    };

                                                    
                                                };
                                            ?>
											<?php

                                    	?>
										</select>
										</div>

										<div class="form-group label-floating">
										<span class=details>Semestre</span>
										<select name="semestres" id="semestres"disabled>
											<option value="" disabled selected>Seleccione una carrera*</option>
											<?php 
													//02-generar instruccion SQL
													$sql = "SELECT * from semestre";
													
													//03-ejecutar SQL (matriz de resultado)
													$res1 = mysqli_query($con,$sql);
													//04-procesa el resultado
													while($reg2=mysqli_fetch_array($res1)){
														if ($reg2["idSemestre"] == $dato["idSemestre"]) {
															echo "<option selected='' value='".$reg2["idSemestre"]."'>".$reg2["semestre"]."</option>";
														}else {
															echo "<option value='".$reg2["idSemestre"]."'>".$reg2["semestre"]."</option>";
														};
	
														
													};
												
											?> 
										</select>
										</div>
									</div>
									
									<input type="hidden" name="idmaterias" value="<?php echo $id; ?>">
				    			</div>
				    		</div>
				    	</fieldset>
					    <p class="text-center" style="margin-top: 20px;">
					    	<button type="submit" class="btn btn-success btn-raised btn-sm" id="btn"><i class="zmdi zmdi-refresh"></i> Actualizar</button>
					    </p>
						<?php 
						if(isset($_GET["e"])){
							if($_GET["e"]=="1") {
								echo "<br>";
								echo "<div id='okay' class='alert alert-success ocultar' role='alert' style='display: block;'>
									Se ha actualizado correctamente!!
								</div>";
								
								echo "
								<script>
									setTimeout(function(){
										window.location.replace('materia-list.php');
									}, 3000);
								</script>
								";
							}else {
								echo "<div id='error' class='alert alert-danger ocultar' role='alert' style='display: block;'>
									Ya existe esta materia!!
								</div>";
							}
						}
				?>
				    </form>
				</div>
			</div>
		</div>
		
	</section>

	<!--====== Scripts -->
	<script src="./js/jquery-3.1.1.min.js"></script>
	<script src="./js/sweetalert2.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/material.min.js"></script>
	<script src="./js/ripples.min.js"></script>
	<script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="./js/main.js"></script>
	<script>
		$.material.init();
	</script>
	<script>
		nombre.addEventListener('input', sololetras);
		apellido.addEventListener('input', sololetras);
		function sololetras(e) {
			let value = e.target.value;
			e.target.value = value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, "");
		}
	</script>
</body>
</html>
<?php 
	}else{
		echo "La pagina esta protegida...";
        
        echo "
        <script>
            setTimeout(function(){
                window.location.replace('../loginResponsive/index.php');
            }, 3000);
        </script>
        ";
    
	}	
?>