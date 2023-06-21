<?php
declare(strict_types=1);

namespace Phlexus\Modules\Blog\Controllers;

use Phlexus\Modules\Blog\Models\Blog;
use Phalcon\Tag;

/**
 * Class IndexController
 *
 * @package Phlexus\Modules\Blog\Controllers
 */
final class IndexController extends AbstractController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        $title = $this->translation->setTypePage()->_('title-blog');

        Tag::setTitle($title);

        $blogs = Blog::getBlogs((int) $this->request->get('p', null, 1));

        $this->view->setVar('csrfToken', $this->security->getToken());
        $this->view->setVar('blogs', $blogs);
    }
}
