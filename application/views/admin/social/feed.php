<?= message_box('success'); ?>
<?= message_box('error'); ?>

<style>
    /* X (Twitter) Style Custom Styling */
    .x-container {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 30px;
    }
    .x-header-nav {
        display: flex;
        border-bottom: 1px solid #edf2f7;
        background: #fff;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .x-tab-btn {
        flex: 1;
        text-align: center;
        padding: 16px 0;
        font-weight: 600;
        font-size: 15px;
        color: #657786;
        text-decoration: none;
        position: relative;
        transition: all 0.2s;
    }
    .x-tab-btn:hover {
        background-color: #f7f9fa;
        color: #1da1f2;
        text-decoration: none;
    }
    .x-tab-btn.active {
        color: #0f1419;
        font-weight: 700;
    }
    .x-tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 56px;
        height: 4px;
        background-color: #1da1f2;
        border-radius: 9999px;
    }
    .x-compose-card {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        gap: 14px;
    }
    .x-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        background: #1da1f2;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 20px;
    }
    .x-compose-box {
        flex: 1;
    }
    .x-compose-input {
        width: 100%;
        border: none;
        resize: none;
        font-size: 17px;
        outline: none;
        min-height: 70px;
        font-family: inherit;
    }
    .x-compose-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px solid #f0f3f5;
        margin-top: 8px;
    }
    .x-tool-icons {
        display: flex;
        gap: 12px;
        color: #1da1f2;
        font-size: 17px;
    }
    .x-tool-btn {
        cursor: pointer;
        padding: 6px;
        border-radius: 50%;
        transition: background 0.2s;
    }
    .x-tool-btn:hover {
        background: rgba(29, 161, 242, 0.1);
    }
    .x-post-btn {
        background: #1da1f2;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 9999px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .x-post-btn:hover {
        background: #1a91da;
    }
    .x-post-item {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        gap: 14px;
        transition: background 0.15s;
    }
    .x-post-item:hover {
        background: #fdfdfd;
    }
    .x-post-content-wrap {
        flex: 1;
    }
    .x-post-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4px;
    }
    .x-author-name {
        font-weight: 700;
        font-size: 15px;
        color: #0f1419;
    }
    .x-handle {
        color: #536471;
        font-size: 14px;
        margin-left: 4px;
    }
    .x-timestamp {
        color: #536471;
        font-size: 14px;
    }
    .x-post-text {
        font-size: 15px;
        line-height: 1.45;
        color: #0f1419;
        white-space: pre-wrap;
        word-break: break-word;
    }
    .x-hashtag {
        color: #1da1f2;
        text-decoration: none;
        font-weight: 500;
    }
    .x-hashtag:hover {
        text-decoration: underline;
    }
    .x-actions-bar {
        display: flex;
        justify-content: space-between;
        max-width: 440px;
        margin-top: 12px;
        color: #536471;
        font-size: 14px;
    }
    .x-action-item {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: color 0.2s;
        border: none;
        background: none;
        padding: 0;
    }
    .x-action-item:hover {
        color: #1da1f2;
    }
    .x-action-item.liked {
        color: #f91880;
    }
    .x-action-item.reposted {
        color: #00ba7c;
    }
    .x-action-item.bookmarked {
        color: #1da1f2;
    }
    /* Right Sidebar */
    .x-side-card {
        background: #f7f9fa;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 20px;
    }
    .x-side-title {
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 14px;
        color: #0f1419;
    }
    .trend-item {
        padding: 8px 0;
        border-bottom: 1px solid #eef1f4;
    }
    .trend-item:last-child {
        border-bottom: none;
    }
    .follow-user-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #eef1f4;
    }
    .follow-user-item:last-child {
        border-bottom: none;
    }
    .follow-btn {
        background: #0f1419;
        color: #fff;
        border: none;
        padding: 6px 16px;
        border-radius: 9999px;
        font-weight: 700;
        font-size: 13px;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .follow-btn:hover {
        opacity: 0.85;
    }
    .follow-btn.is-following {
        background: transparent;
        color: #0f1419;
        border: 1px solid #cfd9de;
    }
</style>

<div class="row">
    <!-- Main Feed Column -->
    <div class="col-md-8">
        <div class="x-container">
            <!-- Header Tabs (For You / Following / My Posts) -->
            <div class="x-header-nav">
                <a href="<?= base_url('admin/social/feed?tab=for_you') ?>" class="x-tab-btn <?= ($active_tab == 'for_you' && empty($active_tag)) ? 'active' : '' ?>">
                    <?= lang('for_you') ?>
                </a>
                <a href="<?= base_url('admin/social/feed?tab=following') ?>" class="x-tab-btn <?= ($active_tab == 'following') ? 'active' : '' ?>">
                    <?= lang('following') ?>
                </a>
                <a href="<?= base_url('admin/social/feed?tab=my_posts') ?>" class="x-tab-btn <?= ($active_tab == 'my_posts') ? 'active' : '' ?>">
                    <?= lang('my_posts') ?>
                </a>
                <a href="<?= base_url('admin/social/bookmarks') ?>" class="x-tab-btn <?= ($active_tab == 'bookmarks') ? 'active' : '' ?>">
                    <i class="fa fa-bookmark-o"></i> <?= lang('bookmarks') ?>
                </a>
            </div>

            <?php if (!empty($active_tag)): ?>
                <div style="padding: 12px 20px; background: #e8f5fd; border-bottom: 1px solid #cce9fb; display:flex; align-items:center; justify-content:space-between;">
                    <span>Filtering posts tagged with <strong class="text-primary">#<?= htmlspecialchars($active_tag) ?></strong></span>
                    <a href="<?= base_url('admin/social/feed') ?>" class="btn btn-xs btn-default"><i class="fa fa-times"></i> Clear Filter</a>
                </div>
            <?php endif; ?>

            <!-- Compose Post Box -->
            <div class="x-compose-card">
                <div class="x-avatar">
                    <?= strtoupper(substr($current_user_name, 0, 1)) ?>
                </div>
                <div class="x-compose-box">
                    <form method="post" action="<?= base_url('admin/social/create_post') ?>" enctype="multipart/form-data">
                        <textarea name="content" class="x-compose-input" placeholder="<?= lang('what_is_happening') ?>" required></textarea>
                        
                        <div class="x-compose-toolbar">
                            <div class="x-tool-icons">
                                <label class="x-tool-btn" title="Add Image/Photo" style="margin-bottom:0;">
                                    <i class="fa fa-picture-o"></i>
                                    <input type="file" name="media" accept="image/*" style="display: none;" onchange="previewMedia(this)">
                                </label>
                                <span class="x-tool-btn" title="Add Hashtag" onclick="insertTag('#')"><i class="fa fa-hashtag"></i></span>
                                <span class="x-tool-btn" title="Mention Colleague" onclick="insertTag('@')"><i class="fa fa-at"></i></span>
                                <span class="x-tool-btn" title="Add Emoji" onclick="insertTag('🚀 ')"><i class="fa fa-smile-o"></i></span>
                            </div>
                            <button type="submit" class="x-post-btn"><?= lang('post') ?></button>
                        </div>
                        <div id="media_preview_name" style="font-size: 12px; color: #1da1f2; margin-top: 4px;"></div>
                    </form>
                </div>
            </div>

            <!-- Posts Stream -->
            <div class="x-feed-stream">
                <?php if (!empty($posts)): foreach ($posts as $post): ?>
                    <div class="x-post-item" id="post_wrap_<?= $post->post_id ?>">
                        <div class="x-avatar" style="background: #<?= substr(md5($post->username), 0, 6) ?>;">
                            <?= strtoupper(substr($post->fullname ?: $post->username, 0, 1)) ?>
                        </div>
                        <div class="x-post-content-wrap">
                            <div class="x-post-header">
                                <div>
                                    <span class="x-author-name"><?= $post->fullname ?: $post->username ?></span>
                                    <span class="x-handle">@<?= $post->username ?></span>
                                    <span class="x-timestamp">· <?= time_elapsed_string($post->created_at) ?></span>
                                </div>
                                <?php if ($post->user_id == $current_user_id): ?>
                                    <a href="<?= base_url('admin/social/delete_post/' . $post->post_id) ?>" onclick="return confirm('Delete this post?');" class="text-muted" title="Delete"><i class="fa fa-trash-o"></i></a>
                                <?php endif; ?>
                            </div>

                            <!-- Post Text with Clickable Hashtags -->
                            <div class="x-post-text"><?= format_social_content($post->content) ?></div>

                            <?php if (!empty($post->media_url)): ?>
                                <div style="margin-top: 10px; border-radius: 12px; overflow: hidden; max-height: 400px; border: 1px solid #edf2f7;">
                                    <img src="<?= base_url($post->media_url) ?>" style="width: 100%; object-fit: cover;">
                                </div>
                            <?php endif; ?>

                            <!-- Actions Bar: Reply, Repost, Like, Bookmark, Share -->
                            <div class="x-actions-bar">
                                <!-- Reply -->
                                <button type="button" class="x-action-item" onclick="toggleReplyBox(<?= $post->post_id ?>)">
                                    <i class="fa fa-comment-o"></i>
                                    <span><?= $post->replies_count ?></span>
                                </button>

                                <!-- Repost -->
                                <a href="<?= base_url('admin/social/repost/' . $post->post_id) ?>" class="x-action-item" title="Repost">
                                    <i class="fa fa-retweet"></i>
                                    <span><?= $post->reposts_count ?></span>
                                </a>

                                <!-- Like -->
                                <button type="button" class="x-action-item <?= !empty($user_likes[$post->post_id]) ? 'liked' : '' ?>" onclick="toggleLike(<?= $post->post_id ?>, this)">
                                    <i class="fa <?= !empty($user_likes[$post->post_id]) ? 'fa-heart' : 'fa-heart-o' ?>"></i>
                                    <span class="like-counter"><?= $post->likes_count ?></span>
                                </button>

                                <!-- Bookmark -->
                                <button type="button" class="x-action-item <?= !empty($user_bookmarks[$post->post_id]) ? 'bookmarked' : '' ?>" onclick="toggleBookmark(<?= $post->post_id ?>, this)" title="Bookmark">
                                    <i class="fa <?= !empty($user_bookmarks[$post->post_id]) ? 'fa-bookmark' : 'fa-bookmark-o' ?>"></i>
                                </button>

                                <!-- Share -->
                                <button type="button" class="x-action-item" onclick="copyPostLink(<?= $post->post_id ?>)" title="Copy Link">
                                    <i class="fa fa-share-square-o"></i>
                                </button>
                            </div>

                            <!-- Reply Box (Collapsed) -->
                            <div id="reply_box_<?= $post->post_id ?>" style="display: none; margin-top: 12px; padding-top: 10px; border-top: 1px dashed #edf2f7;">
                                <form method="post" action="<?= base_url('admin/social/reply/' . $post->post_id) ?>" style="display: flex; gap: 8px;">
                                    <input type="text" name="reply_content" placeholder="Post your reply..." class="form-control input-sm" style="border-radius: 9999px;" required>
                                    <button type="submit" class="btn btn-xs btn-primary" style="border-radius: 9999px; padding: 4px 14px;">Reply</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div style="padding: 40px 20px; text-align: center; color: #536471;">
                        <i class="fa fa-hashtag fa-3x" style="color: #cfd9de; margin-bottom: 12px;"></i>
                        <h4>No posts in this feed yet</h4>
                        <p>Be the first to post an update, announcement, or milestone!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right Sidebar (Trends & Recommendations) -->
    <div class="col-md-4">
        <!-- Search Box -->
        <div class="x-side-card" style="padding: 12px;">
            <form method="get" action="<?= base_url('admin/social/feed') ?>">
                <div class="input-group">
                    <input type="text" name="tag" class="form-control" placeholder="Search hashtags (#)..." value="<?= htmlspecialchars($active_tag) ?>" style="border-radius: 9999px 0 0 9999px; border: 1px solid #cfd9de;">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit" style="border-radius: 0 9999px 9999px 0;"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>

        <!-- Trending Topics / Hashtags -->
        <div class="x-side-card">
            <div class="x-side-title"><i class="fa fa-line-chart text-primary"></i> <?= lang('trending_topics') ?></div>
            <?php if (!empty($trending_hashtags)): foreach ($trending_hashtags as $tag => $count): ?>
                <div class="trend-item">
                    <small class="text-muted">Trending in Workplace</small><br>
                    <a href="<?= base_url('admin/social/feed?tag=' . urlencode(ltrim($tag, '#'))) ?>" class="x-hashtag" style="font-weight: 700; font-size: 15px;">
                        <?= $tag ?>
                    </a>
                    <br><small class="text-muted"><?= $count ?> <?= $count == 1 ? 'post' : 'posts' ?></small>
                </div>
            <?php endforeach; else: ?>
                <div class="text-muted"><small>No trending hashtags yet.</small></div>
            <?php endif; ?>
        </div>

        <!-- Who to Follow -->
        <div class="x-side-card">
            <div class="x-side-title"><i class="fa fa-user-plus text-primary"></i> <?= lang('who_to_follow') ?></div>
            <?php if (!empty($who_to_follow)): foreach ($who_to_follow as $user): ?>
                <div class="follow-user-item">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div class="x-avatar" style="width: 38px; height: 38px; font-size: 15px; background: #<?= substr(md5($user->username), 0, 6) ?>;">
                            <?= strtoupper(substr($user->fullname ?: $user->username, 0, 1)) ?>
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 14px;"><?= $user->fullname ?: $user->username ?></div>
                            <div style="font-size: 12px; color: #536471;">@<?= $user->username ?></div>
                            <small class="label label-default"><?= $user->designations ?: 'Staff' ?></small>
                        </div>
                    </div>
                    <button type="button" class="follow-btn" onclick="toggleFollow(<?= $user->user_id ?>, this)">Follow</button>
                </div>
            <?php endforeach; else: ?>
                <div class="text-muted"><small>You are following all colleagues.</small></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
function format_social_content($text) {
    $text = htmlspecialchars($text);
    // Linkify #hashtags
    $text = preg_replace('/#(\w+)/u', '<a href="' . base_url('admin/social/feed?tag=$1') . '" class="x-hashtag">#$1</a>', $text);
    // Linkify @mentions
    $text = preg_replace('/@(\w+)/u', '<span class="text-primary" style="font-weight:600;">@$1</span>', $text);
    return nl2br($text);
}

function time_elapsed_string($datetime) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    if ($diff->d > 0) return $diff->d . 'd';
    if ($diff->h > 0) return $diff->h . 'h';
    if ($diff->i > 0) return $diff->i . 'm';
    return 'just now';
}
?>

