
<table id="RolesPermissonsDatagrid">
	<thead>
		<tr>
			<th field="name" width="100">Permission</th>
			<th data-options="field:'status',width:60,align:'center'" formatter="formatRolesPermissonsStatus">Status</th>
		</tr>
	</thead>
</table>

<script type="text/javascript">
	$(function(){
		$('#RolesPermissonsDatagrid').datagrid({
			idField:'id',
		    fit:true,
		    border:false,
		    fitColumns:true,
		    singleSelect:true,
		    method:'get',
		    rownumbers:true,
		    url:'roles/permissions/list?role_id={!!$role_id!!}'
		});
	});

	function formatRolesPermissonsStatus(value,row,index) {
		var checked = (value) ? 'checked' : '';

		return '<input id="checkBox" type="checkbox" onchange="setRolesPermissions(' + row.id + ')" ' + checked + '>';
	}

	var role_id = '{!!$role_id!!}';

	function setRolesPermissions(permission_id) {

		$.post('roles/permissions/set', {
                  'role_id': role_id,
                  'permission_id':permission_id
              }, function(result) {}, 'json');
	}

</script>

<style>

</style>
