<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ree-Social | Workplace Collaboration Network</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome/css/font-awesome.min.css') ?>">
    <script src="<?= base_url('assets/plugins/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <style>
        :root {
            --x-bg: #000000;
            --x-card-bg: #16181c;
            --x-border: #2f3336;
            --x-text-primary: #e7e9ea;
            --x-text-secondary: #71767b;
            --x-blue: #1d9bf0;
            --x-blue-hover: #1a8cd8;
            --x-hover-bg: #080808;
            --x-active-tab: #ffffff;
            --x-input-bg: #202327;
        }

        [data-theme="dim"] {
            --x-bg: #15202b;
            --x-card-bg: #1e2732;
            --x-border: #38444d;
            --x-text-primary: #f7f9fa;
            --x-text-secondary: #8b98a5;
            --x-blue: #1d9bf0;
            --x-blue-hover: #1a8cd8;
            --x-hover-bg: #1c2732;
            --x-active-tab: #ffffff;
            --x-input-bg: #273340;
        }

        [data-theme="light"] {
            --x-bg: #ffffff;
            --x-card-bg: #f7f9f9;
            --x-border: #eff3f4;
            --x-text-primary: #0f1419;
            --x-text-secondary: #536471;
            --x-blue: #1d9bf0;
            --x-blue-hover: #1a8cd8;
            --x-hover-bg: #f7f9f9;
            --x-active-tab: #0f1419;
            --x-input-bg: #eff3f4;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--x-bg);
            color: var(--x-text-primary);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
        }

        .x-wrapper {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            min-height: 100vh;
        }

        /* 1. LEFT RAIL */
        .x-left-rail {
            width: 275px;
            padding: 12px 16px 20px 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: sticky;
            top: 0;
            height: 100vh;
            border-right: 1px solid var(--x-border);
        }
        .x-logo-btn {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--x-text-primary);
            font-size: 26px;
            text-decoration: none;
            transition: background 0.2s;
            margin-bottom: 8px;
        }
        .x-logo-btn:hover {
            background: var(--x-hover-bg);
            color: var(--x-text-primary);
        }
        .x-nav-menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .x-nav-item {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 12px 18px;
            border-radius: 9999px;
            color: var(--x-text-primary);
            font-size: 19px;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.15s;
            width: fit-content;
        }
        .x-nav-item:hover {
            background-color: var(--x-hover-bg);
            color: var(--x-text-primary);
            text-decoration: none;
        }
        .x-nav-item.active {
            font-weight: 800;
        }
        .x-nav-item i {
            font-size: 22px;
            width: 26px;
            text-align: center;
        }
        .x-post-big-btn {
            background: var(--x-blue);
            color: #ffffff;
            font-weight: 700;
            font-size: 17px;
            border: none;
            border-radius: 9999px;
            padding: 14px 0;
            width: 90%;
            margin-top: 16px;
            box-shadow: 0 8px 24px rgba(29, 155, 240, 0.3);
            cursor: pointer;
            transition: background 0.2s;
            text-align: center;
            display: block;
        }
        .x-post-big-btn:hover {
            background: var(--x-blue-hover);
            color: #ffffff;
            text-decoration: none;
        }
        .x-user-pill {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: 9999px;
            cursor: pointer;
            transition: background 0.15s;
            text-decoration: none;
            color: var(--x-text-primary);
        }
        .x-user-pill:hover {
            background: var(--x-hover-bg);
            color: var(--x-text-primary);
            text-decoration: none;
        }

        /* 2. CENTER TIMELINE */
        .x-center-feed {
            flex: 1;
            max-width: 620px;
            border-right: 1px solid var(--x-border);
            min-height: 100vh;
        }
        .x-sticky-header {
            position: sticky;
            top: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(12px);
            z-index: 20;
            border-bottom: 1px solid var(--x-border);
        }
        [data-theme="dim"] .x-sticky-header {
            background: rgba(21, 32, 43, 0.75);
        }
        [data-theme="light"] .x-sticky-header {
            background: rgba(255, 255, 255, 0.85);
        }
        .x-top-tabs {
            display: flex;
        }
        .x-top-tab {
            flex: 1;
            text-align: center;
            padding: 15px 0;
            font-weight: 600;
            font-size: 15px;
            color: var(--x-text-secondary);
            text-decoration: none;
            position: relative;
        }
        .x-top-tab.active {
            color: var(--x-active-tab);
            font-weight: 700;
        }
        .x-top-tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 54px;
            height: 4px;
            background: var(--x-blue);
            border-radius: 9999px;
        }
        .x-top-tab:hover {
            background: var(--x-hover-bg);
            text-decoration: none;
        }

        /* Compose Box */
        .x-compose {
            padding: 16px 20px;
            border-bottom: 1px solid var(--x-border);
            display: flex;
            gap: 14px;
        }
        .x-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--x-blue);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            flex-shrink: 0;
        }
        .x-compose-body {
            flex: 1;
        }
        .x-compose-input {
            width: 100%;
            background: transparent;
            border: none;
            resize: none;
            font-size: 18px;
            color: var(--x-text-primary);
            outline: none;
            min-height: 60px;
            font-family: inherit;
        }
        .x-compose-input::placeholder {
            color: var(--x-text-secondary);
        }
        .x-compose-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 12px;
            border-top: 1px solid var(--x-border);
            margin-top: 8px;
        }
        .x-action-icons {
            display: flex;
            gap: 10px;
            color: var(--x-blue);
            font-size: 16px;
        }
        .x-icon-btn {
            cursor: pointer;
            padding: 6px;
            border-radius: 50%;
            transition: background 0.15s;
        }
        .x-icon-btn:hover {
            background: rgba(29, 155, 240, 0.15);
        }
        .x-post-small-btn {
            background: var(--x-blue);
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .x-post-small-btn:hover {
            background: var(--x-blue-hover);
        }

        /* Post Card */
        .x-tweet {
            padding: 14px 20px;
            border-bottom: 1px solid var(--x-border);
            display: flex;
            gap: 12px;
            transition: background 0.15s;
        }
        .x-tweet:hover {
            background: var(--x-hover-bg);
        }
        .x-tweet-content {
            flex: 1;
        }
        .x-tweet-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .x-name {
            font-weight: 700;
            color: var(--x-text-primary);
            font-size: 15px;
            text-decoration: none;
        }
        .x-name:hover {
            text-decoration: underline;
        }
        .x-handle {
            color: var(--x-text-secondary);
            font-size: 14px;
            margin-left: 4px;
        }
        .x-dot {
            color: var(--x-text-secondary);
            margin: 0 4px;
        }
        .x-time {
            color: var(--x-text-secondary);
            font-size: 14px;
        }
        .x-tweet-text {
            font-size: 15px;
            line-height: 1.45;
            color: var(--x-text-primary);
            white-space: pre-wrap;
            word-break: break-word;
        }
        .x-tag {
            color: var(--x-blue);
            text-decoration: none;
            font-weight: 500;
        }
        .x-tag:hover {
            text-decoration: underline;
        }
        .x-tweet-metrics {
            display: flex;
            justify-content: space-between;
            max-width: 450px;
            margin-top: 12px;
            color: var(--x-text-secondary);
            font-size: 13px;
        }
        .x-metric-item {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: color 0.15s;
            border: none;
            background: none;
            padding: 0;
            color: var(--x-text-secondary);
        }
        .x-metric-item:hover {
            color: var(--x-blue);
        }
        .x-metric-item.liked {
            color: #f91880;
        }
        .x-metric-item.reposted {
            color: #00ba7c;
        }
        .x-metric-item.bookmarked {
            color: var(--x-blue);
        }

        /* Poll box */
        .x-poll-box {
            margin: 12px 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .x-poll-option {
            background: var(--x-card-bg);
            border: 1px solid var(--x-border);
            border-radius: 8px;
            padding: 10px 14px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            font-size: 14px;
            transition: border 0.15s;
        }
        .x-poll-option:hover {
            border-color: var(--x-blue);
        }
        .x-poll-progress {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: rgba(29, 155, 240, 0.2);
            z-index: 1;
        }
        .x-poll-label {
            position: relative;
            z-index: 2;
        }

        /* 3. RIGHT SIDEBAR */
        .x-right-sidebar {
            width: 350px;
            padding: 12px 24px 20px 24px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .x-search-bar {
            background: var(--x-input-bg);
            border-radius: 9999px;
            padding: 10px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--x-text-secondary);
            margin-bottom: 16px;
        }
        .x-search-bar input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--x-text-primary);
            width: 100%;
            font-size: 14px;
        }
        .x-side-card {
            background: var(--x-card-bg);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 16px;
            border: 1px solid var(--x-border);
        }
        .x-side-header {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 14px;
            color: var(--x-text-primary);
        }
        .x-trend-row {
            padding: 8px 0;
            border-bottom: 1px solid var(--x-border);
        }
        .x-trend-row:last-child {
            border-bottom: none;
        }
        .x-trend-meta {
            font-size: 12px;
            color: var(--x-text-secondary);
        }
        .x-trend-title {
            font-weight: 700;
            font-size: 14px;
            color: var(--x-text-primary);
            text-decoration: none;
        }
        .x-trend-title:hover {
            text-decoration: underline;
        }
        .x-follow-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--x-border);
        }
        .x-follow-row:last-child {
            border-bottom: none;
        }
        .x-follow-btn {
            background: var(--x-text-primary);
            color: var(--x-bg);
            font-weight: 700;
            font-size: 13px;
            padding: 6px 16px;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
        }
        .x-follow-btn:hover {
            opacity: 0.85;
        }
        .x-theme-btn {
            padding: 6px 12px;
            border-radius: 9999px;
            border: 1px solid var(--x-border);
            background: transparent;
            color: var(--x-text-primary);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            margin-right: 4px;
        }
        .x-theme-btn.active {
            border-color: var(--x-blue);
            color: var(--x-blue);
        }
    </style>
