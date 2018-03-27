
<table id="ImportsDatagrid" style="border-bottom: 0">
    <thead>
      <tr>
          <th data-options="field:'invoice',width:120">Invoice</th>
          <th data-options="field:'date',width:120">Date</th>
          <th data-options="field:'type',width:120">Type</th>
          <th data-options="field:'port',width:120">Port</th>
          <th data-options="field:'container',width:120">Container</th>
          <th data-options="field:'vendor',width:120">Vendor</th>
          <th data-options="field:'total',width:120, align:'center'" formatter="importTotalFormatter">Total</th>
          <th data-options="field:'note',width:120">Note</th>
      </tr>
  </thead>
</table>


<div id="ImportsDatagridToolbar">

    <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="addImport()">New</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit"  onclick="editImport('save')">Edit</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="removeImport()">Remove</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#ImportsDatagrid').datagrid('reload')">Reload</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="openImportDetailDialogFromDatagrid()">Edit Items</a>


</div>

<div id="ImportsDialog" class="easyui-dialog" style="width:500px;height:auto;padding:10px 20px" buttons="#ImportsDialogButtons" title="Import" closed="true" modal="true">

    <form id="ImportsForm" method="post" novalidate>

      <div class="ftitle">Import Information</div>

      <div class="fitem">
          <label>Invoice:</label>
          <input name="invoice" class="easyui-textbox" required="true" style="width:200px;">
      </div>

      <div class="fitem">
          <label>Date:</label>
          <input name="date" class="easyui-datebox" required="true" style="width:200px;">
      </div>

      <div class="fitem">
          <label>Type:</label>
          <input class="easyui-combobox" name="type" style="width:200px;" data-options="
              valueField: 'name',
              textField: 'name',
              limitToList: true,
              hasDownArrow: true,
              panelHeight:'auto',
              required:true,
              data: [{
                'name': 'IN'
              },{
                'name': 'OUT'
              },]
              ">
      </div>

      <div class="fitem">
          <label>Port:</label>
          <input name="port" class="easyui-textbox" required="true" style="width:200px;">
      </div>

      <div class="fitem">
          <label>Container:</label>
          <input name="container" class="easyui-textbox" required="true" style="width:200px;">
      </div>

      <div class="fitem">
          <label>Vendor:</label>
          <input name="vendor" class="easyui-textbox" required="true" style="width:200px;">
      </div>

      <div class="fitem">
          <label>Note:</label>
          <input class="easyui-textbox" name="note"  data-options="multiline:true" style="height:160px;width:200px;">
      </div>

    </form>
</div>

<div id="ImportsDialogButtons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveImport(true)">Save & Enter Items</a>
    <a href="javascript:void(0)" class="easyui-linkbutton c7" iconCls="icon-save" onclick="saveImport(false)">Save & Exit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#ImportsDialog').dialog('close')" style="width:90px">Cancel</a>
</div>


<div id="ImportDetailDialog" class="easyui-dialog" title="Imported Items" style="width:100%;height:100%;" closed="true" data-options="{onClose:function(){$('#ImportsDatagrid').datagrid('reload')}}">

</div>

<script>



  var importsDataGrid = $('#ImportsDatagrid').datagrid({
    title:'Imports',
    fit:true,
    toolbar:'#ImportsDatagridToolbar',
    nowrap:false,
    fitColumns:true,
    singleSelect:true,
    method:'get',
    rownumbers:true,
    pagination:true,
    url:'imports/list',
    onDblClickRow:function(index,row  ) {
      openImportDetailDialog(row.id);
    },
  });

  function importTotalFormatter(val) {
    return val ? val : 0;
  }


  var url;

  function addImport() {

      $('#ImportsDialog').dialog('open');
      $('#ImportsForm').form('clear');
      url = 'imports/create';
  }

  function editImport() {

      var row = $('#ImportsDatagrid').datagrid('getSelected');

      if (!row) {

      	$.messager.show({ title: 'Error', msg: 'Please select a import'});
        return;
      }

      url = 'imports/update?id=' + row.id;

      $('#ImportsForm').form('clear');
      $('#ImportsForm').form('load', row);

      $('#ImportsDialog').dialog('open');

  }

  function saveImport(andEnterItems) {

    $('#ImportsForm').form('submit', {

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

                $('#ImportsDatagrid').datagrid('reload')
                $('#ImportsDialog').dialog('close');
                $('#ImportsForm').form('clear');

                if(andEnterItems) {
                  openImportDetailDialog(result.id);
                } else {
                  $.messager.show({ title: 'Success', msg: 'Operation performed successfully!'});
                }


            }
        }
    });

  }
  function removeImport() {

      // var row = quotaDataGrid.datagrid('getSelected');
      var row = $('#ImportsDatagrid').datagrid('getSelected');

      if (!row) {
      	$.messager.show({ title: 'Error', msg: 'Please select a import'});
        return;
      }

      $.messager.confirm('Confirm', 'Are you sure you want to delete this import?', function(r) {
          if (r) {

              $.post('imports/destroy', {
                  'id': row.id,
              }, function(result) {
                  if (result.success) {

                      $('#ImportsDatagrid').datagrid('reload');

                  } else {
                  	$.messager.show({ title: 'Error', msg: result.msg});
                  }
              }, 'json');
          }
      });
  }

  function openImportDetailDialogFromDatagrid() {

    // var row = quotaDataGrid.datagrid('getSelected');
      var row = $('#ImportsDatagrid').datagrid('getSelected');

      if (!row) {
        $.messager.show({ title: 'Error', msg: 'Please select an import'});
        return;
      }

      openImportDetailDialog(row.id);

  }

  function openImportDetailDialog(import_id) {

    $('#ImportDetailDialog').dialog('open');

    $('#ImportDetailDialog').dialog('refresh', 'import-details?import_id=' + import_id);

  }



</script>


