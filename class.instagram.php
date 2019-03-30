<?php
class instagram_story{
    protected function file_get_contents_curl($url){
        $cookies = dirname(__FILE__)."/cookie.txt" ;
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($curl, CURLOPT_COOKIEFILE, $cookies);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
        $answer = curl_exec($curl);
        curl_close($curl);
        return $answer;
    }
    public function getStory($username){
        $url = file_get_contents("https://www.instagram.com/$username/");
        $json = '/sharedData\s=\s(.*[^\"]);<.script>/ixU';
        preg_match_all($json, $url, $jsondata, PREG_SET_ORDER, 0);
        $array = json_decode($jsondata[0][1], true);
        $user_id = $array['entry_data']['ProfilePage']['0']['graphql']['user']['id'];
        $stories = $this->file_get_contents_curl("https://www.instagram.com/graphql/query/?query_hash=de8017ee0a7c9c45ec4260733d81ea31&variables=%7B%22reel_ids%22%3A%5B%22$user_id%22%5D%2C%22tag_names%22%3A%5B%5D%2C%22location_ids%22%3A%5B%5D%2C%22highlight_reel_ids%22%3A%5B%5D%2C%22precomposed_overlay%22%3Afalse%2C%22show_story_viewer_list%22%3Atrue%2C%22story_viewer_fetch_count%22%3A50%2C%22story_viewer_cursor%22%3A%22%22%7D");
        $data = json_decode($stories, true);
        $stories = $data['data']['reels_media']['0']['items'];
        $_story = [];
        foreach ($stories as $story) {
            $vid = 'video_resources';
            if (!array_key_exists($vid, $story)) {
                $_story [] = $story['display_url'];
            } else {
                $_story [] = $story['video_resources'][0]['src'];
            }
        }
        foreach ($_story as $story) {
            $check = '/mp4/m';
            preg_match_all($check, $story, $matches, PREG_SET_ORDER, 0);
            if (empty($matches)) {
                echo "<a href=$story&dl=1><img src=$story></a>";
            } else {
                echo '<video width="320" height="240" controls>';
                echo '<source src="' . $story . '" type="video/mp4">';
                echo '</video>';
                echo "<a href=$story&dl=1>Download</a>";
            }
        }
    }
}
