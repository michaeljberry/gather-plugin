<main class="container-fluid mt-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>Sets the Formidable Form IDs</h4>
                    <?php settings_errors(); ?>
                </div>
                <div>
                    <a href="<?php echo $this->gather_plugin_url . '/assets/default-formidable-template.xml'; ?>" class="btn btn-outline-primary" target="_blank"><i class="fa fa-download"></i> Download Default Formidable Forms</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="card mt-3">
                <form action="options.php" method="post">
                    <div class="form-group mb-3">
                        <?php settings_fields('gather_options_group'); ?>
                        <label for="gc_classified_categories_form_id" class="form-label">Classified Categories Form ID</label>
                        <input type="number" name="gc_classified_categories_form_id" id="gc_classified_categories_form_id" class="form-control" value="<?php echo esc_attr( get_option( 'gc_classified_categories_form_id' ) ); ?>" />
                    </div>
                    <div class="form-group mb-3">
                        <?php settings_fields('gather_options_group'); ?>
                        <label for="gc_announcement_notification_id" class="form-label">Notifications ID</label>
                        <input type="number" name="gc_announcement_notification_id" id="gc_announcement_notification_id" class="form-control" value="<?php echo esc_attr( get_option( 'gc_announcement_notification_id' ) ); ?>" />
                        <div class="form-text">Anouncement Notification w/o Number Indicator</div>
                    </div>
                    <div class="form-group mb-3">
                        <?php settings_fields('gather_options_group'); ?>
                        <label for="gc_active_announcement_id" class="form-label">Active Notifications ID</label>
                        <input type="number" name="gc_active_announcement_id" id="gc_active_announcement_id" class="form-control" value="<?php echo esc_attr( get_option( 'gc_active_announcement_id' ) ); ?>" />
                    </div>
                    <div class="form-group mb-3">
                        <?php settings_fields('gather_options_group'); ?>
                        <label for="gc_announcement_approve_id" class="form-label">Announcement Approved Field ID</label>
                        <input type="number" name="gc_announcement_approve_id" id="gc_announcement_approve_id" class="form-control" value="<?php echo esc_attr( get_option( 'gc_announcement_approve_id' ) ); ?>" />
                    </div>
                    <div class="form-group mb-3">
                        <?php settings_fields('gather_options_group'); ?>
                        <label for="gc_official_announcement_field_id" class="form-label">Official Announcement Field ID</label>
                        <input type="number" name="gc_official_announcement_field_id" id="gc_official_announcement_field_id" class="form-control" value="<?php echo esc_attr( get_option( 'gc_official_announcement_field_id' ) ); ?>" />
                    </div>
                    <div class="form-group mb-3">
                        <?php settings_fields('gather_options_group'); ?>
                        <label for="gc_active_polls_view_id" class="form-label">Active Polls View ID</label>
                        <input type="number" name="gc_active_polls_view_id" id="gc_active_polls_view_id" class="form-control" value="<?php echo esc_attr( get_option( 'gc_active_polls_view_id' ) ); ?>" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>