</head>
<body>

<div class="x-wrapper">
    <!-- ==================== 1. LEFT NAVIGATION ==================== -->
    <div class="x-left-rail">
        <div>
            <!-- Ree-Social Brand Logo -->
            <a href="<?= base_url('ree-social') ?>" style="display: flex; align-items: center; gap: 10px; text-decoration: none; margin-bottom: 16px; padding: 4px 8px; color: var(--x-text-primary);">
                <div style="background: linear-gradient(135deg, #1d9bf0, #7928ca); width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 900; font-size: 20px; box-shadow: 0 4px 12px rgba(29,155,240,0.4);">
                    R
                </div>
                <span style="font-weight: 800; font-size: 20px; letter-spacing: -0.5px;">Ree-Social</span>
            </a>

            <!-- Menu Links -->
            <div class="x-nav-menu">
                <a href="<?= base_url('x') ?>" class="x-nav-item <?= ($page == 'home') ? 'active' : '' ?>">
                    <i class="fa fa-home"></i> <span>Home</span>
                </a>
                <a href="<?= base_url('x/explore') ?>" class="x-nav-item <?= ($page == 'explore') ? 'active' : '' ?>">
                    <i class="fa fa-search"></i> <span>Explore</span>
                </a>
                <a href="<?= base_url('x/notifications') ?>" class="x-nav-item <?= ($page == 'notifications') ? 'active' : '' ?>">
                    <i class="fa fa-bell-o"></i> <span>Notifications</span>
                </a>
                <a href="<?= base_url('x/messages') ?>" class="x-nav-item <?= ($page == 'messages') ? 'active' : '' ?>">
                    <i class="fa fa-envelope-o"></i> <span>Messages</span>
                </a>
                <a href="<?= base_url('x/bookmarks') ?>" class="x-nav-item <?= ($page == 'bookmarks') ? 'active' : '' ?>">
                    <i class="fa fa-bookmark-o"></i> <span>Bookmarks</span>
                </a>
                <a href="<?= base_url('x/profile/' . $current_user->user_id) ?>" class="x-nav-item <?= ($page == 'profile') ? 'active' : '' ?>">
                    <i class="fa fa-user-o"></i> <span>Profile</span>
                </a>
                <a href="<?= base_url('admin/dashboard') ?>" class="x-nav-item" style="color: #27c24c;">
                    <i class="fa fa-th-large"></i> <span>ERP Center</span>
                </a>
            </div>

            <!-- Post Button -->
            <button type="button" class="x-post-big-btn" onclick="$('.x-compose-input').focus();">Post</button>
        </div>

        <!-- Current User Pill -->
        <a href="<?= base_url('x/profile/' . $current_user->user_id) ?>" class="x-user-pill">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div class="x-avatar" style="width: 38px; height: 38px; font-size: 15px; background: #<?= substr(md5($current_user->username), 0, 6) ?>;">
                    <?= strtoupper(substr($current_user->fullname ?: $current_user->username, 0, 1)) ?>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 14px;"><?= $current_user->fullname ?: $current_user->username ?></div>
                    <div style="font-size: 13px; color: var(--x-text-secondary);">@<?= $current_user->username ?></div>
                </div>
            </div>
            <i class="fa fa-ellipsis-h" style="color: var(--x-text-secondary);"></i>
        </a>
    </div>

    <!-- ==================== 2. CENTER FEED / CONTENT ==================== -->
    <div class="x-center-feed">
        <?php if ($page == 'home'): ?>
            <!-- Sticky Header -->
            <div class="x-sticky-header">
                <div class="x-top-tabs">
                    <a href="<?= base_url('x?tab=for_you') ?>" class="x-top-tab <?= ($tab == 'for_you' && empty($tag)) ? 'active' : '' ?>">For you</a>
                    <a href="<?= base_url('x?tab=following') ?>" class="x-top-tab <?= ($tab == 'following') ? 'active' : '' ?>">Following</a>
                </div>
            </div>

            <!-- Compose Post Box -->
            <div class="x-compose">
                <div class="x-avatar">
                    <?= strtoupper(substr($current_user->fullname ?: $current_user->username, 0, 1)) ?>
                </div>
                <div class="x-compose-body">
                    <form method="post" action="<?= base_url('x/create_post') ?>" enctype="multipart/form-data">
                        <textarea name="content" class="x-compose-input" placeholder="What is happening?!" required></textarea>
                        
                        <!-- Poll Inputs Drawer (Hidden by default) -->
                        <div id="poll_drawer" style="display: none; background: var(--x-card-bg); padding: 12px; border-radius: 12px; margin: 8px 0; border: 1px solid var(--x-border);">
                            <div style="font-weight: 700; font-size: 13px; margin-bottom: 6px; color: var(--x-blue);"><i class="fa fa-bar-chart"></i> Create a Poll</div>
                            <input type="text" name="poll_opt1" placeholder="Choice 1" class="form-control input-sm" style="background: var(--x-bg); border-color: var(--x-border); color: var(--x-text-primary); margin-bottom: 6px;">
                            <input type="text" name="poll_opt2" placeholder="Choice 2" class="form-control input-sm" style="background: var(--x-bg); border-color: var(--x-border); color: var(--x-text-primary); margin-bottom: 6px;">
                            <input type="text" name="poll_opt3" placeholder="Choice 3 (optional)" class="form-control input-sm" style="background: var(--x-bg); border-color: var(--x-border); color: var(--x-text-primary); margin-bottom: 6px;">
                            <input type="text" name="poll_opt4" placeholder="Choice 4 (optional)" class="form-control input-sm" style="background: var(--x-bg); border-color: var(--x-border); color: var(--x-text-primary);">
                        </div>

                        <div id="media_preview_tag" style="font-size: 12px; color: var(--x-blue); margin-top: 4px;"></div>

                        <div class="x-compose-footer">
                            <div class="x-action-icons">
                                <label class="x-icon-btn" title="Add Media/Photo" style="margin-bottom:0;">
                                    <i class="fa fa-picture-o"></i>
                                    <input type="file" name="media" accept="image/*" style="display:none;" onchange="previewMediaFile(this)">
                                </label>
                                <span class="x-icon-btn" title="Create Poll" onclick="$('#poll_drawer').slideToggle(150);"><i class="fa fa-bar-chart"></i></span>
                                <span class="x-icon-btn" title="Add Emoji" onclick="insertEmoji('🚀 ')"><i class="fa fa-smile-o"></i></span>
                                <span class="x-icon-btn" title="Hashtag" onclick="insertTag('#')"><i class="fa fa-hashtag"></i></span>
                            </div>
                            <button type="submit" class="x-post-small-btn">Post</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Post Stream -->
            <div class="x-stream">
                <?php if (!empty($posts)): foreach ($posts as $p): ?>
                    <?= render_x_tweet($p, $current_user->user_id, $user_likes, $user_bookmarks); ?>
                <?php endforeach; else: ?>
                    <div style="padding: 40px 20px; text-align: center; color: var(--x-text-secondary);">
                        <i class="fa fa-twitter fa-3x" style="color: var(--x-border); margin-bottom: 12px;"></i>
                        <h4>Welcome to your X Timeline</h4>
                        <p>Follow colleagues and post updates to get started!</p>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif ($page == 'explore'): ?>
            <!-- Explore View -->
            <div class="x-sticky-header" style="padding: 12px 16px;">
                <div class="x-search-bar" style="margin-bottom: 0;">
                    <i class="fa fa-search"></i>
                    <form method="get" action="<?= base_url('x/explore') ?>" style="width: 100%;">
                        <input type="text" name="q" placeholder="Search X / RolandERP..." value="<?= htmlspecialchars($q ?? '') ?>">
                    </form>
                </div>
            </div>
            <div class="x-stream">
                <?php if (!empty($posts)): foreach ($posts as $p): ?>
                    <?= render_x_tweet($p, $current_user->user_id, $user_likes, $user_bookmarks); ?>
                <?php endforeach; else: ?>
                    <div style="padding: 40px 20px; text-align: center; color: var(--x-text-secondary);">
                        <h4>No search results found</h4>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif ($page == 'notifications'): ?>
            <!-- Notifications View -->
            <div class="x-sticky-header" style="padding: 14px 18px;">
                <h4 style="margin: 0; font-weight: 800; font-size: 20px;">Notifications</h4>
            </div>
            <div class="x-stream">
                <?php if (!empty($notifications)): foreach ($notifications as $n): ?>
                    <div class="x-tweet">
                        <div style="font-size: 20px; color: var(--x-blue); width: 44px; text-align: right; margin-right: 8px;">
                            <?php if ($n->type == 'like'): ?>
                                <i class="fa fa-heart text-danger"></i>
                            <?php elseif ($n->type == 'reply'): ?>
                                <i class="fa fa-comment text-primary"></i>
                            <?php else: ?>
                                <i class="fa fa-user-plus text-success"></i>
                            <?php endif; ?>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 15px;"><?= $n->fullname ?: $n->username ?></div>
                            <div style="color: var(--x-text-secondary); font-size: 14px;">
                                <?php if ($n->type == 'like'): ?>
                                    liked your post.
                                <?php elseif ($n->type == 'reply'): ?>
                                    replied to your post.
                                <?php else: ?>
                                    started following you.
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div style="padding: 40px 20px; text-align: center; color: var(--x-text-secondary);">
                        <h4>You have no notifications yet</h4>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif ($page == 'messages'): ?>
            <!-- Direct Messages View -->
            <div class="x-sticky-header" style="padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0; font-weight: 800; font-size: 20px;">Messages</h4>
                <div class="dropdown">
                    <button class="btn btn-xs btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="border-radius: 9999px;">
                        <i class="fa fa-plus"></i> New Message
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" style="background: var(--x-card-bg); border-color: var(--x-border);">
                        <?php if (!empty($all_colleagues)): foreach ($all_colleagues as $c): ?>
                            <li><a href="<?= base_url('x/messages/' . $c->user_id) ?>" style="color: var(--x-text-primary);"><?= $c->fullname ?: $c->username ?> (@<?= $c->username ?>)</a></li>
                        <?php endforeach; endif; ?>
                    </ul>
                </div>
            </div>
            <div style="display: flex; height: calc(100vh - 53px);">
                <!-- Conversations List -->
                <div style="width: 40%; border-right: 1px solid var(--x-border); overflow-y: auto;">
                    <?php if (!empty($conversations)): foreach ($conversations as $conv): ?>
                        <a href="<?= base_url('x/messages/' . $conv->user_id) ?>" class="x-tweet" style="text-decoration: none; color: inherit; <?= (!empty($active_partner) && $active_partner->user_id == $conv->user_id) ? 'background: var(--x-hover-bg);' : '' ?>">
                            <div class="x-avatar" style="width: 38px; height: 38px; font-size: 14px;">
                                <?= strtoupper(substr($conv->fullname ?: $conv->username, 0, 1)) ?>
                            </div>
                            <div style="flex: 1; overflow: hidden;">
                                <div style="font-weight: 700; font-size: 14px;"><?= $conv->fullname ?: $conv->username ?></div>
                                <div style="font-size: 12px; color: var(--x-text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= $conv->last_message ?: 'Start chatting' ?></div>
                            </div>
                        </a>
                    <?php endforeach; else: ?>
                        <div style="padding: 20px; text-align: center; color: var(--x-text-secondary); font-size: 13px;">No conversations yet.</div>
                    <?php endif; ?>
                </div>

                <!-- Chat Box -->
                <div style="width: 60%; display: flex; flex-direction: column;">
                    <?php if (!empty($active_partner)): ?>
                        <div style="padding: 12px 16px; border-bottom: 1px solid var(--x-border); font-weight: 700;">
                            <?= $active_partner->fullname ?: $active_partner->username ?> <small style="color: var(--x-text-secondary);">@<?= $active_partner->username ?></small>
                        </div>
                        <div style="flex: 1; padding: 16px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px;">
                            <?php if (!empty($chat_messages)): foreach ($chat_messages as $m): ?>
                                <div style="max-width: 75%; padding: 10px 14px; border-radius: 16px; font-size: 14px; <?= ($m->sender_id == $current_user->user_id) ? 'background: var(--x-blue); color: #fff; align-self: flex-end; border-bottom-right-radius: 2px;' : 'background: var(--x-card-bg); color: var(--x-text-primary); align-self: flex-start; border-bottom-left-radius: 2px; border: 1px solid var(--x-border);' ?>">
                                    <?= htmlspecialchars($m->message) ?>
                                    <div style="font-size: 10px; opacity: 0.75; text-align: right; margin-top: 4px;"><?= date('g:i A', strtotime($m->created_at)) ?></div>
                                </div>
                            <?php endforeach; endif; ?>
                        </div>
                        <form method="post" action="<?= base_url('x/send_message') ?>" style="padding: 12px; border-top: 1px solid var(--x-border); display: flex; gap: 8px;">
                            <input type="hidden" name="receiver_id" value="<?= $active_partner->user_id ?>">
                            <input type="text" name="message" placeholder="Start a new message..." class="form-control" style="background: var(--x-input-bg); border: 1px solid var(--x-border); color: var(--x-text-primary); border-radius: 9999px;" required>
                            <button type="submit" class="btn btn-primary" style="border-radius: 9999px;"><i class="fa fa-paper-plane"></i></button>
                        </form>
                    <?php else: ?>
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--x-text-secondary);">
                            <div style="text-align: center;">
                                <i class="fa fa-envelope-o fa-3x" style="margin-bottom: 10px;"></i>
                                <h4>Select a message</h4>
                                <p>Choose from your existing conversations or start a new one.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php elseif ($page == 'profile'): ?>
            <!-- User Profile View -->
            <div class="x-sticky-header" style="padding: 10px 18px; display: flex; align-items: center; gap: 20px;">
                <a href="<?= base_url('x') ?>" style="color: var(--x-text-primary); font-size: 18px;"><i class="fa fa-arrow-left"></i></a>
                <div>
                    <h4 style="margin: 0; font-weight: 800; font-size: 18px;"><?= $profile_user->fullname ?: $profile_user->username ?></h4>
                    <small style="color: var(--x-text-secondary);"><?= count($posts) ?> posts</small>
                </div>
            </div>

            <!-- Profile Banner & Header -->
            <div style="height: 140px; background: linear-gradient(135deg, #1d9bf0, #7928ca);"></div>
            <div style="padding: 0 20px; position: relative;">
                <div class="x-avatar" style="width: 84px; height: 84px; font-size: 36px; border: 4px solid var(--x-bg); position: absolute; top: -42px; background: #<?= substr(md5($profile_user->username), 0, 6) ?>;">
                    <?= strtoupper(substr($profile_user->fullname ?: $profile_user->username, 0, 1)) ?>
                </div>
                <div style="text-align: right; padding-top: 12px; margin-bottom: 12px;">
                    <?php if ($profile_user->user_id == $current_user->user_id): ?>
                        <button class="x-follow-btn" style="background: transparent; color: var(--x-text-primary); border: 1px solid var(--x-border);">Edit profile</button>
                    <?php else: ?>
                        <button class="x-follow-btn" onclick="toggleFollowUser(<?= $profile_user->user_id ?>, this)">
                            <?= $is_following ? 'Following' : 'Follow' ?>
                        </button>
                    <?php endif; ?>
                </div>
                <div style="margin-top: 14px;">
                    <h4 style="margin: 0; font-weight: 800;"><?= $profile_user->fullname ?: $profile_user->username ?> <i class="fa fa-check-circle text-primary"></i></h4>
                    <div style="color: var(--x-text-secondary); font-size: 14px;">@<?= $profile_user->username ?></div>
                    <p style="margin: 8px 0; font-size: 15px;"><?= $profile_user->designations ?: 'Team Member at RolandERP' ?></p>
                    <div style="display: flex; gap: 18px; color: var(--x-text-secondary); font-size: 14px; margin-top: 8px;">
                        <span><strong style="color: var(--x-text-primary);"><?= $following_count ?></strong> Following</span>
                        <span><strong style="color: var(--x-text-primary);"><?= $followers_count ?></strong> Followers</span>
                    </div>
                </div>
            </div>

            <!-- Profile Tabs -->
            <div class="x-top-tabs" style="margin-top: 14px; border-bottom: 1px solid var(--x-border);">
                <a href="<?= base_url('x/profile/' . $profile_user->user_id . '?tab=posts') ?>" class="x-top-tab <?= ($tab == 'posts') ? 'active' : '' ?>">Posts</a>
                <a href="<?= base_url('x/profile/' . $profile_user->user_id . '?tab=likes') ?>" class="x-top-tab <?= ($tab == 'likes') ? 'active' : '' ?>">Likes</a>
            </div>

            <div class="x-stream">
                <?php if (!empty($posts)): foreach ($posts as $p): ?>
                    <?= render_x_tweet($p, $current_user->user_id, $user_likes, $user_bookmarks); ?>
                <?php endforeach; else: ?>
                    <div style="padding: 40px 20px; text-align: center; color: var(--x-text-secondary);">
                        <h4>No posts found</h4>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif ($page == 'status'): ?>
            <!-- Single Status / Thread View -->
            <div class="x-sticky-header" style="padding: 12px 18px; display: flex; align-items: center; gap: 20px;">
                <a href="<?= base_url('x') ?>" style="color: var(--x-text-primary); font-size: 18px;"><i class="fa fa-arrow-left"></i></a>
                <h4 style="margin: 0; font-weight: 800; font-size: 18px;">Post</h4>
            </div>

            <!-- Main Post -->
            <div style="padding: 16px 20px; border-bottom: 1px solid var(--x-border);">
                <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
                    <div class="x-avatar" style="width: 44px; height: 44px;">
                        <?= strtoupper(substr($post->fullname ?: $post->username, 0, 1)) ?>
                    </div>
                    <div>
                        <div style="font-weight: 700;"><?= $post->fullname ?: $post->username ?></div>
                        <div style="color: var(--x-text-secondary); font-size: 14px;">@<?= $post->username ?></div>
                    </div>
                </div>
                <div style="font-size: 18px; line-height: 1.4;"><?= format_x_content($post->content) ?></div>
                <div style="color: var(--x-text-secondary); font-size: 14px; margin: 14px 0; padding-bottom: 12px; border-bottom: 1px solid var(--x-border);">
                    <?= date('g:i A · M j, Y', strtotime($post->created_at)) ?> · <strong><?= $post->views_count ?></strong> Views
                </div>

                <!-- Reply Composer -->
                <form method="post" action="<?= base_url('x/create_post') ?>" style="display: flex; gap: 10px; align-items: center;">
                    <input type="hidden" name="parent_post_id" value="<?= $post->post_id ?>">
                    <input type="text" name="content" placeholder="Post your reply..." class="form-control" style="background: var(--x-input-bg); border: 1px solid var(--x-border); color: var(--x-text-primary); border-radius: 9999px;" required>
                    <button type="submit" class="x-post-small-btn">Reply</button>
                </form>
            </div>

            <!-- Replies Stream -->
            <div class="x-stream">
                <?php if (!empty($replies)): foreach ($replies as $r): ?>
                    <?= render_x_tweet($r, $current_user->user_id, $user_likes, $user_bookmarks); ?>
                <?php endforeach; endif; ?>
            </div>

        <?php endif; ?>
    </div>

    <!-- ==================== 3. RIGHT SIDEBAR ==================== -->
    <div class="x-right-sidebar">
        <!-- Search Box -->
        <div class="x-search-bar">
            <i class="fa fa-search"></i>
            <form method="get" action="<?= base_url('x/explore') ?>" style="width: 100%;">
                <input type="text" name="q" placeholder="Search Ree-Social / RolandERP">
            </form>
        </div>

        <!-- Verified Pro Card -->
        <div class="x-side-card" style="background: linear-gradient(135deg, rgba(29,155,240,0.1), rgba(121,40,202,0.1)); border-color: rgba(29,155,240,0.3);">
            <h4 style="margin: 0 0 6px 0; font-weight: 800; font-size: 16px;">Ree-Social Verified Pro</h4>
            <p style="font-size: 13px; color: var(--x-text-secondary); margin-bottom: 12px;">Enterprise social collaboration, team announcements, and instant polling.</p>
            <span class="label label-primary" style="border-radius: 9999px; padding: 4px 10px;"><i class="fa fa-check-circle"></i> ACTIVE</span>
        </div>

        <!-- Trending Topics -->
        <div class="x-side-card">
            <div class="x-side-header">What's happening</div>
            <?php if (!empty($trending)): foreach ($trending as $tag => $count): ?>
                <div class="x-trend-row">
                    <div class="x-trend-meta">Trending in Workspace</div>
                    <a href="<?= base_url('x?tag=' . urlencode(ltrim($tag, '#'))) ?>" class="x-trend-title"><?= $tag ?></a>
                    <div class="x-trend-meta"><?= $count ?> <?= $count == 1 ? 'post' : 'posts' ?></div>
                </div>
            <?php endforeach; endif; ?>
        </div>

        <!-- Who to Follow -->
        <div class="x-side-card">
            <div class="x-side-header">Who to follow</div>
            <?php if (!empty($who_to_follow)): foreach ($who_to_follow as $u): ?>
                <div class="x-follow-row">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div class="x-avatar" style="width: 38px; height: 38px; font-size: 14px; background: #<?= substr(md5($u->username), 0, 6) ?>;">
                            <?= strtoupper(substr($u->fullname ?: $u->username, 0, 1)) ?>
                        </div>
                        <div>
                            <a href="<?= base_url('x/profile/' . $u->user_id) ?>" style="font-weight: 700; font-size: 14px; color: var(--x-text-primary); text-decoration: none;"><?= $u->fullname ?: $u->username ?></a>
                            <div style="font-size: 12px; color: var(--x-text-secondary);">@<?= $u->username ?></div>
                        </div>
                    </div>
                    <button class="x-follow-btn" onclick="toggleFollowUser(<?= $u->user_id ?>, this)">Follow</button>
                </div>
            <?php endforeach; endif; ?>
        </div>

        <!-- Theme Selector -->
        <div class="x-side-card" style="text-align: center;">
            <div style="font-size: 13px; font-weight: 700; margin-bottom: 8px; color: var(--x-text-secondary);">Appearance Theme</div>
            <button type="button" class="x-theme-btn" onclick="setTheme('dark')">Lights Out</button>
            <button type="button" class="x-theme-btn" onclick="setTheme('dim')">Dim</button>
            <button type="button" class="x-theme-btn" onclick="setTheme('light')">Default</button>
        </div>
    </div>
