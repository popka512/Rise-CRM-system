<?php echo form_open(get_uri("offer/accept_proposal"), array("id" => "accept-proposal-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div  class="container-fluid">
    <div id="estimate-form-preview-new" class="card  p15 no-border clearfix post-dropzone" style="max-width: 1000px; margin: auto;">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" name="public_key" value="<?php echo $model_info->public_key; ?>" />

        <?php if ($show_info_fields) { ?>
            <div class="form-group">
                <div class="row">
                    <label for="name" class=" col-md-3"><?php echo app_lang('name'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "name",
                            "name" => "name",
                            "class" => "form-control",
                            "placeholder" => app_lang('name'),
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="email" class="col-md-3"><?php echo app_lang('email'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "email",
                            "name" => "email",
                            "class" => "form-control",
                            "placeholder" => app_lang('email'),
                            "data-rule-email" => true,
                            "data-msg-email" => app_lang("enter_valid_email"),
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="id_number" class="col-md-3">DNI/NIF</label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "id_number",
                            "name" => "id_number",
                            "class" => "form-control",
                            "placeholder" => "DNI/NIF",
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            
        <?php } ?>

        <?php if (get_setting("add_signature_option_on_accepting_proposal")) { ?>
            <div class="form-group">
                <div class="row">
                    <label for="signature" class="col-md-3"><?php echo app_lang('signature'); ?></label>
                    <div class="col-md-9">
                        <div id="signature">
                            <canvas class="b-a" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($enable_attachment) { ?>
                <div class="clearfix pl10 pr10 b-b">
                    <?php echo view("includes/dropzone_preview"); ?>    
                </div>
            <?php } ?>
        <button class="btn btn-default upload-file-button float-start me-auto btn-sm round" type="button" style="color:#7988a2; font-size: 16px;"><i data-feather="upload" class="icon-16"></i> <?php echo app_lang("upload_file"); ?></button>
    </div>
    </div>
</div>
<!-- enjoy-start -->
            

            
            <!-- enjoy-end -->
<div class="modal-footer">
    
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('accept'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#accept-proposal-form").appForm({
            onSuccess: function (result) {
                if (result.success) {
                    appAlert.success(result.message, {duration: 10000});
                    location.reload();
                } else {
                    appAlert.error(result.message);
                }
            }
        });
        $("#name").focus();

        initSignature("signature", {
            required: true,
            requiredMessage: "<?php echo app_lang("field_required"); ?>"
        });
        //enjoy-start
        var enable_attachment = "<?php echo $enable_attachment; ?>";
        console.log(enable_attachment)
        if (enable_attachment == "1") {

            var uploadUrl = "<?php echo get_uri("offer/upload_file"); ?>";
            var validationUrl = "<?php echo get_uri("offer/validate_file"); ?>";
            console.log(uploadUrl)
            var dropzone = attachDropzoneWithForm("#estimate-form-preview-new", uploadUrl, validationUrl);

        }
        // enjoy-end
        
    });
</script>