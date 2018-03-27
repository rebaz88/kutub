
<table id="ActivitiesDatagrid">
	<thead>
		<tr>
			<th field="users.name" width="100">Username</th>
			<th field="properties" width="100" formatter="formatModelActivityName">Target</th>
			<th field="subject_id" width="100">Target ID</th>
			<th field="description" width="100">Description</th>
			<th field="created_at" width="100">Time</th>
		</tr>
	</thead>
</table>

<div id="ActivitiesDatagridToolbar" style="padding:5px;">
    <span style="margin-left:20px;">Include data in filter from:</span>
    <input class="easyui-datebox" id="filter_from" >
    To:
    <input class="easyui-datebox" id="filter_to">
    <a href="#" class="easyui-linkbutton" iconCls="icon-search"  onclick="activityFilterByDate()">Apply date filter</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-reset"  onclick="clearActivityFilterByDate()">Clear date filter</a>
</div>

<script type="text/javascript">
	$(function(){
		$('#ActivitiesDatagrid').datagrid({
			idField:'id',
			toolbar: '#ActivitiesDatagridToolbar',
			title:'Ativities',
		    fit:true,
		    border:false,
		    fitColumns:true,
		    singleSelect:true,
		    method:'get',
		    rownumbers:true,
		    url:'activities/list',
		    pagination:true,
		    remoteFilter:true,
      		filterMatchingType:'any',
		});
	});

	$('#ActivitiesDatagrid').datagrid('enableFilter',
	  	[{
	      field:'properties',
	      type:'combobox',
	      options: {
	        panelHeight:'auto',
	        method:'get',
	        valueField: 'model_activity_name',
	        textField: 'model_activity_name',
	        url:'activities/list/model-activity-name',
	        onChange:function(value){
	            if (value == ''){
	                $('#ActivitiesDatagrid').datagrid('removeFilterRule', 'properties');
	            } else {
	                $('#ActivitiesDatagrid').datagrid('addFilterRule', {
	                    field: 'properties',
	                    value: value
	                });
	            }
	            $('#ActivitiesDatagrid').datagrid('doFilter');
	        }
	      }
	    }]
	 );


	function formatActivityAgency(val) {
		return (val) ? val : '---';
	}

	function formatModelActivityName(value, row) {
		if(row.properties)
			return row.properties.model_activity_name;
		return '---'
	}

	function activityFilterByDate() {

	   var filter_from = $('#ActivitiesDatagridToolbar #filter_from').datebox('getValue') || '2010-01-01';
	   var filter_to = $('#ActivitiesDatagridToolbar #filter_to').datebox('getValue') || '2100-01-01';

	   $('#ActivitiesDatagrid').datagrid('addFilterRule', {
	     field: 'filter_by_date',
	     filter_from: filter_from,
	     filter_to: filter_to
	    });

	    $('#ActivitiesDatagrid').datagrid('doFilter');

	 }

	 function clearActivityFilterByDate() {
	   $('#ActivitiesDatagridToolbar #filter_from').datebox('setValue', '');
	   $('#ActivitiesDatagridToolbar #filter_to').datebox('setValue', '');
	   $('#ActivitiesDatagrid').datagrid('removeFilterRule', 'filter_by_date');
	   $('#ActivitiesDatagrid').datagrid('doFilter');
	 }


</script>
