<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-ui/themes/smoothness/jquery-ui.min.css'); ?>">
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/elFinder/css/elfinder.min.css'); ?>">
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/elFinder/themes/Material/css/theme.css'); ?>">
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/elFinder/themes/Material/css/theme-light.css'); ?>">

<div class="panel panel-custom">
    <div class="panel-heading">
        <div class="panel-title"><?= lang('filemanager') ?></div>
    </div>
    <div>
        <div id="elfinder"></div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/plugins/elFinder/js/elfinder.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script>
    $(function () {
        if (typeof $.fn.elfinder !== 'function') {
            return;
        }
        $('#elfinder').elfinder({
            url: <?= json_encode($connector) ?>,
            lang: 'en',
            height: 700,
            ui: ['toolbar', 'tree', 'path', 'stat'],
            contextmenu: {
                files: [
                    'getfile', '|', 'open', 'quicklook', '|', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|',
                    'rm', '|', 'edit', 'rename', '|', 'archive', 'extract'
                ]
            },
            uiOptions: {
                toolbar: [
                    ['back', 'forward'],
                    ['mkdir', 'mkfile', 'upload'],
                    ['open', 'download', 'getfile'],
                    ['quicklook'],
                    ['copy', 'paste'],
                    ['rm'],
                    ['duplicate', 'rename', 'edit'],
                    ['extract', 'archive'],
                    ['search'],
                    ['view'],
                    ['info']
                ]
            }
        });
    });
</script>
