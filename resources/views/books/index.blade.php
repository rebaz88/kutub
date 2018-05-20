
<table id="BooksDatagrid">
    <thead>
      <tr>
          <th data-options="field:'title',width:120">Title</th>
          <th data-options="field:'category',width:120">Category</th>
          <th data-options="field:'author',width:120">Author</th>
          <th data-options="field:'book_image',width:120, formatter:formatterBookImage">Image</th>
          <th data-options="field:'book_file',width:120, formatter:formatterBookFile">File</th>
      </tr>
  </thead>
</table>

<div id="BooksDatagridToolbar">

  <div style="padding:5px;">

    <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="addBook()">New</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit"  onclick="editBook('save')">Edit</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="removeBook()">Remove</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#BooksDatagrid').datagrid('reload')">Reload</a>

  </div>


</div>

<div id="BooksDialog" class="easyui-dialog" style="width:80%;height:80%;" title="Book" closed="true" modal="true">

</div>

<div id="BooksDialogButtons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveBook()">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#BooksDialog').dialog('close')" style="width:90px">Cancel</a>
</div>


<script>


  $('#BooksDatagrid').datagrid({
    title:'Books',
    fit:true,
    toolbar:'#BooksDatagridToolbar',
    nowrap:false,
    fitColumns:true,
    singleSelect:true,
    method:'get',
    rownumbers:true,
    pagination:true,
    border:false,
    remoteFilter:true,
    filterMatchingType:'any',
    url:'books/list'
  })

  $('#BooksDatagrid').datagrid('enableFilter', [
    {
      field: 'book_image',
      type: 'label'
    },
    {
      field: 'book_file',
      type: 'label'
    },

    {
      field:'category',
      type:'combobox',
      options:{
          panelHeight:'auto',
          editable:true,
          textField:'name',
          valueField:'name',
          selectOnNavigation:true,
          mode:'remote',
          hasDownArrow:false,
          method:'get',
          url:'books/list-categories',
          onChange:function(value){
              onChangeBooksConrols('categories.name', value);
          }
     }
   },

    {
      field:'author',
      type:'combobox',
      options:{
          panelHeight:'auto',
          editable:true,
          textField:'name',
          valueField:'name',
          selectOnNavigation:true,
          mode:'remote',
          hasDownArrow:false,
          method:'get',
          url:'books/list-authors',
          onChange:function(value){
              onChangeBooksConrols('authors.name', value);
          }
     }
   }

  ]);

  function onChangeBooksConrols(filter, value) {
      if (value == ''){
          $('#BooksDatagrid').datagrid('removeFilterRule', filter);
      } else {
          $('#BooksDatagrid').datagrid('addFilterRule', {
              field: filter,
              value: value,
              op: 'like'
          });
      }
      $('#BooksDatagrid').datagrid('doFilter');
}

function formatterBookImage(val, row) {
  return (val) ? '<img src="' + val.url + '" style="width:75px;height: 75px;">' : '---';
}

function formatterBookFile(val, row) {
  return (val) ? '<a target="_blank" href="' + val.url +'">File</a>' : '---';
}

  var url;

  function addBook() {

      $('#BooksDialog').dialog('open').dialog('refresh', 'books/insert');
  }

  function editBook() {

      var row = $('#BooksDatagrid').datagrid('getSelected');

      if (!row) {

      	$.messager.show({ title: 'Error', msg: 'Please select a book'});
        return;
      }

      $('#BooksDialog').dialog('open').dialog('refresh', 'books/update?id=' +  row.id);

  }

  function saveBook(url) {

    $.messager.progress();  // display the progress bar

    $('#BooksForm').form('submit', {

        url: url,

        onSubmit: function(param) {
          param._token = window.CSRF_TOKEN;
          param.description = $('#book_summernote').summernote('code');
          // param.description = 'test';


          var formValidated = $(this).form('validate');

          if(formValidated)
            return true;

          $.messager.progress('close');
          return formValidated;

        },
        success: function(result) {

            var result = eval('(' + result + ')');

            if (result.isError) {

              $.messager.show({ title: 'Error', msg: result.msg});


            } else {

                $('#BooksForm').form('clear');
                $('#BooksDatagrid').datagrid('reload')
                $('#BooksDialog').dialog('close');

            }

            $.messager.progress('close');

        }
    });

  }

  function removeBook() {

      // var row = quotaDataGrid.datagrid('getSelected');
      var row = $('#BooksDatagrid').datagrid('getSelected');

      if (!row) {
      	$.messager.show({ title: 'Error', msg: 'Please select a book'});
        return;
      }

      $.messager.confirm('Confirm', 'Are you sure you want to delete this book?', function(r) {
          if (r) {

              $.post('books/destroy', {
                  'id': row.id,
              }, function(result) {
                  if (result.success) {

                      $('#BooksDatagrid').datagrid('reload');

                  } else {
                  	$.messager.show({ title: 'Error', msg: result.msg});
                  }
              }, 'json');
          }
      });
  }

  function saveEditorImage(file) {
      // return;
      data = new FormData();
      data.append("attachment[]", file);
      $.ajax({
          data: data,
          type: "POST",
          url: "/files/save-random-file",
          cache: false,
          contentType: false,
          processData: false,
          success: function(url) {
              $('#book_summernote').summernote('insertImage', url, function($image) {
                $image.css('width', '100%');
              });
          }
      });
  }


</script>