</div>

<?php
// Tweet Renderer Helper
function render_x_tweet($post, $current_user_id, $user_likes, $user_bookmarks) {
    $is_liked = !empty($user_likes[$post->post_id]);
    $is_bm = !empty($user_bookmarks[$post->post_id]);
    
    $html = '<div class="x-tweet" id="tweet_' . $post->post_id . '">';
    $html .= '<a href="' . base_url('x/profile/' . $post->user_id) . '" class="x-avatar" style="background: #' . substr(md5($post->username), 0, 6) . ';">' . strtoupper(substr($post->fullname ?: $post->username, 0, 1)) . '</a>';
    $html .= '<div class="x-tweet-content">';
    $html .= '<div class="x-tweet-header">';
    $html .= '<div>';
    $html .= '<a href="' . base_url('x/profile/' . $post->user_id) . '" class="x-name">' . ($post->fullname ?: $post->username) . '</a>';
    $html .= '<span class="x-handle">@' . $post->username . '</span>';
    $html .= '<span class="x-dot">·</span>';
    $html .= '<a href="' . base_url('x/status/' . $post->post_id) . '" class="x-time">' . time_elapsed($post->created_at) . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    
    $html .= '<div class="x-tweet-text">' . format_x_content($post->content) . '</div>';

    // Render Poll
    if (!empty($post->poll)) {
        $html .= '<div class="x-poll-box">';
        foreach ($post->poll['options'] as $opt) {
            if ($opt !== null) {
                $html .= '<div class="x-poll-option" onclick="votePoll(' . $post->poll['poll_id'] . ', ' . $opt['num'] . ', this)">';
                if ($post->poll['is_voted']) {
                    $html .= '<div class="x-poll-progress" style="width: ' . $opt['pct'] . '%;"></div>';
                }
                $html .= '<span class="x-poll-label">' . htmlspecialchars($opt['text']) . '</span>';
                if ($post->poll['is_voted']) {
                    $html .= '<span class="x-poll-label">' . $opt['pct'] . '%</span>';
                }
                $html .= '</div>';
            }
        }
        $html .= '<small class="text-muted">' . $post->poll['total_votes'] . ' votes</small>';
        $html .= '</div>';
    }

    // Media
    if (!empty($post->media_url)) {
        $html .= '<div style="margin-top: 10px; border-radius: 16px; overflow: hidden; max-height: 400px; border: 1px solid var(--x-border);"><img src="' . base_url($post->media_url) . '" style="width: 100%; object-fit: cover;"></div>';
    }

    // Metrics Toolbar
    $html .= '<div class="x-tweet-metrics">';
    $html .= '<a href="' . base_url('x/status/' . $post->post_id) . '" class="x-metric-item"><i class="fa fa-comment-o"></i> <span>' . $post->replies_count . '</span></a>';
    $html .= '<a href="' . base_url('admin/social/repost/' . $post->post_id) . '" class="x-metric-item"><i class="fa fa-retweet"></i> <span>' . $post->reposts_count . '</span></a>';
    $html .= '<button type="button" class="x-metric-item ' . ($is_liked ? 'liked' : '') . '" onclick="toggleXLike(' . $post->post_id . ', this)"><i class="fa ' . ($is_liked ? 'fa-heart' : 'fa-heart-o') . '"></i> <span class="like-cnt">' . $post->likes_count . '</span></button>';
    $html .= '<button type="button" class="x-metric-item ' . ($is_bm ? 'bookmarked' : '') . '" onclick="toggleXBm(' . $post->post_id . ', this)"><i class="fa ' . ($is_bm ? 'fa-bookmark' : 'fa-bookmark-o') . '"></i></button>';
    $html .= '<span class="x-metric-item"><i class="fa fa-bar-chart"></i> <span>' . $post->views_count . '</span></span>';
    $html .= '<button type="button" class="x-metric-item" onclick="copyXLink(' . $post->post_id . ')"><i class="fa fa-share-square-o"></i></button>';
    $html .= '</div>';

    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function format_x_content($text) {
    $text = htmlspecialchars($text);
    $text = preg_replace('/#(\w+)/u', '<a href="' . base_url('x?tag=$1') . '" class="x-tag">#$1</a>', $text);
    $text = preg_replace('/@(\w+)/u', '<a href="' . base_url('x/profile/$1') . '" class="x-tag">@$1</a>', $text);
    return nl2br($text);
}

function time_elapsed($datetime) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    if ($diff->d > 0) return $diff->d . 'd';
    if ($diff->h > 0) return $diff->h . 'h';
    if ($diff->i > 0) return $diff->i . 'm';
    return 'now';
}
?>

