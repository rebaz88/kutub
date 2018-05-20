
<table id="VideosDatagrid">
    <thead>
      <tr>
          <th data-options="field:'title',width:120">Title</th>
          <th data-options="field:'category',width:120">Category</th>
          <th data-options="field:'video_file',width:120, formatter:formatterVideoFile">File</th>
      </tr>
  </thead>
</table>

<div id="VideosDatagridToolbar">

  <div style="padding:5px;">

    <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="addVideo()">New</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit"  onclick="editVideo('save')">Edit</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="removeVideo()">Remove</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#VideosDatagrid').datagrid('reload')">Reload</a>

  </div>


</div>

<div id="VideosDialog" class="easyui-dialog" style="width:80%;height:80%;" title="Video" closed="true" modal="true">

</div>

<div id="VideosDialogButtons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveVideo()">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#VideosDialog').dialog('close')" style="width:90px">Cancel</a>
</div>


<script>


  $('#VideosDatagrid').datagrid({
    title:'Videos',
    fit:true,
    toolbar:'#VideosDatagridToolbar',
    nowrap:false,
    fitColumns:true,
    singleSelect:true,
    method:'get',
    rownumbers:true,
    pagination:true,
    border:false,
    remoteFilter:true,
    filterMatchingType:'any',
    url:'videos/list'
  })

  $('#VideosDatagrid').datagrid('enableFilter', [
    {
      field: 'video_image',
      type: 'label'
    },
    {
      field: 'video_file',
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
          url:'videos/list-categories',
          onChange:function(value){
              onChangeVideosConrols('categories.name', value);
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
          url:'videos/list-authors',
          onChange:function(value){
              onChangeVideosConrols('authors.name', value);
          }
     }
   }

  ]);

  function onChangeVideosConrols(filter, value) {
      if (value == ''){
          $('#VideosDatagrid').datagrid('removeFilterRule', filter);
      } else {
          $('#VideosDatagrid').datagrid('addFilterRule', {
              field: filter,
              value: value,
              op: 'like'
          });
      }
      $('#VideosDatagrid').datagrid('doFilter');
}

function formatterVideoFile(val, row) {
  return (val) ? '<video width="320" height="240" controls>' +
  '<source src="' + val.url + '" type="video/mp4">' +
  '<source src="movie.ogg" type="video/ogg">' +
  'Your browser does not support the video tag.' +
  '</video>' : '---';
}

  var url;

  function addVideo() {

      $('#VideosDialog').dialog('open').dialog('refresh', 'videos/insert');
  }

  function editVideo() {

      var row = $('#VideosDatagrid').datagrid('getSelected');

      if (!row) {

      	$.messager.show({ title: 'Error', msg: 'Please select a video'});
        return;
      }

      $('#VideosDialog').dialog('open').dialog('refresh', 'videos/update?id=' +  row.id);

  }

  function saveVideo(url) {

    $.messager.progress();  // display the progress bar

    $('#VideosForm').form('submit', {

        url: url,

        onSubmit: function(param) {
          param._token = window.CSRF_TOKEN;
          param.description = $('#video_summernote').summernote('code');


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

                $('#VideosForm').form('clear');
                $('#VideosDatagrid').datagrid('reload')
                $('#VideosDialog').dialog('close');

            }

            $.messager.progress('close');

        }
    });

  }

  function removeVideo() {

      // var row = quotaDataGrid.datagrid('getSelected');
      var row = $('#VideosDatagrid').datagrid('getSelected');

      if (!row) {
      	$.messager.show({ title: 'Error', msg: 'Please select a video'});
        return;
      }

      $.messager.confirm('Confirm', 'Are you sure you want to delete this video?', function(r) {
          if (r) {

              $.post('videos/destroy', {
                  'id': row.id,
              }, function(result) {
                  if (result.success) {

                      $('#VideosDatagrid').datagrid('reload');

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
              $('#video_summernote').summernote('insertImage', url, function($image) {
                $image.css('width', '100%');
              });
          }
      });
  }


</script>
