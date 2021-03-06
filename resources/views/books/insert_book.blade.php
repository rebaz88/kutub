


    <form id="BooksForm" method="post" novalidate style="width:100%; height: 100%;padding:0;" enctype="multipart/form-data">

      <div class="easyui-layout" fit="true">


        <div data-options="region:'north',border:false" style="height:60px;padding:20px 0 20px 20px;overflow: hidden;">
          <div class="ftitle">
            Book Information
          </div>
        </div>

        <div data-options="region:'west',border:false" style="width:30%;padding:0px 0px 20px 20px">

          <div class="fitem">
              <input name="title" class="easyui-textbox" prompt="Title" required="true" style="width:95%;">
          </div>

          <div class="fitem">
              <input class="easyui-combobox" prompt="Category" id="category" name="category" style="width:95%;" data-options="
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
              <input class="easyui-combobox" prompt="Author" id="author" name="author" style="width:95%;" data-options="
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
              <input class="easyui-filebox" name="book_image[]" multiple="true" accept="image/*" buttonAlign="left" style="width:95%" prompt="Book image">
          </div>

          <div class="fitem">
              <input class="easyui-filebox" name="book_file[]" multiple="true" accept=".pdf" buttonAlign="left" style="width:95%" prompt="Book file">
          </div>

        </div>


        <div data-options="region:'south', border:true" style="height:50px;padding:10px;text-align: center;">

          <a href="javascript:void(0)" class="easyui-linkbutton c4" iconCls="icon-save" onclick="saveBook('books/insert')">Save</a>
          <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#BooksDialog').dialog('close')" style="width:90px">Cancel</a>

        </div>

        <div data-options="region:'center', border:false" style="padding-right:10px;">

          <div class="fitem">
              <div id="book_summernote"></div>
          </div>
          {{-- <div id="description" fit="true"></div> --}}

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
      });
  });

</script>
