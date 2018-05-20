


    <form id="BooksForm" method="post" novalidate style="width:100%; height: 100%;padding:0;" enctype="multipart/form-data">

      <div class="easyui-layout" fit="true">


        <div data-options="region:'north',border:false" style="height:60px;padding:20px 0 20px 20px;overflow: hidden;">
          <div class="ftitle">
            Book Information
          </div>
        </div>

        <div data-options="region:'west',border:false" style="width:30%;padding:0px 0px 20px 20px">

          <div class="fitem">
              <input name="title" class="easyui-textbox" prompt="Book" value="{!! $book->title !!}" required="true" style="width:95%;">
          </div>

          <div class="fitem">
              <input class="easyui-combobox" prompt="Category" id="category" name="category" value="{!! $book->category()->first()->name !!}" style="width:95%;" data-options="
                  url: 'books/list-categories',
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
              <input class="easyui-combobox" prompt="Author" id="author" name="author" value="{!! $book->author()->first()->name !!}" style="width:95%;" data-options="
                  url: 'books/list-authors',
                  method: 'get',
                  valueField: 'name',
                  textField: 'name',
                  hasDownArrow: true,
                  panelHeight:'auto',
                  prompt: 'Select or write a author',
                  required:true
                  ">
          </div>

          <div class="fitem">
              <input class="easyui-filebox" name="book_image[]" multiple="false" accept="image/*" buttonAlign="left" style="width:95%" prompt="Book image">
          </div>

          <div class="fitem">
              <input class="easyui-filebox" name="book_file[]" multiple="false" accept=".pdf" buttonAlign="left" style="width:95%" prompt="Book video">
          </div>

          @foreach ($book->getMedia() as $mediaItem)
            <div class="easyui-layout" id="MediaItem{!!$mediaItem->id!!}" style="height: 100px;width:95%;margin:5px 0;">
              <div data-options="region:'west'" style="width:160px">
                @if($mediaItem->mime_type != 'application/pdf')
                  <img src="{{ $mediaItem->getUrl() }}" style="width:100%;height: 100%;">
                @else
                  <img src="{{ asset('img/dock/pdf.svg') }}" style="width:100%;height: 100%;padding:10px;">
                @endif

              </div>
              <div data-options="region:'center'" style="text-align: center;padding:30px 0px">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" onclick="removeBookImage('{!! $mediaItem->id !!}', '{!! $book->id !!}')"></a>
                <a href="{!! $mediaItem->getUrl() !!}" target="_blank" class="easyui-linkbutton" iconCls="icon-search"></a>
              </div>
            </div>
          @endforeach

        </div>

        <div data-options="region:'south', border:true" style="height:50px;padding:10px;text-align: center;">

          <a href="javascript:void(0)" class="easyui-linkbutton c4" iconCls="icon-save" onclick="saveBook('books/update?id=' + {!!$book->id!!})">Save</a>
          <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#BooksDialog').dialog('close')" style="width:90px">Cancel</a>

        </div>

        <div data-options="region:'center', border:false" style="padding-right:10px;">


          <div class="fitem">
              <div id="book_summernote"></div>
          </div>

        </div>


      </div>


    </form>

<style>
  #BooksForm .fitem{
    margin: 10px 0;
  }
</style>

<script>

  $(function(){

      var description = {!! json_encode($book->description) !!};

      $('#book_summernote').summernote({
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

      $('#BookForm').form('load', {
        category: '{!! $book->category !!}',
      });
  });

  function removeBookImage(mediaId, bookId) {

      $.post('books/destroy/media', {
          'media_id': mediaId,
          'book_id': bookId,
      }, function(result) {
          if (result.success) {

              $('#MediaItem' + mediaId).hide();

          } else {
            $.messager.show({ title: 'Error', msg: result.msg});
          }
      }, 'json');
  }

</script>
