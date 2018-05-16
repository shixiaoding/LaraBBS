<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        // xss 过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);

        //seo url 翻译
        if (!$topic->slug) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
            //推送任务到队列
            //dispatch(new TranslateSlug($topic));
        }
    }
}
