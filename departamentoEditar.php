<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){	
			$conn->query("UPDATE departamento SET descripcion = '$_POST[descripcion]', estado = '$_POST[estado]' WHERE idDepartamento = '$_REQUEST[admin_id]'") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente");
					window.location = "departamento.php";
				</script>
			';
	}	