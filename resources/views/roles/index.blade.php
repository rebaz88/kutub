
<table id="RolesDatagrid"
		singleSelect="true">
	<thead>
		<tr>
			<th field="name" width="100" editor="{type:'validatebox',options:{required:true}}">Role</th>
		</tr>
	</thead>
</table>

<div id="RolesDatagridToolbar" style="padding:5px;">
  <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:$('#RolesDatagrid').edatagrid('addRow')">New</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-save"  onclick="javascript:$('#RolesDatagrid').edatagrid('saveRow')">Save</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="javascript:$('#RolesDatagrid').edatagrid('destroyRow')">Remove</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-cancel"  onclick="javascript:$('#RolesDatagrid').edatagrid('cancelRow')">Cancel</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#RolesDatagrid').edatagrid('reload')">Reload</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-permission"  onclick="openRolePermissionDialog()">Set Permissions</a>
</div>

<div id="RolePermissionDialog" class="easyui-dialog" style="width:400px;height:700px;" closed="true">

</div>

<script type="text/javascript">
	$(function(){
		$('#RolesDatagrid').edatagrid({
			idField:'id',
			title:'Roles',
		    toolbar:'#RolesDatagridToolbar',
		    fit:true,
		    border:false,
		    fitColumns:true,
		    singleSelect:true,
		    method:'get',
		    rownumbers:true,
		    url:'roles/list',
		    saveUrl: 'roles/insert',
		    updateUrl: 'roles/update',
		    destroyUrl: 'roles/destroy'
		});
	});

	function openRolePermissionDialog() {

		var row = $('#RolesDatagrid').datagrid('getSelected');

		if (!row) {
			$.messager.show({ title: 'Error', msg: 'Please select a role'});
		  	return;
		}

		$('#RolePermissionDialog').dialog('open').dialog('setTitle', 'Set permissions for role ' + row.name);


		$('#RolePermissionDialog').dialog('refresh', 'roles/permissions/show?role_id=' + row.id);


	}


</script>
