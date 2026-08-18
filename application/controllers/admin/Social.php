<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Social extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
    }

    public function index()
    {
        $this->feed();
    }

    // 1. Main Social Feed (X / Twitter style)
    public function feed()
    {
        $data['title'] = lang('social_feed');
        $user_id = $this->session->userdata('user_id');
        $tab = $this->input->get('tab', true) ?: 'for_you';
        $tag = $this->input->get('tag', true);

        $this->db->select('tbl_social_posts.*, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar');
        $this->db->from('tbl_social_posts');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_social_posts.user_id', 'left');
        $this->db->where('tbl_social_posts.parent_post_id IS NULL');

        if (!empty($tag)) {
            $this->db->like('tbl_social_posts.hashtags', '#' . ltrim($tag, '#'));
        } elseif ($tab == 'following') {
            $following_ids = $this->get_following_ids($user_id);
            if (!empty($following_ids)) {
                $this->db->where_in('tbl_social_posts.user_id', $following_ids);
            } else {
                $this->db->where('tbl_social_posts.user_id', -1); // Empty
            }
        } elseif ($tab == 'my_posts') {
            $this->db->where('tbl_social_posts.user_id', $user_id);
        }

        $this->db->order_by('tbl_social_posts.post_id', 'DESC');
        $this->db->limit(50);
        $data['posts'] = $this->db->get()->result();

        // Get user like & bookmark map
        $data['user_likes'] = $this->get_user_likes_map($user_id);
        $data['user_bookmarks'] = $this->get_user_bookmarks_map($user_id);

        // Sidebar: Trending Hashtags
        $data['trending_hashtags'] = $this->get_trending_hashtags();

        // Sidebar: Who to follow
        $data['who_to_follow'] = $this->get_who_to_follow($user_id);

        // Active tab & tag
        $data['active_tab'] = $tab;
        $data['active_tag'] = $tag;
        $data['current_user_id'] = $user_id;

        $user_profile = $this->db->where('user_id', $user_id)->get('tbl_account_details')->row();
        $data['current_user_name'] = !empty($user_profile->fullname) ? $user_profile->fullname : 'Me';
        $data['current_user_avatar'] = !empty($user_profile->avatar) ? $user_profile->avatar : 'assets/img/user/default_avatar.jpg';

        $data['subview'] = $this->load->view('admin/social/feed', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    // 2. Create Post
    public function create_post()
    {
        $user_id = $this->session->userdata('user_id');
        $content = $this->input->post('content', true);

        if (empty(trim($content))) {
            set_message('error', 'Post content cannot be empty.');
            redirect('admin/social/feed');
            return;
        }

        // Extract hashtags
        preg_match_all('/#(\w+)/u', $content, $matches);
        $hashtags = !empty($matches[0]) ? implode(' ', array_unique($matches[0])) : null;

        $media_url = null;
        if (!empty($_FILES['media']['name'])) {
            $val = $this->settings_model->uploadFile('media');
            if ($val && !empty($val['path'])) {
                $media_url = $val['path'];
            }
        }

        $data = [
            'user_id' => $user_id,
            'content' => $content,
            'media_url' => $media_url,
            'hashtags' => $hashtags,
            'likes_count' => 0,
            'reposts_count' => 0,
            'replies_count' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('tbl_social_posts', $data);
        set_message('success', 'Your post has been shared to the feed!');
        redirect('admin/social/feed');
    }

    // 3. Like / Unlike Post (AJAX)
    public function toggle_like()
    {
        $user_id = $this->session->userdata('user_id');
        $post_id = (int)$this->input->post('post_id', true);

        $exists = $this->db->where('post_id', $post_id)->where('user_id', $user_id)->get('tbl_social_likes')->row();
        if ($exists) {
            $this->db->where('like_id', $exists->like_id)->delete('tbl_social_likes');
            $liked = false;
            $this->db->set('likes_count', 'GREATEST(0, likes_count - 1)', false)->where('post_id', $post_id)->update('tbl_social_posts');
        } else {
            $this->db->insert('tbl_social_likes', ['post_id' => $post_id, 'user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s')]);
            $liked = true;
            $this->db->set('likes_count', 'likes_count + 1', false)->where('post_id', $post_id)->update('tbl_social_posts');
        }

        $post = $this->db->where('post_id', $post_id)->get('tbl_social_posts')->row();
        echo json_encode([
            'status' => 'success',
            'liked' => $liked,
            'likes_count' => (int)($post->likes_count ?? 0)
        ]);
        exit();
    }

    // 4. Bookmark / Unbookmark Post (AJAX)
    public function toggle_bookmark()
    {
        $user_id = $this->session->userdata('user_id');
        $post_id = (int)$this->input->post('post_id', true);

        $exists = $this->db->where('post_id', $post_id)->where('user_id', $user_id)->get('tbl_social_bookmarks')->row();
        if ($exists) {
            $this->db->where('bookmark_id', $exists->bookmark_id)->delete('tbl_social_bookmarks');
            $bookmarked = false;
        } else {
            $this->db->insert('tbl_social_bookmarks', ['post_id' => $post_id, 'user_id' => $user_id, 'created_at' => date('Y-m-d H:i:s')]);
            $bookmarked = true;
        }

        echo json_encode([
            'status' => 'success',
            'bookmarked' => $bookmarked
        ]);
        exit();
    }

    // 5. Repost (Retweet)
    public function repost($post_id)
    {
        $user_id = $this->session->userdata('user_id');
        $original = $this->db->where('post_id', $post_id)->get('tbl_social_posts')->row();
        if ($original) {
            $repost_data = [
                'user_id' => $user_id,
                'content' => $original->content,
                'media_url' => $original->media_url,
                'repost_post_id' => $post_id,
                'hashtags' => $original->hashtags,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('tbl_social_posts', $repost_data);
            $this->db->set('reposts_count', 'reposts_count + 1', false)->where('post_id', $post_id)->update('tbl_social_posts');
            set_message('success', 'Reposted to your timeline!');
        }
        redirect('admin/social/feed');
    }

    // 6. Reply to Post
    public function reply($post_id)
    {
        $user_id = $this->session->userdata('user_id');
        $content = $this->input->post('reply_content', true);

        if (!empty(trim($content))) {
            $reply_data = [
                'user_id' => $user_id,
                'content' => $content,
                'parent_post_id' => $post_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('tbl_social_posts', $reply_data);
            $this->db->set('replies_count', 'replies_count + 1', false)->where('post_id', $post_id)->update('tbl_social_posts');
            set_message('success', 'Reply posted!');
        }
        redirect('admin/social/feed');
    }

    // 7. Toggle Follow (AJAX)
    public function toggle_follow()
    {
        $follower_id = $this->session->userdata('user_id');
        $following_id = (int)$this->input->post('user_id', true);

        if ($follower_id == $following_id) {
            echo json_encode(['status' => 'error', 'message' => 'Cannot follow yourself']);
            exit();
        }

        $exists = $this->db->where('follower_id', $follower_id)->where('following_id', $following_id)->get('tbl_social_follows')->row();
        if ($exists) {
            $this->db->where('follow_id', $exists->follow_id)->delete('tbl_social_follows');
            $following = false;
        } else {
            $this->db->insert('tbl_social_follows', ['follower_id' => $follower_id, 'following_id' => $following_id, 'created_at' => date('Y-m-d H:i:s')]);
            $following = true;
        }

        echo json_encode(['status' => 'success', 'following' => $following]);
        exit();
    }

    // 8. Bookmarks Page
    public function bookmarks()
    {
        $data['title'] = lang('bookmarks');
        $user_id = $this->session->userdata('user_id');

        $this->db->select('tbl_social_posts.*, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar');
        $this->db->from('tbl_social_bookmarks');
        $this->db->join('tbl_social_posts', 'tbl_social_posts.post_id = tbl_social_bookmarks.post_id', 'inner');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_social_posts.user_id', 'left');
        $this->db->where('tbl_social_bookmarks.user_id', $user_id);
        $this->db->order_by('tbl_social_bookmarks.bookmark_id', 'DESC');
        $data['posts'] = $this->db->get()->result();

        $data['user_likes'] = $this->get_user_likes_map($user_id);
        $data['user_bookmarks'] = $this->get_user_bookmarks_map($user_id);
        $data['trending_hashtags'] = $this->get_trending_hashtags();
        $data['who_to_follow'] = $this->get_who_to_follow($user_id);
        $data['active_tab'] = 'bookmarks';
        $data['current_user_id'] = $user_id;

        $user_profile = $this->db->where('user_id', $user_id)->get('tbl_account_details')->row();
        $data['current_user_name'] = !empty($user_profile->fullname) ? $user_profile->fullname : 'Me';
        $data['current_user_avatar'] = !empty($user_profile->avatar) ? $user_profile->avatar : 'assets/img/user/default_avatar.jpg';

        $data['subview'] = $this->load->view('admin/social/feed', $data, true);
        $this->load->view('admin/_layout_main', $data);
    }

    // 9. Delete Post
    public function delete_post($post_id)
    {
        $user_id = $this->session->userdata('user_id');
        $post = $this->db->where('post_id', $post_id)->get('tbl_social_posts')->row();
        if ($post && ($post->user_id == $user_id || $this->session->userdata('user_type') == 1)) {
            $this->db->where('post_id', $post_id)->delete('tbl_social_posts');
            $this->db->where('post_id', $post_id)->delete('tbl_social_likes');
            $this->db->where('post_id', $post_id)->delete('tbl_social_bookmarks');
            set_message('success', 'Post deleted.');
        }
        redirect('admin/social/feed');
    }

    // Helper functions
    private function get_following_ids($user_id)
    {
        $res = $this->db->where('follower_id', $user_id)->get('tbl_social_follows')->result();
        $ids = [];
        foreach ($res as $r) {
            $ids[] = $r->following_id;
        }
        return $ids;
    }

    private function get_user_likes_map($user_id)
    {
        $res = $this->db->where('user_id', $user_id)->get('tbl_social_likes')->result();
        $map = [];
        foreach ($res as $r) {
            $map[$r->post_id] = true;
        }
        return $map;
    }

    private function get_user_bookmarks_map($user_id)
    {
        $res = $this->db->where('user_id', $user_id)->get('tbl_social_bookmarks')->result();
        $map = [];
        foreach ($res as $r) {
            $map[$r->post_id] = true;
        }
        return $map;
    }

    private function get_trending_hashtags()
    {
        $posts = $this->db->where('hashtags IS NOT NULL', null, false)->get('tbl_social_posts')->result();
        $tags = [];
        foreach ($posts as $p) {
            if (!empty($p->hashtags)) {
                $words = explode(' ', $p->hashtags);
                foreach ($words as $w) {
                    $w = trim($w);
                    if (!empty($w) && strpos($w, '#') === 0) {
                        $tags[$w] = ($tags[$w] ?? 0) + 1;
                    }
                }
            }
        }
        arsort($tags);
        return array_slice($tags, 0, 8, true);
    }

    private function get_who_to_follow($user_id)
    {
        $following = $this->get_following_ids($user_id);
        $following[] = $user_id; // Exclude self

        $this->db->select('tbl_users.user_id, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar, tbl_designations.designations');
        $this->db->from('tbl_users');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_users.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_account_details.designations_id', 'left');
        $this->db->where_not_in('tbl_users.user_id', $following);
        $this->db->limit(5);
        return $this->db->get()->result();
    }
}
