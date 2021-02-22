<?php
	require_once 'valid.php';
?>	
<!DOCTYPE html>
<html lang = "eng">
	<?php require("head.php"); ?>
		<div class = "container-fluid">
			<?php require("menu.php"); ?>
			<div class = "col-lg-1"></div>
			<div class = "col-lg-9 well" style = "margin-top:110px;background-color:#fefefe;">
				<div class = "alert alert-jcr">Plan de estudios / Cursos</div>
					<button id = "add_admin" type = "button" class = "btn btn-primary"><span class = "glyphicon glyphicon-plus"></span> Agregar nuevo</button>
					<button id = "show_admin" type = "button" style = "display:none;" class = "btn btn-primary"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button>
					<br />
					<br />
					
					<div id = "admin_table">
					<label>Descargar</label>
						<table id = "table" class = "table table-bordered table-hover" style="width:100%">
							<thead class = "alert-info">
								<tr>
									<th width="10%">Código UP</th>
									<th width="25%">Curso</th>	
									<th width="15%">Departamento académico</th>
									<th width="15%">Tipo curso</th>
									<th width="5%">H. teóricas</th>		
									<th width="5%">H. prácticas</th>									
									<th width="5%">Créditos</th>	
                                    <th width="20%">Estado</th>	
							
								</tr>
							</thead>
							<tbody>
							<?php
                             if($_SESSION['rol_id']==1)
                                                        $rol="";
                                                        else
                                                        $rol=" and c.estado=1";
								$q_admin = $conn->query("SELECT c.idCurso,c.nombreCurso,c.codUpCurso,c.tipoCurso,d.descripcion as departamento,c.cantHorasPractica,c.cantHorasTeorica,c.credito,c.estado FROM curso c,departamento d where c.idDepartamento = d.idDepartamento".$rol) or die(mysqli_error($conn));
								while($f_admin = $q_admin->fetch_array()){
									
							?>	
								<tr class = "target">                                                               
									<td><?php echo $f_admin['codUpCurso']?></td>
									<td><?php echo $f_admin['nombreCurso']?></td>
									<td><?php echo $f_admin['departamento']?></td>
									<td><?php echo ($f_admin['tipoCurso']==1) ? "Académico" : "Para-académico"?></td>
									<td><?php echo $f_admin['cantHorasTeorica']?></td>
									<td><?php echo $f_admin['cantHorasPractica']?></td>
                                                                        <td><?php echo $f_admin['credito']?></td>
									<div style = "float:left;">
									<td><?php if ($f_admin['estado']==1){
									echo "Activo";
									$btnclas="btn-danger";
                                                                        $title="Desactivar registro";

									$estado=0;
									} 
									else {
									echo "Inactivo";
                                                                        $title="Activar registro";

									$btnclas="btn-success";
									$estado=1;
									}
									?>
</div>	
<div style = "float:right;">								
 <a href = "#" class = "btn btn-editar eadmin_id" value = "<?php echo $f_admin['idCurso']?>">
                                                                        <span class = "glyphicon glyphicon-edit" title="Editar registro"></span> </a>
									<a href = "#" class = "btn <?php echo $btnclas?> deladmin_id" value = "<?php echo $f_admin['idCurso'].'&estado='.$estado?>">
                                                                        <span class = "glyphicon glyphicon-off" title="<?php echo $title?>"></span> </a> 
</div>																		
									</td>									
								
									                          
								
																	
								</tr>
							<?php
								}
							?>	
							</tbody>
						</table>
					</div>
					<div id = "edit_form"></div>
					<div id = "admin_form" style = "display:none;">
						<div class = "col-lg-3"></div>
						<div class = "col-lg-6">
							<form id = "formcurso" method = "POST" action = "cursoGrabar.php" enctype = "multipart/form-data">
							<div class = "form-group">
							<div class = "form-group">
									<label>Código UP:</label>
									<input type = "text" required = "required" onKeyUp="this.value=this.value.toUpperCase();" name = "codUpCurso" class = "form-control" maxlength = "6" />
								</div>
									<label>Curso:</label>
									<textarea required = "required" placeholder = "Escriba con mayúsculas y minúsculas" rows="3" name = "nombreCurso" class = "form-control" maxlength = "150" ></textarea>
								</div>	
								
								<div class = "form-group">	
                        <label>Departamento académico:</label><br/>                
						<select name = "idDepartamento" id = "departamento" required = "required">
							<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
							<?php
								$qborrow = $conn->query("SELECT idDepartamento,descripcion FROM departamento where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
							?>
								<option value = "<?php echo $fborrow['idDepartamento']?>"><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>
								</div>
								
								<div class = "form-group">
									<label>Tipo de curso:</label><br/>
									<select name = "tipoCurso" id = "tipoCurso" required = "required">                                      
							<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
							<option value = "1" >Académico</option>
							<option value = "2" >Para-académico</option>
						</select>			
								</div>
								<div class = "form-group">
									<label>Cantidad de horas teóricas:</label>
									<input type = "number" step="any" min="1" max="99" required = "required" name = "cantHorasTeorica" class = "form-control" onKeyPress="if(this.value.length==2) return false;"/>
								</div>
								<div class = "form-group">
									<label>Cantidad de horas prácticas:</label>
									<input type = "number" step="any" min="1" max="99" required = "required" name = "cantHorasPractica" class = "form-control" onKeyPress="if(this.value.length==2) return false;" />
								</div>
								<div class = "form-group">
									<label>Créditos:</label>
									<input type = "number" step="any" min="0" max="9.99" required = "required" name = "credito" class = "form-control" onKeyPress="if(this.value.length==4) return false;"/>
								</div>
								
							
								<div class = "form-group">
									<label>Estado:</label><br/>
									<select name = "estado" id = "estado" required = "required">                                      
							<option value = "1" selected = "selected">Activo</option>
							<option value = "0" >Inactivo</option>
						</select>			
								</div>				
								<div class = "form-group">	
									<button class = "btn btn-primary" name = "save_user"><span class = "glyphicon glyphicon-save"></span> Registrar</button>
								</div>
							</form>	
						</div>	
					</div>
			</div>
		</div>
		<br />
		<br />
		<br />
		<?php require("footer.php"); ?>
	<script type = "text/javascript">
		$(document).ready(function() {
    $('#table').DataTable( {
	"language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        dom: 'Bfrtip',
        buttons: [
				{
                    extend: 'pdf',
                    text: '<img src="images/pdf.png" width=20 height=20/>',
					titleAttr: 'Exportar a pdf'
                },
                {
                    extend: 'excel',
                    text: '<img src="images/xls.png" width=20 height=20/>',
					titleAttr: 'Exportar a excel'
                },
                {
                    extend: 'csv',
                    text: '<img src="images/csv.png" width=20 height=20/>',
					titleAttr: 'Exportar a csv'
                },
                {
                    extend: 'print',
                    text: '<img src="images/print.png" width=20 height=20/>',
					titleAttr: 'Imprimir'
                }],
                
                 columnDefs: [
      { width: "10%", targets: 0 },
      { width: "15%", targets: 1 },
      { width: "13%", targets: 2 },
      { width: "8%", targets: 3 },
      { width: "5%", targets: 4 },
      { width: "3%", targets: 5 },
      { width: "8%", targets: 6 },
      { width: "38%", targets: 7 },
    ],
                
    } );
} );
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$('#add_admin').click(function(){
				$(this).hide();
				$('#show_admin').show();
				$('#admin_table').slideUp();
				$('#admin_form').slideDown();
				$('#show_admin').click(function(){
					$(this).hide();
					$('#add_admin').show();
					$('#admin_table').slideDown();
					$('#formcurso')[0].reset();
					$('#admin_form').slideUp();
				});
			});
		});
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$result = $('<center><label>Activando/Desactivando el registro...</label></center>');
			$("#table").on("click", ".deladmin_id", function(){
				$admin_id = $(this).attr('value');
				$(this).parents('td').empty().append($result);
				$('.deladmin_id').attr('disabled', 'disabled');
				$('.eadmin_id').attr('disabled', 'disabled');
				setTimeout(function(){
					window.location = 'cursoEliminar.php?admin_id=' + $admin_id;
				}, 1000);
			});
			$("#table").on("click", ".eadmin_id", function(){
				$admin_id = $(this).attr('value');
				$('#show_admin').show();
				$('#show_admin').click(function(){
					$(this).hide();
					$('#edit_form').empty();
					$('#admin_table').show();
					$('#add_admin').show();
				});
				$('#admin_table').fadeOut();
				$('#add_admin').hide();
				$('#edit_form').load('cursoCargar.php?admin_id=' + $admin_id);
			});
		});
	</script>
</html>