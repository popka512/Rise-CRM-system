<?php if ($embedded) { ?>
    <style type="text/css">
        .post-file-previews {
            border:none !important;
        }
        .client-info-section  .form-group {
            margin:25px 15px
        }
        #page-content.page-wrapper{
            padding: 10px !important
        }
        #content{
            margin-top: 15px !important
        }
    </style> 
<?php } else { ?>
    <style type="text/css">
        .post-file-previews {
            border:none !important;
        }
        .client-info-section  .form-group {
            margin:25px 15px
        }
    </style>
<?php } ?>

<div id="page-content" class="page-wrapper clearfix">
    <div id="estimate-form-container">
        <?php
        echo form_open(get_uri("request_estimate/save_estimate_request"), array("id" => "estimate-request-form", "class" => "general-form", "role" => "form"));
        echo "<input type='hidden' name='form_id' value='$model_info->id' />";
        echo "<input type='hidden' name='assigned_to' value='$model_info->assigned_to' />";
        ?>

        <div id="estimate-form-preview" class="card  p15 no-border clearfix post-dropzone" style="max-width: 1000px; margin: auto;">

            <h3 id="estimate-form-title" class=" pl10 pr10"> <?php echo $model_info->title; ?></h3>

            <div class="pl10 pr10"><?php echo nl2br($model_info->description ? $model_info->description : ""); ?></div>
            <div class=" pt10 mt15">
  
                <!-- CLIENT FIELDS -->
                

                <div class="table-responsive general-form ">
                    <table id="estimate-form-table" class="display b-t no-thead b-b-only no-hover" cellspacing="0" width="100%">            
                    </table>
                </div>
            </div>

            
            <?php if ($model_info->enable_attachment) { ?>
                <div class="clearfix pl10 pr10 b-b">
                    <?php echo view("includes/dropzone_preview"); ?>    
                </div>
            <?php } ?>
            <div class="p15"> 
                <?php if ($model_info->enable_attachment) { ?>
                    <button class="btn btn-default upload-file-button mr15 round" type="button" style="color:#7988a2"><i data-feather='camera' class='icon-16'></i> <?php echo app_lang("upload_file"); ?></button>
                <?php } ?>
                <button type="submit" class="btn btn-primary"><i data-feather="send" class="icon-16"></i> <?php echo app_lang('request_an_estimate'); ?></button>
            </div>
        </div>

        <?php
        echo form_close();
        ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#estimate-form-table").appTable({
            source: '<?php echo_uri("request_estimate/estimate_form_filed_list_data/" . $model_info->id) ?>',
            order: [[1, "asc"]],
            hideTools: true,
            displayLength: 100,
            columns: [
                {title: "<?php echo app_lang("title") ?>"},
                {visible: false},
                {visible: false}
            ],
            onInitComplete: function () {
                $(".dataTables_empty").hide();
            }
        });
        var enable_attachment = "<?php echo $model_info->enable_attachment; ?>";

        if (enable_attachment === "1") {

            var uploadUrl = "<?php echo get_uri("request_estimate/upload_file"); ?>";
            console.log(uploadUrl)
            var validationUrl = "<?php echo get_uri("request_estimate/validate_file"); ?>";
            var dropzone = attachDropzoneWithForm("#estimate-form-preview", uploadUrl, validationUrl);
        }
    });


    $("#estimate-request-form").appForm({
        isModal: false,
        onSubmit: function () {
            appLoader.show();
            $("#estimate-request-form").find('[type="submit"]').attr('disabled', 'disabled');
        },
        onSuccess: function (result) {
            appLoader.hide();
            $("#estimate-form-container").html("");
            appAlert.success(result.message, {container: "#estimate-form-container", animate: false});
            $('.scrollable-page').scrollTop(0); //scroll to top
        }
    });
</script>