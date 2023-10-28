<?php
declare(strict_types=1);

namespace Phlexus\Modules\Blog\Controllers;

use Phlexus\Modules\Blog\Models\Blog;
use Phalcon\Tag;

/**
 * Class BlogController
 *
 * @package Phlexus\Modules\Blog\Controllers
 */
final class BlogController extends AbstractController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        $title = $this->translation->setTypePage()->_('title-blog');

        Tag::setTitle($title);

        $page       = (int) $this->request->get('p', null, 1);
        $categoryID = (int) $this->request->get('cat', null, 0);

        $blogs = Blog::getBlogs($page, $categoryID);

        $this->view->setVar('totalPages', $blogs->total_pages);
        $this->view->setVar('page', $blogs->current);
        $this->view->setVar('blogs', $blogs);
    }

    public function viewAction(int $blogID)
    {
        $title = $this->translation->setTypePage()->_('title-blog-view');

        Tag::setTitle($title);

        $blog = Blog::getBlog($blogID);

        if (!$blog) {
            return $this->response->redirect('blog');
        }

        $this->view->setVar('blog', $blog);
    }
}
