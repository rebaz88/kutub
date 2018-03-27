<table id="ExportDetailsDatagrid"></table>

<div id="ExportDetailsDatagridToolbar" style="padding:5px;">
  <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:$('#ExportDetailsDatagrid').edatagrid('addRow')">New</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-save"  onclick="javascript:$('#ExportDetailsDatagrid').edatagrid('saveRow')">Save</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-remove"  onclick="javascript:$('#ExportDetailsDatagrid').edatagrid('destroyRow')">Remove</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-cancel"  onclick="javascript:$('#ExportDetailsDatagrid').edatagrid('cancelRow')">Cancel</a>
  <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#ExportDetailsDatagrid').edatagrid('reload')">Reload</a>
</div>

<script type="text/javascript">
	var export_id = '{!! $export_id !!}';
	$(function(){
		$('#ExportDetailsDatagrid').edatagrid({
			idField:'id',
		    toolbar:'#ExportDetailsDatagridToolbar',
		    fit:true,
		    border:false,
		    fitColumns:true,
		    singleSelect:true,
		    method:'get',
		    rownumbers:true,
		    url:('export-details/list?export_id=' + export_id),
		    saveUrl: ('export-details/insert?export_id=' + export_id),
		    updateUrl: ('export-details/update?export_id=' + export_id),
		    destroyUrl: ('export-details/destroy', + export_id),

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

		    	{field:'original_price',title:'Original Price',width:80,
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

		        var editors = $('#ExportDetailsDatagrid').edatagrid('getEditors', rowIndex);
		        var quantityEditor = $(editors[3].target);
		        var unitPriceEditor = $(editors[5].target);
		        var discountEditor = $(editors[6].target);
		        var totalEditor = $(editors[7].target);

		        quantityEditor.numberbox('textbox').bind('keydown',function(e){
				    calculateExportDetailTotal(quantityEditor, unitPriceEditor, discountEditor, totalEditor);
				});

				unitPriceEditor.numberbox('textbox').bind('keydown',function(e){
				    calculateExportDetailTotal(quantityEditor, unitPriceEditor, discountEditor, totalEditor);
				});

				discountEditor.numberbox('textbox').bind('keydown',function(e){
				    calculateExportDetailTotal(quantityEditor, unitPriceEditor, discountEditor, totalEditor);
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
	    $('#ExportDetailsDatagrid').edatagrid('beginEdit', getRowIndex(target));
	}
	function deleterow(target){
	    $.messager.confirm('Confirm','Are you sure?',function(r){
	        if (r){
	            $('#ExportDetailsDatagrid').edatagrid('deleteRow', getRowIndex(target));
	        }
	    });
	}
	function saverow(target){
	    $('#ExportDetailsDatagrid').edatagrid('endEdit', getRowIndex(target));
	}
	function cancelrow(target){
	    $('#ExportDetailsDatagrid').edatagrid('cancelEdit', getRowIndex(target));
	}

	function calculateExportDetailTotal(quantityEditor, unitPriceEditor, discountEditor, totalEditor) {

		var quantity = quantityEditor.numberbox('getValue');
    	var unit_price = unitPriceEditor.numberbox('getValue');
    	var discount = discountEditor.numberbox('getValue');

    	var beforeDiscountPrice = quantity * unit_price;

    	var afterDiscountPrice = beforeDiscountPrice - ( beforeDiscountPrice * discount / 100 );

    	totalEditor.textbox('setValue', afterDiscountPrice);


	}


</script>
