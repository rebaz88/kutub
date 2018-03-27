
<table id="ItemsDatagrid"
		url="items/list"
		singleSelect="true">
	<thead>
		<tr>
			<th field="name" width="100" editor="{type:'validatebox',options:{required:true}}">Name</th>
			<th field="size" width="100" editor="{type:'validatebox',options:{required:true}}">Size</th>
			<th field="color" width="100" editor="{type:'validatebox',options:{required:true}}">Color</th>
		</tr>
	</thead>
</table>

<div id="ItemsDatagridToolbar" style="padding:5px;">
  <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:$('#ItemsDatagrid').edatagrid('addRow')">New</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-save"  onclick="javascript:$('#ItemsDatagrid').edatagrid('saveRow')">Save</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="javascript:$('#ItemsDatagrid').edatagrid('destroyRow')">Remove</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-cancel"  onclick="javascript:$('#ItemsDatagrid').edatagrid('cancelRow')">Cancel</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#ItemsDatagrid').edatagrid('reload')">Reload</a>
</div>


<script type="text/javascript">
	$(function(){
		$('#ItemsDatagrid').edatagrid({
			idField:'id',
		    toolbar:'#ItemsDatagridToolbar',
		    fit:true,
		    border:false,
		    fitColumns:true,
		    singleSelect:true,
		    method:'get',
		    rownumbers:true,
		    url:'items/list',
		    saveUrl: 'items/insert',
		    updateUrl: 'items/update',
		    destroyUrl: 'items/destroy',
		});
	});

</script>
