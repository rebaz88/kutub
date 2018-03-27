
<table id="PermissonRolesDatagrid">
	<thead>
		<tr>
			<th field="name" width="100">Permission</th>
			<th data-options="field:'status',width:60,align:'center'" formatter="formatPermissonsRolesStatus">Status</th>
		</tr>
	</thead>
</table>

<script type="text/javascript">
	$(function(){
		$('#PermissonRolesDatagrid').datagrid({
			idField:'id',
		    fit:true,
		    border:false,
		    fitColumns:true,
		    singleSelect:true,
		    method:'get',
		    rownumbers:true,
		    url:'permissions/roles/list?permission_id={!!$permission_id!!}'
		});
	});

	function formatPermissonsRolesStatus(value,row,index) {
		var checked = (value) ? 'checked' : '';

		return '<input id="checkBox" type="checkbox" onchange="setPermissionRoles(' + row.id + ')" ' + checked + '>';
	}

	var permission_id = '{!!$permission_id!!}';

	function setPermissionRoles(role_id) {

		$.post('permissions/roles/set', {
                  'role_id': role_id,
                  'permission_id':permission_id
              }, function(result) {}, 'json');
	}

</script>

<style>

</style>
