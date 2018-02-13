<script src="<?php echo base_url(); ?>themes/admin/js/sweetalert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>themes/admin/css/sweetalert.css">


<?php
$id = isset($sppd->id) ? $sppd->id : '';

?>
<div class='box box-primary' id="form-laporan">
    <div class="box-body">
    <div class='messages'>
    
    </div>
    <?php echo form_open($this->uri->uri_string(), 'id="frm"'); ?>
    	<input id='id' type='hidden' class="form-control" name='id' maxlength='32' value="<?php echo set_value('id', isset($sppd->id) ? trim($sppd->id) : ''); ?>" />
        <fieldset>
            
            <div class="control-group<?php echo form_error('content') ? ' error' : ''; ?>">
                <div class='controls'>
                	<textarea  id='laporan_perjalanan_text' name="laporan_perjalanan_text" class='laporan_perjalanan_text form-control'><?php echo isset($sppd->laporan_perjalanan_text) ? $sppd->laporan_perjalanan_text : ''; ?></textarea>
                    <span class='help-inline'><?php echo form_error('laporan_perjalanan_text'); ?></span>
                </div>
            </div>

             
        </fieldset>
        </div>
        <div class="box-footer">
            <input type='submit' name='save' id="btnsave" class='btn btn-primary' value="Simpan Laporan" />
            <a href="<?php echo base_url(); ?>admin/kepegawaian/sppd/printlaporan/<?php echo $id; ?>" target="_blank"><span class="btn btn-warning label-warning"><i class="fa fa-print"></i> Cetak Laporan</span></a>
        </div>
    <?php echo form_close(); ?>
</div>
<script src="<?php echo base_url(); ?>themes/admin/dist/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>themes/admin/dist/js/speakingurl.min.js" type="text/javascript"></script>
<script>
 function textEditor(selector,tinggi){
              tinggi= typeof tinggi!=='undefined'?tinggi:200
                  tinymce.init({
                      style_formats: [
                          {
                              title: 'Image Left',
                              selector: 'img',
                              styles: {
                                  'float': 'left', 
                                  'margin': '0 10px 0 10px'
                              }
                           },
                           {
                               title: 'Image Right',
                               selector: 'img', 
                               styles: {
                                   'float': 'right', 
                                   'margin': '0 0 10px 10px'
                               }
                           }
                      ],
                      element_format : "html",
                      entities:"38,amp,60,lt,62,gt",
                      entity_encoding:"raw",
                      encoding: "xml",
                      relative_urls: false,
                      remove_script_host : false,
                      selector: selector,
                      theme: "modern",
                      skin: "lightgray",
                      menubar: false,
                      height:tinggi,
                      plugins: [
                          " autolink lists link hr anchor pagebreak",
                          "searchreplace wordcount visualblocks visualchars code fullscreen"
                      ],
                      toolbar1: "code fullscreen insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | link image responsivefilemanager ",
                      //toolbar2: "forecolor backcolor emoticons | codesample",
                      //filemanager_title:"Filemanager" ,
                     // filemanager_access_key:"mqahvhrqzt",
                      setup: function (editor) {
                          editor.on('init', function(args) {
                              editor = args.target;

                              editor.on('NodeChange', function(e) {
                                  if (e && e.element.nodeName.toLowerCase() == 'img') {
                                      tinymce.DOM.setAttribs(e.element, {'width': null, 'height': null});
                                  }
                              });
                          });
                      }
                  });


           }
   textEditor(".laporan_perjalanan_text");
   	 
</script>
<script>
	$("#btnsave").click(function(){
		submitdata();
		return false; 
	});	
	$("#frm").submit(function(){
		submitdata();
		return false; 
	});	
	function submitdata(){
		//alert($("#frm").serialize());
    tinyMCE.triggerSave();
		
		var json_url = "<?php echo base_url() ?>admin/kepegawaian/sppd/savelaporan";
		 $.ajax({    
		 	type: "POST",
			url: json_url,
			data: $("#frm").serialize(),
            dataType: "json",
			success: function(data){ 
                if(data.success){
                    swal("Pemberitahuan!", data.msg, "success");
                    $("#modal-custom-global").trigger("Sukses tambah laporan");
					$("#modal-custom-global").modal("hide");
                }
                else {
                    $("#form-laporan .messages").empty().append(data.msg);
                }
			}});
		return false; 
	}
</script>