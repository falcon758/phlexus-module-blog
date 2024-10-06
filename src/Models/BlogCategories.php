<?php
declare(strict_types=1);

namespace Phlexus\Modules\Blog\Models;

use Phlexus\Libraries\Media\Models\Media;
use Phlexus\Models\Model;

/**
 * Class BlogCategories
 *
 * @package Phlexus\Modules\Blog\Models
 */
class BlogCategories extends Model
{
    public const DISABLED = 0;

    public const ENABLED = 1;

    /**
     * @var int|null
     */
    public ?int $id;

    /**
     * @var int
     */
    public int $blogID;

    /**
     * @var int
     */
    public int $categoryID;

    /**
     * @var int|null
     */
    public ?int $active;

    /**
     * @var string|null
     */
    public ?string $createdAt;

    /**
     * @var string|null
     */
    public ?string $modifiedAt;

    /**
     * Initialize
     *
     * @return void
     */
    public function initialize()
    {
        $this->setSource('blog_categories');
        
        $this->hasOne('blogID', Blog::class, 'id', [
            'alias'    => 'blog',
            'reusable' => true,
        ]);

        $this->hasOne('categoryID', BlogCategory::class, 'id', [
            'alias'    => 'category',
            'reusable' => true,
        ]);
    }
}
