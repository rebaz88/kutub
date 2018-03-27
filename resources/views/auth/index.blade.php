
<table id="UsersDatagrid">
    <thead>
      <tr>
          <th data-options="field:'name',width:120">Name</th>
          <th data-options="field:'email',width:120">Email</th>
          <th data-options="field:'role',width:120">Role</th>
          <th data-options="field:'status',width:120" formatter="formatUserStatus">Status</th>
      </tr>
  </thead>
</table>

<div id="UsersDatagridToolbar">

  <p class="hint hint-p icon-tip-p">
    The default control panel password for new created user is his/her email
  </p>
  <div style="padding:5px;">

    <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="addUser()">New</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit"  onclick="editUser('save')">Edit</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="removeUser()">Remove</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#UsersDatagrid').datagrid('reload')">Reload</a>
    <a href="#" class="easyui-linkbutton" onclick="toggleUserStatus()">Toggle User Status</a>

  </div>


</div>

<div id="UsersDialog" class="easyui-dialog" style="width:500px;height:auto;padding:10px 20px" buttons="#UsersDialogButtons" title="User" closed="true" modal="true">

    <form id="UsersForm" method="post" novalidate>

      <div class="ftitle">User Information</div>

      <div class="fitem">
          <label>Name:</label>
          <input name="name" class="easyui-textbox" required="true" style="width:200px;">
      </div>

      <div class="fitem">
          <label>Email:</label>
          <input name="email" class="easyui-textbox" required="true" validType="email" style="width:200px;">
      </div>

      <div class="fitem">
          <label>Role:</label>
          <input class="easyui-combobox" id="role" name="role" style="width:200px;" data-options="
              url: 'roles/list',
              method: 'get',
              valueField: 'name',
              textField: 'name',
              limitToList: true,
              hasDownArrow: true,
              panelHeight:'auto',
              prompt: 'Select a role',
              required:true
              ">
      </div>


    </form>
</div>

<div id="UsersDialogButtons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#UsersDialog').dialog('close')" style="width:90px">Cancel</a>
</div>


<script>


  $('#UsersDatagrid').datagrid({
    title:'Users',
    fit:true,
    toolbar:'#UsersDatagridToolbar',
    nowrap:false,
    fitColumns:true,
    singleSelect:true,
    method:'get',
    rownumbers:true,
    pagination:true,
    border:false,
    url:'users/list'
  })

  $('#UsersDatagrid').datagrid('enableFilter');

  var url;

  function addUser() {

      $('#UsersDialog').dialog('open');
      $('#UsersForm').form('clear');
      url = 'users/create';
  }

  function editUser() {

      var row = $('#UsersDatagrid').datagrid('getSelected');

      if (!row) {

      	$.messager.show({ title: 'Error', msg: 'Please select a user'});
        return;
      }

      url = 'users/update?id=' + row.id;

      $('#UsersForm').form('clear');
      $('#UsersForm').form('load', row);

      $('#UsersDialog').dialog('open');

  }

  function saveUser() {

    $('#UsersForm').form('submit', {

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

                $('#UsersDatagrid').datagrid('reload')
                $('#UsersDialog').dialog('close');
                $('#UsersForm').form('clear');
                $.messager.show({ title: 'Success', msg: 'Operation performed successfully!'});


            }
        }
    });

  }
  function removeUser() {

      // var row = quotaDataGrid.datagrid('getSelected');
      var row = $('#UsersDatagrid').datagrid('getSelected');

      if (!row) {
      	$.messager.show({ title: 'Error', msg: 'Please select a user'});
        return;
      }

      $.messager.confirm('Confirm', 'Are you sure you want to delete this user?', function(r) {
          if (r) {

              $.post('users/destroy', {
                  'id': row.id,
              }, function(result) {
                  if (result.success) {

                      $('#UsersDatagrid').datagrid('reload');

                  } else {
                  	$.messager.show({ title: 'Error', msg: result.msg});
                  }
              }, 'json');
          }
      });
  }


  	function formatUserStatus(val) {
		return (val == '1') ? 'Enabled': 'Disabled';
	}

	function toggleUserStatus() {

	    var row = $('#UsersDatagrid').datagrid('getSelected');

	    if (row) {

	      var url = 'users/toggle-status?id=' + row.id;

	      $.messager.confirm('Confirm','Are you sure you want perform this operation?',function(r){
	        if (r){

	          $.post(url, function(result){

	            if (result.success){
	              $.messager.alert('Success','The user status changed');
	              $('#UsersDatagrid').datagrid('reload');
	            } else {
	              $.messager.show({ title: 'Error', msg: 'Could not perform the operation!'});
	            }
	          },'json');

	        }
	      });

	    } else {
	    	$.messager.show({title:'Error', msg:'Please select a user'});
	    }

	}

</script>