<script>
function toggleLike(postId, btn) {
    $.post('<?= base_url('admin/social/toggle_like') ?>', { post_id: postId }, function(res) {
        if (res.status === 'success') {
            var icon = $(btn).find('i');
            var counter = $(btn).find('.like-counter');
            counter.text(res.likes_count);
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

function toggleBookmark(postId, btn) {
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

function toggleFollow(userId, btn) {
    $.post('<?= base_url('admin/social/toggle_follow') ?>', { user_id: userId }, function(res) {
        if (res.status === 'success') {
            if (res.following) {
                $(btn).addClass('is-following').text('Following');
            } else {
                $(btn).removeClass('is-following').text('Follow');
            }
        }
    }, 'json');
}

function toggleReplyBox(postId) {
    $('#reply_box_' + postId).slideToggle(150);
}

function copyPostLink(postId) {
    var link = '<?= base_url('admin/social/feed') ?>#post_' + postId;
    navigator.clipboard.writeText(link).then(function() {
        alert('Post link copied to clipboard!');
    });
}

function insertTag(tag) {
    var input = $('.x-compose-input');
    input.val(input.val() + tag).focus();
}

function previewMedia(input) {
    if (input.files && input.files[0]) {
        $('#media_preview_name').text('Attached: ' + input.files[0].name);
    }
}
</script>