<script>
    // Theme Engine
    function setTheme(t) {
        document.documentElement.setAttribute('data-theme', t);
        localStorage.setItem('x_theme', t);
        $('.x-theme-btn').removeClass('active');
        $('button[onclick="setTheme(\'' + t + '\')"]').addClass('active');
    }
    const savedTheme = localStorage.getItem('x_theme') || 'dark';
    setTheme(savedTheme);

    function toggleXLike(postId, btn) {
        $.post('<?= base_url('admin/social/toggle_like') ?>', { post_id: postId }, function(res) {
            if (res.status === 'success') {
                var icon = $(btn).find('i');
                $(btn).find('.like-cnt').text(res.likes_count);
                if (res.liked) {
                    $(btn).addClass('liked');
                    icon.removeClass('fa-heart-o').addClass('fa-heart');
                } else {
                    $(btn).removeClass('liked');
                    icon.removeClass('fa-heart').addClass('fa-heart-o');
                }
            }
        }, 'json');
    }

    function toggleXBm(postId, btn) {
        $.post('<?= base_url('admin/social/toggle_bookmark') ?>', { post_id: postId }, function(res) {
            if (res.status === 'success') {
                var icon = $(btn).find('i');
                if (res.bookmarked) {
                    $(btn).addClass('bookmarked');
                    icon.removeClass('fa-bookmark-o').addClass('fa-bookmark');
                } else {
                    $(btn).removeClass('bookmarked');
                    icon.removeClass('fa-bookmark').addClass('fa-bookmark-o');
                }
            }
        }, 'json');
    }

    function toggleFollowUser(userId, btn) {
        $.post('<?= base_url('admin/social/toggle_follow') ?>', { user_id: userId }, function(res) {
            if (res.status === 'success') {
                if (res.following) {
                    $(btn).text('Following');
                } else {
                    $(btn).text('Follow');
                }
            }
        }, 'json');
    }

    function votePoll(pollId, optNum, elem) {
        $.post('<?= base_url('x/vote_poll') ?>', { poll_id: pollId, option_num: optNum }, function(res) {
            if (res.status === 'success') {
                location.reload();
            }
        }, 'json');
    }

    function copyXLink(postId) {
        var link = '<?= base_url('x/status/') ?>' + postId;
        navigator.clipboard.writeText(link).then(function() {
            alert('Post link copied to clipboard!');
        });
    }

    function insertEmoji(e) {
        var inp = $('.x-compose-input');
        inp.val(inp.val() + e).focus();
    }

    function insertTag(t) {
        var inp = $('.x-compose-input');
        inp.val(inp.val() + t).focus();
    }

    function previewMediaFile(inp) {
        if (inp.files && inp.files[0]) {
            $('#media_preview_tag').text('Attached photo: ' + inp.files[0].name);
        }
    }
</script>

</body>
</html>
