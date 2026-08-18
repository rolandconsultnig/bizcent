<?= message_box('success'); ?>
<?= message_box('error'); ?>

<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title">
            <strong><i class="fa fa-video-camera"></i> <?= lang('scheduled_meetings') ?> & Virtual Teams Rooms</strong>
            <div class="pull-right">
                <a href="<?= base_url('admin/meetings/instant') ?>" class="btn btn-xs btn-success" style="margin-right: 5px;">
                    <i class="fa fa-bolt"></i> Meet Now (Instant)
                </a>
                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#scheduleMeetingModal">
                    <i class="fa fa-calendar-plus-o"></i> Schedule New Meeting
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="DataTables">
                <thead>
                <tr class="bg-gray-lighter">
                    <th>Meeting Code</th>
                    <th>Topic / Title</th>
                    <th>Host</th>
                    <th>Scheduled Time</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($meetings)): foreach ($meetings as $m): ?>
                    <tr>
                        <td><strong class="text-primary"><?= $m->meeting_code ?></strong></td>
                        <td>
                            <strong><?= $m->title ?></strong>
                            <?php if (!empty($m->description)): ?>
                                <br><small class="text-muted"><?= $m->description ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= $m->host_name ?: 'Admin' ?></td>
                        <td><?= display_datetime($m->start_time) ?></td>
                        <td><?= $m->duration_minutes ?> mins</td>
                        <td>
                            <?php
                            $s_cls = 'label-info';
                            if ($m->status == 'ongoing') $s_cls = 'label-success';
                            elseif ($m->status == 'ended') $s_cls = 'label-default';
                            ?>
                            <span class="label <?= $s_cls ?>"><?= strtoupper($m->status) ?></span>
                        </td>
                        <td>
                            <a target="_blank" href="<?= base_url('admin/meetings/room/' . $m->meeting_code) ?>" class="btn btn-success btn-xs" title="Join Meeting">
                                <i class="fa fa-video-camera"></i> Join Meeting
                            </a>
                            <button type="button" class="btn btn-default btn-xs copy-link-btn" data-link="<?= base_url('admin/meetings/room/' . $m->meeting_code) ?>" title="Copy Meeting Link">
                                <i class="fa fa-link"></i> Copy Link
                            </button>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="scheduleMeetingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="<?= base_url('admin/meetings/save_meeting') ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-calendar-plus-o"></i> Schedule Virtual Team Meeting</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Meeting Topic / Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" required placeholder="e.g. Q3 Strategic Planning & Budget Review" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Agenda / Description</label>
                        <textarea name="description" rows="2" placeholder="Meeting goals, talking points, preparation notes..." class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date <span class="text-danger">*</span></label>
                                <input type="text" name="start_date" class="form-control datepicker" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Time <span class="text-danger">*</span></label>
                                <input type="time" name="start_time" class="form-control" value="<?= date('H:i') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Duration</label>
                                <select name="duration_minutes" class="form-control">
                                    <option value="30">30 Minutes</option>
                                    <option value="45">45 Minutes</option>
                                    <option value="60" selected>1 Hour</option>
                                    <option value="90">1.5 Hours</option>
                                    <option value="120">2 Hours</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Passcode (Optional)</label>
                                <input type="text" name="passcode" placeholder="Leave empty for public join" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-calendar-check-o"></i> Schedule & Generate Link</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.copy-link-btn').click(function() {
        var link = $(this).data('link');
        navigator.clipboard.writeText(link).then(function() {
            alert('Meeting link copied to clipboard:\n' + link);
        });
    });
});
</script>
