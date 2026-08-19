<?php
$frontend = $this->uri->segment(1);
$mid = my_id();
if (!empty($mid) && $frontend != 'frontend') { ?>
    <div class="chat_frame">
        <?php include_once 'assets/plugins/chat/chat.php'; ?>
        <button type="button" class="btn btn-round custom-bg" id="open_chat_list" title="Drag to move chat button">
            <span class="fa fa-comments"></span>
        </button>
        <div class="panel b0" id="chat_list">
            <div class="panel-heading custom-bg" style="cursor: move; user-select: none;">
                <div class="">
                    <i class="fa fa-arrows text-muted" style="margin-right: 5px; font-size: 11px;" title="Drag to move"></i>
                    <?= lang('users') . ' ' . lang('list') ?>
                    <div class="pull-right chat-icon">
                        <i data-toggle="tooltip" data-placement="top" title="<?= lang('close') ?>" id="close_chat_list"
                           class="fa fa-times"
                           aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <!-- Search bar for chat users -->
            <div style="padding: 6px 8px; background: #f8fafc; border-bottom: 1px solid #edf2f7;">
                <div class="input-group input-group-sm">
                    <input type="text" id="chat_user_search_input" class="form-control" placeholder="Search contacts..." style="height: 28px; font-size: 12px; border-radius: 4px;">
                    <span class="input-group-addon" style="padding: 2px 8px; background: #fff;"><i class="fa fa-search text-muted"></i></span>
                </div>
            </div>
            <ul class="nav b bt0" id="chat_users_container" style="max-height: 380px; overflow-y: auto;">
                <li>
                    <?php
                    $users = $this->admin_model->get_online_users();
                    $total_users_count = 0;
                    if (!empty($users)) {
                        foreach ($users as $key => $v_users) {
                            if (!empty($v_users)) {
                                foreach ($v_users as $v_user) {
                                    $total_users_count++;
                                    $avatar = !empty($v_user->avatar) ? $v_user->avatar : 'assets/img/user/default_avatar.jpg';
                                    ?>
                                    <!-- START User status-->
                                    <a href="#" data-user_id="<?= $v_user->user_id ?>"
                                       class="media-box p pb-sm pt-sm bb mt0 start_chat chat-user-item">
                                        <?php if ($key == 'online') { ?>
                                            <span class="pull-right">
                                                <span class="circle circle-success circle-lg" title="Online"></span>
                                            </span>
                                        <?php } else { ?>
                                            <span class="pull-right">
                                                <span class="circle circle-warning circle-lg" title="Offline"></span>
                                            </span>
                                        <?php } ?>
                                        <span class="pull-left">
                                            <!-- Contact avatar-->
                                            <img src="<?= base_url($avatar) ?>"
                                                 onerror="this.src='<?= base_url('assets/img/user/default_avatar.jpg') ?>'"
                                                 alt="Image" class="media-box-object img-circle thumb48">
                                        </span>
                                        <!-- Contact info-->
                                        <span class="media-box-body">
                                            <span class="media-box-heading">
                                                <strong class="text-sm chat-user-name"><?= $v_user->fullname ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <span class="pull-left chat-user-role"><?= !empty($v_user->designations) ? $v_user->designations : 'Staff' ?></span>
                                                    <span class="pull-right"><?php
                                                        if (!empty($v_user->online_time)) {
                                                            echo time_ago($v_user->online_time);
                                                        } else {
                                                            echo lang('never');
                                                        } ?></span>
                                                </small>
                                            </span>
                                        </span>
                                    </a>
                                    <?php
                                }
                            }
                        }
                    }
                    if ($total_users_count === 0) { ?>
                        <div class="text-center p-sm text-muted" style="padding: 20px 10px;">
                            <i class="fa fa-users fa-2x" style="opacity: 0.5;"></i>
                            <p style="margin-top: 8px; font-size: 12px;">No contacts found</p>
                        </div>
                    <?php } ?>
                </li>
            </ul>
        </div>
        <div id="chat_box"></div>
        <audio id="chat-tune" controls="">
            <source src="<?= base_url() ?>assets/plugins/chat/chat_tune.mp3" type="audio/mpeg">
        </audio>
    </div><!--End live_chat_section-->
<?php } ?>
