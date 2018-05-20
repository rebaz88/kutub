


    <form id="VideosForm" method="post" novalidate style="width:100%; height: 100%;padding:0;" enctype="multipart/form-data">

      <div class="easyui-layout" fit="true">


        <div data-options="region:'north',border:false" style="height:60px;padding:20px 0 20px 20px;overflow: hidden;">
          <div class="ftitle">
            Video Information
          </div>
        </div>

        <div data-options="region:'west',border:false" style="width:230px;padding:0px 0px 20px 20px">

          <div class="fitem">
              <input name="title" class="easyui-textbox" prompt="Title" required="true" style="width:200px;">
          </div>

          <div class="fitem">
              <input class="easyui-combobox" prompt="Category" id="category" name="category" style="width:200px;" data-options="
                  url: 'videos/list-categories',
                  method: 'get',
                  valueField: 'name',
                  textField: 'name',
                  hasDownArrow: true,
                  panelHeight:'auto',
                  prompt: 'Select or write a category',
                  required:true
                  ">
          </div>

          <div class="fitem">
              <input class="easyui-filebox" name="video_file[]" multiple="false" accept="video/*" buttonAlign="left" style="width:200px" prompt="Video">
          </div>

        </div>


        <div data-options="region:'south', border:true" style="height:50px;padding:10px;text-align: center;">

          <a href="javascript:void(0)" class="easyui-linkbutton c4" iconCls="icon-save" onclick="saveVideo('videos/insert')">Save</a>
          <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#VideosDialog').dialog('close')" style="width:90px">Cancel</a>

        </div>

        <div data-options="region:'center', border:false" style="padding-right:10px;">

          <div class="fitem">
              <div id="video_summernote"></div>
          </div>
          {{-- <div id="description" fit="true"></div> --}}

        </div>


      </div>


    </form>

<style>
  #VideosForm .fitem{
    margin: 10px 0;
  }
</style>

<script>

  $(function(){

    $('#video_summernote').summernote({
          // dialogsInBody: true,
          height: '85%',
          width: '100%',
          disableResizeImage: true,

          callbacks: {
              onImageUpload: function(image) {
                  saveEditorImage(image[0]);
              }
          }
      });
  });

</script>
