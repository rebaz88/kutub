
<table id="AgentsDatagrid">
	<thead>
		<tr>
			<th field="name" width="100" editor="{type:'validatebox',options:{required:true}}">Agent</th>
			<th field="location" width="100" editor="{type:'validatebox',options:{required:true}}">Location</th>
			<th field="contact_phone" width="100" editor="{type:'validatebox',options:{required:true}}">Phone #</th>
		</tr>
	</thead>
</table>

<div id="AgentsDatagridToolbar" style="padding:5px;">
  <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:$('#AgentsDatagrid').edatagrid('addRow')">New</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-save"  onclick="javascript:$('#AgentsDatagrid').edatagrid('saveRow')">Save</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="javascript:$('#AgentsDatagrid').edatagrid('destroyRow')">Remove</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-cancel"  onclick="javascript:$('#AgentsDatagrid').edatagrid('cancelRow')">Cancel</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#AgentsDatagrid').edatagrid('reload')">Reload</a>
</div>

<script type="text/javascript">
	$(function(){
		$('#AgentsDatagrid').edatagrid({
			idField:'id',
			title:'Agents',
		    toolbar:'#AgentsDatagridToolbar',
		    fit:true,
		    border:false,
		    fitColumns:true,
		    singleSelect:true,
		    method:'get',
		    rownumbers:true,
		    url:'agents/list',
		    saveUrl: 'agents/insert',
		    updateUrl: 'agents/update',
		    destroyUrl: 'agents/destroy'
		});
	});
</script>
