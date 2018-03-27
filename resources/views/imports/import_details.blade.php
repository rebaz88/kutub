<table id="ImportDetailsDatagrid"></table>

<div id="ImportDetailsDatagridToolbar" style="padding:5px;">
  <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:$('#ImportDetailsDatagrid').edatagrid('addRow')">New</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-save"  onclick="javascript:$('#ImportDetailsDatagrid').edatagrid('saveRow')">Save</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="javascript:$('#ImportDetailsDatagrid').edatagrid('destroyRow')">Remove</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-cancel"  onclick="javascript:$('#ImportDetailsDatagrid').edatagrid('cancelRow')">Cancel</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#ImportDetailsDatagrid').edatagrid('reload')">Reload</a>
</div>

<script type="text/javascript">
	var import_id = '{!! $import_id !!}';
	$(function(){
		$('#ImportDetailsDatagrid').edatagrid({
			idField:'id',
		    toolbar:'#ImportDetailsDatagridToolbar',
		    fit:true,
		    border:false,
		    fitColumns:true,
		    singleSelect:true,
		    method:'get',
		    rownumbers:true,
		    url:('import-details/list?import_id=' + import_id),
		    saveUrl: ('import-details/insert?import_id=' + import_id),
		    updateUrl: ('import-details/update?import_id=' + import_id),
		    destroyUrl: ('import-details/destroy', + import_id),

		    columns: [[
		    	{field:'name',title:'Name',width:80,
		    		editor:{
		    			type:'combobox',
                       	options:{
	                       	method:'get',
	                       	mode:'remote',
	                       	textField:'name',
	                       	valueField: 'name',
	                        url:'items/list-item-names/name',
	                        panelHeight:'auto',
	                        required:true
		    			}
		    		}
		    	},

		    	{field:'size',title:'Size',width:80,
		    		editor:{
		    			type:'combobox',
                       	options:{
	                       	method:'get',
	                       	mode:'remote',
	                       	textField:'size',
	                       	valueField: 'size',
	                        url:'items/list-item-names/size',
	                        panelHeight:'auto',
	                        required:true
	                    }
		    		}
		    	},

		    	{field:'color',title:'Color',width:80,
		    		editor:{
		    			type:'combobox',
                       	options:{
	                       	method:'get',
	                       	mode:'remote',
	                       	textField:'color',
	                       	valueField: 'color',
	                        url:'items/list-item-names/color',
	                        panelHeight:'auto',
	                        required:true
	                    }
		    		}
		    	},

		    	{field:'quantity',title:'Quantity',width:80,
		    		editor:{
		    			type:'numberbox',
		    			options:{
		    				required:true,
		    				tipPosition:'bottom'
		    			}
		    		}
		    	},

		    	{field:'unit_price',title:'Price',width:80,
		    		editor:{
		    			type:'numberbox',
		    			options:{
		    				required:true,
		    				tipPosition:'bottom'
		    			}
		    		}
		    	},

		    	{field:'discount',title:'Discount',width:80,
		    		editor:{
		    			type:'numberbox',
		    			options:{
		    				required:true,
		    				tipPosition:'bottom'
		    			}
		    		}
		    	},

		    	{field:'total',title:'Total',width:80, align:'center',
		    		editor:{
		    			type:'numberbox',
		    			options:{
		    				tipPosition:'bottom',
		    				disabled:true
		    			}
		    		}
		    	},

		    	{field:'action',title:'Action',width:80,align:'center',
	                formatter:function(value,row,index){
	                    if (row.editing){
	                        var s = '<button onclick="saverow(this)">Save</button> ';
	                        var c = '<button onclick="cancelrow(this)">Cancel</button>';
	                        return s+c;
	                    } else {
	                        var e = '<button onclick="editrow(this)">Edit</button> ';
	                        var d = '<button onclick="deleterow(this)">Delete</button>';
	                        return e+d;
	                    }
	                }
	            }


		    ]],
		    onBeginEdit:function(rowIndex){

		        var editors = $('#ImportDetailsDatagrid').edatagrid('getEditors', rowIndex);
		        var quantityEditor = $(editors[3].target);
		        var unitPriceEditor = $(editors[4].target);
		        var discountEditor = $(editors[5].target);
		        var totalEditor = $(editors[6].target);

		        quantityEditor.numberbox('textbox').bind('keydown',function(e){
				    calculateImportDetailTotal(quantityEditor, unitPriceEditor, discountEditor, totalEditor);
				});

				unitPriceEditor.numberbox('textbox').bind('keydown',function(e){
				    calculateImportDetailTotal(quantityEditor, unitPriceEditor, discountEditor, totalEditor);
				});

				discountEditor.numberbox('textbox').bind('keydown',function(e){
				    calculateImportDetailTotal(quantityEditor, unitPriceEditor, discountEditor, totalEditor);
				});

    		},

	        onBeforeEdit:function(index,row){
	            row.editing = true;
	            $(this).edatagrid('refreshRow', index);
	        },
	        onAfterEdit:function(index,row){
	            row.editing = false;
	            $(this).edatagrid('refreshRow', index);
	        },
	        onCancelEdit:function(index,row){
	            row.editing = false;
	            $(this).edatagrid('refreshRow', index);
	        },

	        onSuccess:function(index,row){
	            $(this).edatagrid('addRow');
	        }


		});
	});

	function getRowIndex(target){
	    var tr = $(target).closest('tr.datagrid-row');
	    return parseInt(tr.attr('datagrid-row-index'));
	}
	function editrow(target){
	    $('#ImportDetailsDatagrid').edatagrid('beginEdit', getRowIndex(target));
	}
	function deleterow(target){
	    $.messager.confirm('Confirm','Are you sure?',function(r){
	        if (r){
	            $('#ImportDetailsDatagrid').edatagrid('deleteRow', getRowIndex(target));
	        }
	    });
	}
	function saverow(target){
	    $('#ImportDetailsDatagrid').edatagrid('endEdit', getRowIndex(target));
	}
	function cancelrow(target){
	    $('#ImportDetailsDatagrid').edatagrid('cancelEdit', getRowIndex(target));
	}

	function calculateImportDetailTotal(quantityEditor, unitPriceEditor, discountEditor, totalEditor) {

		var quantity = quantityEditor.numberbox('getValue');
    	var unit_price = unitPriceEditor.numberbox('getValue');
    	var discount = discountEditor.numberbox('getValue');

    	var beforeDiscountPrice = quantity * unit_price;

    	var afterDiscountPrice = beforeDiscountPrice - ( beforeDiscountPrice * discount / 100 );

    	totalEditor.textbox('setValue', afterDiscountPrice);


	}


</script>
