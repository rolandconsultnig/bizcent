<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class X extends MY_Controller
{
    protected $current_user_id;
    protected $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');

        // Check authentication
        $this->current_user_id = $this->session->userdata('user_id');
        if (empty($this->current_user_id)) {
            redirect('login');
        }

        $this->db->select('tbl_users.user_id, tbl_users.username, tbl_users.email, tbl_account_details.fullname, tbl_account_details.avatar, tbl_designations.designations');
        $this->db->from('tbl_users');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_users.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_account_details.designations_id', 'left');
        $this->db->where('tbl_users.user_id', $this->current_user_id);
        $this->current_user = $this->db->get()->row();
    }

    // 1. Main Timeline (Home)
    public function index()
    {
        $this->home();
    }

    public function home()
    {
        $tab = $this->input->get('tab', true) ?: 'for_you';
        $tag = $this->input->get('tag', true);

        $this->db->select('tbl_social_posts.*, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar, tbl_designations.designations');
        $this->db->from('tbl_social_posts');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_account_details.designations_id', 'left');
        $this->db->where('tbl_social_posts.parent_post_id IS NULL');

        if (!empty($tag)) {
            $this->db->like('tbl_social_posts.hashtags', '#' . ltrim($tag, '#'));
        } elseif ($tab == 'following') {
            $following_ids = $this->get_following_ids($this->current_user_id);
            if (!empty($following_ids)) {
                $this->db->where_in('tbl_social_posts.user_id', $following_ids);
            } else {
                $this->db->where('tbl_social_posts.user_id', -1);
            }
        }

        $this->db->order_by('tbl_social_posts.post_id', 'DESC');
        $this->db->limit(60);
        $posts = $this->db->get()->result();

        // Attach poll & vote data to posts
        foreach ($posts as &$p) {
            $p->poll = $this->get_post_poll($p->post_id);
        }

        $data = [
            'page' => 'home',
            'tab' => $tab,
            'tag' => $tag,
            'posts' => $posts,
            'current_user' => $this->current_user,
            'user_likes' => $this->get_user_likes_map($this->current_user_id),
            'user_bookmarks' => $this->get_user_bookmarks_map($this->current_user_id),
            'trending' => $this->get_trending_hashtags(),
            'who_to_follow' => $this->get_who_to_follow($this->current_user_id),
        ];

        $this->load->view('x/layout', $data);
    }

    // 2. Explore Page
    public function explore()
    {
        $q = $this->input->get('q', true);
        $tag = $this->input->get('tag', true);

        $this->db->select('tbl_social_posts.*, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar, tbl_designations.designations');
        $this->db->from('tbl_social_posts');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_account_details.designations_id', 'left');

        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('tbl_social_posts.content', $q);
            $this->db->or_like('tbl_users.username', $q);
            $this->db->or_like('tbl_account_details.fullname', $q);
            $this->db->group_end();
        } elseif (!empty($tag)) {
            $this->db->like('tbl_social_posts.hashtags', '#' . ltrim($tag, '#'));
        }

        $this->db->order_by('tbl_social_posts.likes_count', 'DESC');
        $posts = $this->db->get()->result();

        foreach ($posts as &$p) {
            $p->poll = $this->get_post_poll($p->post_id);
        }

        $data = [
            'page' => 'explore',
            'q' => $q,
            'tag' => $tag,
            'posts' => $posts,
            'current_user' => $this->current_user,
            'user_likes' => $this->get_user_likes_map($this->current_user_id),
            'user_bookmarks' => $this->get_user_bookmarks_map($this->current_user_id),
            'trending' => $this->get_trending_hashtags(),
            'who_to_follow' => $this->get_who_to_follow($this->current_user_id),
        ];

        $this->load->view('x/layout', $data);
    }

    // 3. Notifications Page
    public function notifications()
    {
        $this->db->select('tbl_social_notifications.*, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar');
        $this->db->from('tbl_social_notifications');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_social_notifications.from_user_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_social_notifications.from_user_id', 'left');
        $this->db->where('tbl_social_notifications.user_id', $this->current_user_id);
        $this->db->order_by('tbl_social_notifications.notification_id', 'DESC');
        $notifications = $this->db->get()->result();

        // Mark as read
        $this->db->where('user_id', $this->current_user_id)->update('tbl_social_notifications', ['is_read' => 1]);

        $data = [
            'page' => 'notifications',
            'notifications' => $notifications,
            'current_user' => $this->current_user,
            'trending' => $this->get_trending_hashtags(),
            'who_to_follow' => $this->get_who_to_follow($this->current_user_id),
        ];

        $this->load->view('x/layout', $data);
    }

    // 4. Messages / DMs
    public function messages($target_user_id = null)
    {
        // Get conversation partners
        $this->db->select('DISTINCT(CASE WHEN sender_id = ' . (int)$this->current_user_id . ' THEN receiver_id ELSE sender_id END) as partner_id', false);
        $this->db->from('tbl_social_messages');
        $this->db->where('sender_id', $this->current_user_id);
        $this->db->or_where('receiver_id', $this->current_user_id);
        $partner_rows = $this->db->get()->result();

        $conversations = [];
        foreach ($partner_rows as $p) {
            $u = $this->get_user_summary($p->partner_id);
            if ($u) {
                // Get last message
                $last_msg = $this->db->query("SELECT * FROM tbl_social_messages WHERE (sender_id = {$this->current_user_id} AND receiver_id = {$p->partner_id}) OR (sender_id = {$p->partner_id} AND receiver_id = {$this->current_user_id}) ORDER BY message_id DESC LIMIT 1")->row();
                $u->last_message = $last_msg ? $last_msg->message : '';
                $u->last_time = $last_msg ? $last_msg->created_at : '';
                $conversations[] = $u;
            }
        }

        $active_partner = null;
        $chat_messages = [];
        if (!empty($target_user_id)) {
            $active_partner = $this->get_user_summary($target_user_id);
            $chat_messages = $this->db->query("SELECT * FROM tbl_social_messages WHERE (sender_id = {$this->current_user_id} AND receiver_id = {$target_user_id}) OR (sender_id = {$target_user_id} AND receiver_id = {$this->current_user_id}) ORDER BY message_id ASC")->result();
        }

        $data = [
            'page' => 'messages',
            'conversations' => $conversations,
            'active_partner' => $active_partner,
            'chat_messages' => $chat_messages,
            'current_user' => $this->current_user,
            'all_colleagues' => $this->get_all_colleagues(),
            'trending' => $this->get_trending_hashtags(),
            'who_to_follow' => $this->get_who_to_follow($this->current_user_id),
        ];

        $this->load->view('x/layout', $data);
    }

    public function send_message()
    {
        $receiver_id = (int)$this->input->post('receiver_id', true);
        $message = trim($this->input->post('message', true));

        if (!empty($message) && $receiver_id > 0) {
            $this->db->insert('tbl_social_messages', [
                'sender_id' => $this->current_user_id,
                'receiver_id' => $receiver_id,
                'message' => $message,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        redirect('x/messages/' . $receiver_id);
    }

    // 5. Bookmarks Page
    public function bookmarks()
    {
        $this->db->select('tbl_social_posts.*, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar, tbl_designations.designations');
        $this->db->from('tbl_social_bookmarks');
        $this->db->join('tbl_social_posts', 'tbl_social_posts.post_id = tbl_social_bookmarks.post_id', 'inner');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_account_details.designations_id', 'left');
        $this->db->where('tbl_social_bookmarks.user_id', $this->current_user_id);
        $this->db->order_by('tbl_social_bookmarks.bookmark_id', 'DESC');
        $posts = $this->db->get()->result();

        foreach ($posts as &$p) {
            $p->poll = $this->get_post_poll($p->post_id);
        }

        $data = [
            'page' => 'bookmarks',
            'posts' => $posts,
            'current_user' => $this->current_user,
            'user_likes' => $this->get_user_likes_map($this->current_user_id),
            'user_bookmarks' => $this->get_user_bookmarks_map($this->current_user_id),
            'trending' => $this->get_trending_hashtags(),
            'who_to_follow' => $this->get_who_to_follow($this->current_user_id),
        ];

        $this->load->view('x/layout', $data);
    }

    // 6. User Profile
    public function profile($user_id_or_name = null)
    {
        if (empty($user_id_or_name)) {
            $user_id = $this->current_user_id;
        } elseif (is_numeric($user_id_or_name)) {
            $user_id = (int)$user_id_or_name;
        } else {
            $u = $this->db->where('username', $user_id_or_name)->get('tbl_users')->row();
            $user_id = $u ? $u->user_id : $this->current_user_id;
        }

        $profile_user = $this->get_user_summary($user_id);
        if (!$profile_user) {
            redirect('x');
        }

        $tab = $this->input->get('tab', true) ?: 'posts';

        $this->db->select('tbl_social_posts.*, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar, tbl_designations.designations');
        $this->db->from('tbl_social_posts');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_account_details.designations_id', 'left');

        if ($tab == 'likes') {
            $this->db->join('tbl_social_likes', 'tbl_social_likes.post_id = tbl_social_posts.post_id', 'inner');
            $this->db->where('tbl_social_likes.user_id', $user_id);
        } else {
            $this->db->where('tbl_social_posts.user_id', $user_id);
        }

        $this->db->order_by('tbl_social_posts.post_id', 'DESC');
        $posts = $this->db->get()->result();

        foreach ($posts as &$p) {
            $p->poll = $this->get_post_poll($p->post_id);
        }

        // Stats
        $followers_count = $this->db->where('following_id', $user_id)->count_all_results('tbl_social_follows');
        $following_count = $this->db->where('follower_id', $user_id)->count_all_results('tbl_social_follows');
        $is_following = (bool)$this->db->where('follower_id', $this->current_user_id)->where('following_id', $user_id)->count_all_results('tbl_social_follows');

        $data = [
            'page' => 'profile',
            'tab' => $tab,
            'profile_user' => $profile_user,
            'followers_count' => $followers_count,
            'following_count' => $following_count,
            'is_following' => $is_following,
            'posts' => $posts,
            'current_user' => $this->current_user,
            'user_likes' => $this->get_user_likes_map($this->current_user_id),
            'user_bookmarks' => $this->get_user_bookmarks_map($this->current_user_id),
            'trending' => $this->get_trending_hashtags(),
            'who_to_follow' => $this->get_who_to_follow($this->current_user_id),
        ];

        $this->load->view('x/layout', $data);
    }

    // 7. Status / Thread View
    public function status($post_id)
    {
        $this->db->select('tbl_social_posts.*, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar, tbl_designations.designations');
        $this->db->from('tbl_social_posts');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_account_details.designations_id', 'left');
        $this->db->where('tbl_social_posts.post_id', $post_id);
        $post = $this->db->get()->row();

        if (!$post) {
            redirect('x');
        }

        // Increment views count
        $this->db->set('views_count', 'views_count + 1', false)->where('post_id', $post_id)->update('tbl_social_posts');
        $post->views_count++;
        $post->poll = $this->get_post_poll($post_id);

        // Get replies thread
        $this->db->select('tbl_social_posts.*, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar, tbl_designations.designations');
        $this->db->from('tbl_social_posts');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_social_posts.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_account_details.designations_id', 'left');
        $this->db->where('tbl_social_posts.parent_post_id', $post_id);
        $this->db->order_by('tbl_social_posts.post_id', 'ASC');
        $replies = $this->db->get()->result();

        $data = [
            'page' => 'status',
            'post' => $post,
            'replies' => $replies,
            'current_user' => $this->current_user,
            'user_likes' => $this->get_user_likes_map($this->current_user_id),
            'user_bookmarks' => $this->get_user_bookmarks_map($this->current_user_id),
            'trending' => $this->get_trending_hashtags(),
            'who_to_follow' => $this->get_who_to_follow($this->current_user_id),
        ];

        $this->load->view('x/layout', $data);
    }

    // 8. Create Post with Poll & Media
    public function create_post()
    {
        $content = trim($this->input->post('content', true));
        if (empty($content)) {
            redirect('x');
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

        $parent_post_id = $this->input->post('parent_post_id', true) ?: null;
        $quote_post_id = $this->input->post('quote_post_id', true) ?: null;

        $post_data = [
            'user_id' => $this->current_user_id,
            'content' => $content,
            'media_url' => $media_url,
            'parent_post_id' => $parent_post_id,
            'quote_post_id' => $quote_post_id,
            'hashtags' => $hashtags,
            'likes_count' => 0,
            'reposts_count' => 0,
            'replies_count' => 0,
            'views_count' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('tbl_social_posts', $post_data);
        $post_id = $this->db->insert_id();

        // Check if Poll was created
        $opt1 = $this->input->post('poll_opt1', true);
        $opt2 = $this->input->post('poll_opt2', true);
        $opt3 = $this->input->post('poll_opt3', true);
        $opt4 = $this->input->post('poll_opt4', true);

        if (!empty($opt1) && !empty($opt2)) {
            $poll_data = [
                'post_id' => $post_id,
                'option_1' => $opt1,
                'option_2' => $opt2,
                'option_3' => $opt3,
                'option_4' => $opt4,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))
            ];
            $this->db->insert('tbl_social_polls', $poll_data);
        }

        // Notify if reply
        if (!empty($parent_post_id)) {
            $this->db->set('replies_count', 'replies_count + 1', false)->where('post_id', $parent_post_id)->update('tbl_social_posts');
            $orig = $this->db->where('post_id', $parent_post_id)->get('tbl_social_posts')->row();
            if ($orig && $orig->user_id != $this->current_user_id) {
                $this->db->insert('tbl_social_notifications', [
                    'user_id' => $orig->user_id,
                    'from_user_id' => $this->current_user_id,
                    'type' => 'reply',
                    'post_id' => $post_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            redirect('x/status/' . $parent_post_id);
            return;
        }

        redirect('x');
    }

    // 9. Vote Poll (AJAX)
    public function vote_poll()
    {
        $poll_id = (int)$this->input->post('poll_id', true);
        $option_num = (int)$this->input->post('option_num', true);

        $exists = $this->db->where('poll_id', $poll_id)->where('user_id', $this->current_user_id)->get('tbl_social_poll_votes')->row();
        if (!$exists && in_array($option_num, [1, 2, 3, 4])) {
            $this->db->insert('tbl_social_poll_votes', [
                'poll_id' => $poll_id,
                'user_id' => $this->current_user_id,
                'option_num' => $option_num,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        $poll = $this->db->where('poll_id', $poll_id)->get('tbl_social_polls')->row();
        $poll_data = $this->get_post_poll($poll->post_id);

        echo json_encode(['status' => 'success', 'poll' => $poll_data]);
        exit();
    }

    // Helper functions
    private function get_post_poll($post_id)
    {
        $poll = $this->db->where('post_id', $post_id)->get('tbl_social_polls')->row();
        if (!$poll) return null;

        $votes = $this->db->where('poll_id', $poll->poll_id)->get('tbl_social_poll_votes')->result();
        $total_votes = count($votes);
        $counts = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
        $my_vote = null;

        foreach ($votes as $v) {
            $counts[$v->option_num] = ($counts[$v->option_num] ?? 0) + 1;
            if ($v->user_id == $this->current_user_id) {
                $my_vote = $v->option_num;
            }
        }

        return [
            'poll_id' => $poll->poll_id,
            'total_votes' => $total_votes,
            'my_vote' => $my_vote,
            'is_voted' => $my_vote !== null,
            'options' => [
                ['num' => 1, 'text' => $poll->option_1, 'votes' => $counts[1], 'pct' => $total_votes > 0 ? round(($counts[1] / $total_votes) * 100) : 0],
                ['num' => 2, 'text' => $poll->option_2, 'votes' => $counts[2], 'pct' => $total_votes > 0 ? round(($counts[2] / $total_votes) * 100) : 0],
                !empty($poll->option_3) ? ['num' => 3, 'text' => $poll->option_3, 'votes' => $counts[3], 'pct' => $total_votes > 0 ? round(($counts[3] / $total_votes) * 100) : 0] : null,
                !empty($poll->option_4) ? ['num' => 4, 'text' => $poll->option_4, 'votes' => $counts[4], 'pct' => $total_votes > 0 ? round(($counts[4] / $total_votes) * 100) : 0] : null,
            ]
        ];
    }

    private function get_user_summary($user_id)
    {
        $this->db->select('tbl_users.user_id, tbl_users.username, tbl_users.email, tbl_account_details.fullname, tbl_account_details.avatar, tbl_designations.designations');
        $this->db->from('tbl_users');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_users.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_account_details.designations_id', 'left');
        $this->db->where('tbl_users.user_id', $user_id);
        return $this->db->get()->row();
    }

    private function get_all_colleagues()
    {
        $this->db->select('tbl_users.user_id, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar');
        $this->db->from('tbl_users');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_users.user_id', 'left');
        $this->db->where('tbl_users.user_id !=', $this->current_user_id);
        return $this->db->get()->result();
    }

    private function get_following_ids($user_id)
    {
        $res = $this->db->where('follower_id', $user_id)->get('tbl_social_follows')->result();
        $ids = [];
        foreach ($res as $r) $ids[] = $r->following_id;
        return $ids;
    }

    private function get_user_likes_map($user_id)
    {
        $res = $this->db->where('user_id', $user_id)->get('tbl_social_likes')->result();
        $map = [];
        foreach ($res as $r) $map[$r->post_id] = true;
        return $map;
    }

    private function get_user_bookmarks_map($user_id)
    {
        $res = $this->db->where('user_id', $user_id)->get('tbl_social_bookmarks')->result();
        $map = [];
        foreach ($res as $r) $map[$r->post_id] = true;
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
        return array_slice($tags, 0, 7, true);
    }

    private function get_who_to_follow($user_id)
    {
        $following = $this->get_following_ids($user_id);
        $following[] = $user_id;

        $this->db->select('tbl_users.user_id, tbl_users.username, tbl_account_details.fullname, tbl_account_details.avatar, tbl_designations.designations');
        $this->db->from('tbl_users');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_users.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id = tbl_account_details.designations_id', 'left');
        $this->db->where_not_in('tbl_users.user_id', $following);
        $this->db->limit(4);
        return $this->db->get()->result();
    }
}
