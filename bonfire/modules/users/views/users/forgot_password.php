<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
    	<center><img src="<?php echo base_url(); ?>assets/images/LogoSemar.png" width="150px"/></center>
    	<br/>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox-content">
                	<h2>Lupa Password</h2>

					<?php
						if (validation_errors()) :
					?>
					<div class="row-fluid">
						<div class="span12">
							<div class="alert alert-error fade in">
							  <a data-dismiss="alert" class="close">&times;</a>
								<?php echo validation_errors(); ?>
							</div>
						</div>
					</div>
					<?php endif; ?>

                    <?php echo form_open($this->uri->uri_string(), array('class' => "", 'autocomplete' => 'off')); ?>
                        <div class="form-group">
                        	<label class="control-label required" for="email"><?php echo lang('bf_email'); ?></label>
                        	<input class="span6 form-control" type="text" name="email" id="email" value="<?php echo set_value('email') ?>" />
                        </div>
                         
                        <button type="submit" name="send" class="btn btn-primary block m-b">Kirim Password</button>

                        <a href="<?php echo base_url(); ?>login">
                            <small>Login?</small>
                        </a>

                        
                    </form>
                     
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright SMTP-LIPI
            </div>
            <div class="col-md-6 text-right">
               <small>© 2017</small>
            </div>
        </div>
    </div>

</body>