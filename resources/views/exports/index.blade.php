
<table id="ExportsDatagrid" style="border-bottom: 0">
    <thead>
      <tr>
          <th data-options="field:'agent_name',width:120">Agent</th>
          <th data-options="field:'date',width:120">Date</th>
          <th data-options="field:'total',width:120, align:'center'" formatter="exportTotalFormatter">Total</th>
          <th data-options="field:'note',width:120">Note</th>
      </tr>
  </thead>
</table>


<div id="ExportsDatagridToolbar">

    <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="addExport()">New</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit"  onclick="editExport('save')">Edit</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="removeExport()">Remove</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#ExportsDatagrid').datagrid('reload')">Reload</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="openExportDetailDialogFromDatagrid()">Edit Items</a>


</div>

<div id="ExportsDialog" class="easyui-dialog" style="width:500px;height:auto;padding:10px 20px" buttons="#ExportsDialogButtons" title="Export" closed="true" modal="true">

    <form id="ExportsForm" method="post" novalidate>

      <div class="ftitle">Export Information</div>

      <div class="fitem">
          <label>Agent:</label>
          <input class="easyui-combobox" id="agent_name" name="agent_name" style="width:200px;" data-options="
              url: 'agents/list-agent-names',
              method: 'get',
              valueField: 'name',
              textField: 'name',
              limitToList: true,
              hasDownArrow: true,
              panelHeight:'auto',
              prompt: 'Select an agent',
              required:true
              ">
      </div>

      <div class="fitem">
          <label>Date:</label>
          <input name="date" class="easyui-datebox" required="true" style="width:200px;">
      </div>

      <div class="fitem">
          <label>Note:</label>
          <input class="easyui-textbox" name="note"  data-options="multiline:true" style="height:160px;width:200px;">
      </div>

    </form>
</div>

<div id="ExportsDialogButtons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveExport(true)">Save & Enter Items</a>
    <a href="javascript:void(0)" class="easyui-linkbutton c7" iconCls="icon-save" onclick="saveExport(false)">Save & Exit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#ExportsDialog').dialog('close')" style="width:90px">Cancel</a>
</div>


<div id="ExportDetailDialog" class="easyui-dialog" title="Exported Items" style="width:100%;height:100%;" closed="true" data-options="{onClose:function(){$('#ExportsDatagrid').datagrid('reload')}}">

</div>

<script>


  var exportsDataGrid = $('#ExportsDatagrid').datagrid({
    title:'Exports',
    fit:true,
    toolbar:'#ExportsDatagridToolbar',
    nowrap:false,
    fitColumns:true,
    singleSelect:true,
    method:'get',
    rownumbers:true,
    pagination:true,
    url:'exports/list',
    onDblClickRow:function(index,row  ) {
      openExportDetailDialog(row.id);
    },
  });

  function exportTotalFormatter(val) {
    return val ? val : 0;
  }


  var url;

  function addExport() {

      $('#ExportsDialog').dialog('open');
      $('#ExportsForm').form('clear');
      url = 'exports/insert';
  }

  function editExport() {

      var row = $('#ExportsDatagrid').datagrid('getSelected');

      if (!row) {

      	$.messager.show({ title: 'Error', msg: 'Please select an export'});
        return;
      }

      url = 'exports/update?id=' + row.id;

      $('#ExportsForm').form('clear');
      $('#ExportsForm').form('load', row);

      $('#ExportsDialog').dialog('open');

  }

  function saveExport(andEnterItems) {

    $('#ExportsForm').form('submit', {

        url: url,

        onSubmit: function(param) {
        	   param._token = window.CSRF_TOKEN;
            return $(this).form('validate');

        },
        success: function(result) {

            var result = eval('(' + result + ')');

            if (result.isError) {

        		  $.messager.show({ title: 'Error', msg: result.msg});


            } else {

                $('#ExportsDatagrid').datagrid('reload')
                $('#ExportsDialog').dialog('close');
                $('#ExportsForm').form('clear');

                if(andEnterItems) {
                  openExportDetailDialog(result.id);
                } else {
                  $.messager.show({ title: 'Success', msg: 'Operation performed successfully!'});
                }


            }
        }
    });

  }
  function removeExport() {

      // var row = quotaDataGrid.datagrid('getSelected');
      var row = $('#ExportsDatagrid').datagrid('getSelected');

      if (!row) {
      	$.messager.show({ title: 'Error', msg: 'Please select a export'});
        return;
      }

      $.messager.confirm('Confirm', 'Are you sure you want to delete this export?', function(r) {
          if (r) {

              $.post('exports/destroy', {
                  'id': row.id,
              }, function(result) {
                  if (result.success) {

                      $('#ExportsDatagrid').datagrid('reload');

                  } else {
                  	$.messager.show({ title: 'Error', msg: result.msg});
                  }
              }, 'json');
          }
      });
  }

  function openExportDetailDialogFromDatagrid() {

    // var row = quotaDataGrid.datagrid('getSelected');
      var row = $('#ExportsDatagrid').datagrid('getSelected');

      if (!row) {
        $.messager.show({ title: 'Error', msg: 'Please select an export'});
        return;
      }

      openExportDetailDialog(row.id);

  }

  function openExportDetailDialog(export_id) {

    $('#ExportDetailDialog').dialog('open');

    $('#ExportDetailDialog').dialog('refresh', 'export-details?export_id=' + export_id);

  }



</script>


