
  <table id="ExpendituresDatagrid">
      <thead>
        <tr>
            <th data-options="field:'ck',checkbox:true"></th>
            <th data-options="field:'type',width:120">Type</th>
            <th data-options="field:'detail',width:120">Detail</th>
            <th data-options="field:'amount',width:40">Amount</th>
            <th data-options="field:'officer',width:40">Officer</th>
            <th data-options="field:'date',width:70,sortable:true">Date</th>
            <th data-options="field:'note',width:120">Note</th>
            <th data-options="field:'attachment',width:80" formatter="viewExpenditureAttachment">Attachment</th>
        </tr>
    </thead>
  </table>

  <div id="ExpendituresDatagridToolbar" style="padding:5px;">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add"  onclick="newExpenditure()">New Expenditure</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit"  onclick="editExpenditure()">Edit Expenditure</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove"  onclick="destroyExpenditure()">Remove Expenditure</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="$('#ExpendituresDatagrid').datagrid('reload')">Reload</a>
    <span style="margin-left:20px;">Include data in filter from:</span>
    <input class="easyui-datebox" id="filter_from" >
    To:
    <input class="easyui-datebox" id="filter_to">
    <a href="#" class="easyui-linkbutton" iconCls="icon-search"  onclick="expenditureFilterByDate()">Apply date filter</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-reset"  onclick="clearExpenditureFilterByDate()">Clear date filter</a>

  </div>

  <div id="ExpendituresDialog" class="easyui-dialog" style="width:650px;height:auto;padding:10px 20px"
			closed="true" buttons="#ExpendituresDialogButtons" modal="true">
		<form id="ExpenditureForm" method="post" novalidate enctype="multipart/form-data">
      <div class="ftitle">Expenditure Information</div>
      <div class="fitem">
        <label>Officer:</label>
        <input name="officer" class="easyui-textbox" required="true">
      </div>

      <div class="fitem">
        <label>Type:</label>
        <input name="type" id="type" class="easyui-combobox"
        data-options="panelHeight:'auto',
                      required:true,
                      prompt:'Type',
                      editable:true,
                      textField:'type',
                      valueField:'type',
                      method:'get',
                      url:'expenditures/list/types',
                      onSelect: function(rec){
                          var url = 'expenditures/list/details?type='+rec.type;
                          $('#ExpenditureForm #detail').combobox('reload', url);
                      }
                      ">
      </div>

      <div class="fitem">
				<label>Detail:</label>
        <input name="detail" id="detail" class="easyui-combobox"
        data-options="panelHeight:'auto',
                      required:true,
                      prompt:'Detail',
                      editable:true,
                      textField:'detail',
                      valueField:'detail',
                      method:'get',
                      data:[],
                      hasDownArrow:true
                      ">
			</div>

			<div class="fitem">
        <label>Amount:</label>
        <input name="amount" class="easyui-numberbox" required="true" style="width:150px;">
        <input name="date" id="date" class="easyui-datebox" required="true" prompt="Date" style="width:150px;">
      </div>

      <div class="fitem">
				<label>Attachment:</label>
				<input name="attachment" class="easyui-filebox">
			</div>

      <div class="fitem" style="margin:20px 0;">
       <label><b>Note:</b></label>
       <input class="easyui-textbox" name="note" id="note" style="height:60px" data-options="multiline:true">
     </div>

		</form>
	</div>
	<div id="ExpendituresDialogButtons">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveExpenditure()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#ExpendituresDialog').dialog('close')" style="width:90px">Cancel</a>
	</div>


<style media="screen">

  #ExpenditureForm label{
    width: 100px;
  }

  #ExpenditureForm input, textarea{
    width: 300px;
  }

</style>

<script type="text/javascript">



  /*
   * Vars
   */

  var url;

  var expendituresDatagrid = $('#ExpendituresDatagrid').datagrid({

      idField:'id',
      title:'Expenditure',
      toolbar:'#ExpendituresDatagridToolbar',
      fit:true,
      nowrap:false,
      border:false,
      fitColumns:true,
      autoLoad: false,
      singleSelect:true,
      method:'get',
      remoteSort:true,
      remoteFilter:true,
      filterMatchingType:'any',
      pagination:true,
      url:'expenditures/list',
      showFooter:true,

  });

  function viewExpenditureAttachment(val) {
     return (val) ? '<a href="'+val+'" target="_blank">Attachment</a>' : '---';
  }


  expendituresDatagrid.datagrid('enableFilter',
  [{
      field:'amount',
      type:'label'
    },
    {
      field:'date',
      type:'label'
    },
    {
      field:'attachment',
      type:'label'
    }]);


  function newExpenditure(){
    $('#ExpendituresDialog').dialog('open').dialog('setTitle','New Expenditure');
    $('#ExpenditureForm').form('clear');

    url = 'expenditures/insert';
  }

  function editExpenditure(){
    var row = $('#ExpendituresDatagrid').datagrid('getSelected');
    if (row){
      $('#ExpenditureForm').form('clear');
      $('#ExpendituresDialog').dialog('open').dialog('setTitle','Edit Expenditure');
      $('#ExpenditureForm').form('load',row);
      url = 'expenditures/update?id=' + row.id;
    }
  }

  function saveExpenditure(){
    $.messager.progress();	// display the progress bar
    $('#ExpenditureForm').form('submit',{
      url: url,
      onSubmit: function(param){
        param._token = window.CSRF_TOKEN;
        var formValidated = $(this).form('validate');
        if(formValidated)
          return true;

        $.messager.progress('close');
        return validateForm;
      },
      success: function(result){
        var result = eval('('+result+')');
        if (result.msg){
          showMessageDialog('Error', result.msg);
        } else {
          $('#ExpendituresDialog').dialog('close');		// close the dialog
          $('#ExpendituresDatagrid').datagrid('reload');	// reload the expenditures data
        }
        $.messager.progress('close');	// display the progress bar
      }
    });
  }
  function destroyExpenditure(){

    var row = $('#ExpendituresDatagrid').datagrid('getSelected');
    if (row){

      $.messager.confirm('Confirm','Are you sure you want to remove this expenditure?',function(r){
        if (r){
          $.post('expenditures/destroy',
            {id:row.id,
            _token: window.CSRF_TOKEN},
            function(result){
              if (result.success){
                $('#ExpendituresDatagrid').datagrid('reload');	// reload the expenditures data
              } else {
                $.messager.show({	// show error message
                  title: 'Error',
                  msg: result.msg
                });
              }
          },'json');
        }
      });
    }
  }



 function expenditureFilterByDate() {

   var filter_from = $('#filter_from').datebox('getValue') || '2010-01-01';
   var filter_to = $('#filter_to').datebox('getValue') || '2100-01-01';

   expendituresDatagrid.datagrid('addFilterRule', {
     field: 'filter_by_date',
     filter_from: filter_from,
     filter_to: filter_to
    });

    expendituresDatagrid.datagrid('doFilter');

 }

 function clearExpenditureFilterByDate() {
   $('#filter_from').datebox('setValue', '');
   $('#filter_to').datebox('setValue', '');
   expendituresDatagrid.datagrid('removeFilterRule', 'filter_by_date');
   expendituresDatagrid.datagrid('doFilter');
 }


</script>
