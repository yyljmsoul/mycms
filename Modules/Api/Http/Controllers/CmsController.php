<?php


namespace Modules\Api\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Requests\ArticleCommentRequest;
use Modules\Cms\Models\ArticleComment;

class CmsController extends ApiController
{
    /**
     * 分类列表
     * @return JsonResponse
     */
    public function categories(): JsonResponse
    {
        $categories = $this->collectFilterField(categories() ?: [], [
            'updated_at'
        ], true);

        return $this->success(['result' => $categories]);
    }

    /**
     * 分类详情
     * @return JsonResponse
     */
    public function categoryInfo(): JsonResponse
    {
        $id = $this->param('id', 'intval');
        $category = app('cms')->categoryInfo($id) ?: [];

        if ($category) {

            $category = $this->objectFilterField($category, ['updated_at'], true);
        }

        return $this->success(['result' => $category]);
    }

    /**
     * 文章列表
     * @return JsonResponse
     */
    public function articles(): JsonResponse
    {
        $page = $this->param('page', 'intval', 1);
        $limit = $this->param('limit', 'intval', 10);
        $tag = $this->param('tag', '', 'new');
        $params = request()->input('params', '[]');

        $result = [];
        $articles = articles($page, $limit, $tag, json_decode($params, true)) ?: [];

        if ($articles) {

            $result = $this->pageFilterField($articles);
            $result['data'] = [];

            foreach ($articles as $item) {

                $value = $this->objectFilterField($item, [
                    'content'
                ], true);

                $value['tags'] = $this->collectFilterField(article_tags($item->id), [
                    'id', 'tag_name'
                ]);

                $result['data'][] = $value;
            }
        }

        return $this->success(['result' => $result]);
    }

    /**
     * 文章详情
     * @return JsonResponse
     */
    public function articleInfo(): JsonResponse
    {
        $id = $this->param('id', 'intval');
        $meta = $this->param('meta', '', 0);

        if ($article = article($id, (bool)$meta)) {

            $article = $this->objectFilterField($article, [], true);

            $article['tags'] = $this->collectFilterField(article_tags($id), [
                'id', 'tag_name'
            ]);

            app('cms')->articleAddView($id);

            return $this->success(['result' => $article]);
        }

        return $this->success(['result' => []]);

    }

    /**
     * 文章评论
     * @return JsonResponse
     */
    public function comments(): JsonResponse
    {
        $id = $this->param('id', 'intval');
        $root = $this->param('root', 'intval', 0);
        $page = $this->param('page', 'intval', 1);
        $limit = $this->param('limit', 'intval', 10);

        $result = [];

        if ($comments = article_comments($id, $root, $page, $limit)) {

            $result = $this->pageFilterField($comments);
            $result['data'] = [];

            foreach ($comments as $comment) {

                $value = $this->objectFilterField($comment, [
                    'status', 'updated_at'
                ], true);

                $result['data'][] = $value;
            }

        }

        return $this->success(['result' => $result]);

    }

    /**
     * 发布文章评论
     * @param ArticleCommentRequest $request
     * @return JsonResponse
     */
    public function submitComment(ArticleCommentRequest $request): JsonResponse
    {
        $config = system_config([], 'cms');

        if (isset($config['is_allow_comment']) && $config['is_allow_comment'] == 1) {

            $data = $request->validated();
            $content = strip_tags(paramFilter($data['content']));

            if (article($data['single_id'])) {

                $rid = 0;

                if (isset($data['parent_id']) && $data['parent_id']) {

                    $obj = comment($data['parent_id'], $data['single_id']);

                    if (!$obj) {

                        return $this->error(['msg' => '该评论不存在或还在审核中.']);
                    }

                    $rid = $obj->parent_id == 0 ? $obj->id : $obj->root_id;
                }

                $comment = [
                    'single_id' => $data['single_id'],
                    'user_id' => $this->getUserId(),
                    'root_id' => $rid,
                    'parent_id' => $data['parent_id'] ?? 0,
                    'status' => isset($config['is_auto_status']) && $config['is_auto_status'] == 1 ? 1 : 0,
                    'content' => $content,
                ];

                $object = new ArticleComment();
                $result = $object->store($comment);

                if ($result) {
                    return $this->success(['msg' => '评论成功', 'result' => $object->id]);
                }
            }

        }

        return $this->error(['msg' => "评论失败"]);

    }

}
