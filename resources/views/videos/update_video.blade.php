


    <form id="VideosForm" method="post" novalidate style="width:100%; height: 100%;padding:0;" enctype="multipart/form-data">

      <div class="easyui-layout" fit="true">


        <div data-options="region:'north',border:false" style="height:60px;padding:20px 0 20px 20px;overflow: hidden;">
          <div class="ftitle">
            Video Information
          </div>
        </div>

        <div data-options="region:'west',border:false" style="width:230px;padding:0px 0px 20px 20px">

          <div class="fitem">
              <input name="title" class="easyui-textbox" prompt="Video" value="{!! $video->title !!}" required="true" style="width:200px;">
          </div>

          <div class="fitem">
              <input class="easyui-combobox" prompt="Category" id="category" name="category" value="{!! $video->category()->first()->name !!}" style="width:200px;" data-options="
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

          @foreach ($video->getMedia() as $mediaItem)
            <div class="easyui-layout" id="MediaItem{!!$mediaItem->id!!}" style="height: 100px;width:200px;margin:5px 0;">
              <div data-options="region:'west'" style="width:160px">
                <video width="100%" height="100%" controls>
                  <source src="{{ $mediaItem->getUrl() }}" type="video/mp4">
                  <source src="movie.ogg" type="video/ogg">
                    Your browser does not support the video tag.
                </video>
              </div>
              <div data-options="region:'center'" style="text-align: center;padding:30px 0px">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" onclick="removeVideoImage('{!! $mediaItem->id !!}', '{!! $video->id !!}')"></a>
              </div>
            </div>
          @endforeach

        </div>

        <div data-options="region:'south', border:true" style="height:50px;padding:10px;text-align: center;">

          <a href="javascript:void(0)" class="easyui-linkbutton c4" iconCls="icon-save" onclick="saveVideo('videos/update?id=' + {!!$video->id!!})">Save</a>
          <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#VideosDialog').dialog('close')" style="width:90px">Cancel</a>

        </div>

        <div data-options="region:'center', border:false" style="padding-right:10px;">


          <div class="fitem">
              <div id="video_summernote"></div>
          </div>

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

      var description = {!! json_encode($video->description) !!};

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
      }).summernote('code', description);

      $('#VideoForm').form('load', {
        category: '{!! $video->category !!}',
      });
  });

  function removeVideoImage(mediaId, videoId) {

      $.post('videos/destroy/media', {
          'media_id': mediaId,
          'video_id': videoId,
      }, function(result) {
          if (result.success) {

              $('#MediaItem' + mediaId).hide();

          } else {
            $.messager.show({ title: 'Error', msg: result.msg});
          }
      }, 'json');
  }

</script>
