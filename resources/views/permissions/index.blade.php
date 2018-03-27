
<table id="PermissionsDatagrid">
	<thead>
		<tr>
			<th field="name" width="100" editor="{type:'validatebox',options:{required:true}}">Permission</th>
		</tr>
	</thead>
</table>

<div id="PermissionsDatagridToolbar" style="padding:5px;">
  <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:$('#PermissionsDatagrid').edatagrid('addRow')">New</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-save"  onclick="javascript:$('#PermissionsDatagrid').edatagrid('saveRow')">Save</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="javascript:$('#PermissionsDatagrid').edatagrid('destroyRow')">Remove</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-cancel"  onclick="javascript:$('#PermissionsDatagrid').edatagrid('cancelRow')">Cancel</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#PermissionsDatagrid').edatagrid('reload')">Reload</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-role"  onclick="openPermissionRoleDialog()">Set Roles</a>
</div>

<div id="PermissionRoleDialog" class="easyui-dialog" style="width:400px;height:700px;" closed="true">

</div>

<script type="text/javascript">
	$(function(){
		$('#PermissionsDatagrid').edatagrid({
			idField:'id',
			title:'Permissions',
		    toolbar:'#PermissionsDatagridToolbar',
		    fit:true,
		    border:false,
		    fitColumns:true,
		    singleSelect:true,
		    method:'get',
		    rownumbers:true,
		    url:'permissions/list',
		    saveUrl: 'permissions/insert',
		    updateUrl: 'permissions/update',
		    destroyUrl: 'permissions/destroy'
		});
	});

	function openPermissionRoleDialog() {

		var row = $('#PermissionsDatagrid').datagrid('getSelected');

		if (!row) {
			$.messager.show({ title: 'Error', msg: 'Please select a permission'});
		  	return;
		}

		$('#PermissionRoleDialog').dialog('open').dialog('setTitle', 'Set roles for permission ' + row.name);


		$('#PermissionRoleDialog').dialog('refresh', 'permissions/roles/show?permission_id=' + row.id);


	}
</script>
