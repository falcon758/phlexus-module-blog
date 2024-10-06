<?php
declare(strict_types=1);

namespace Phlexus\Modules\Blog\Models;

use Phlexus\Libraries\Media\Models\Media;
use Phlexus\Models\Model;

/**
 * Class BlogCategory
 *
 * @package Phlexus\Modules\Blog\Models
 */
class BlogCategory extends Model
{
    public const DISABLED = 0;

    public const ENABLED = 1;

    /**
     * @var int|null
     */
    public ?int $id = null;

    /**
     * @var string
     */
    public string $category;

    /**
     * @var int|null
     */
    public ?int $active = null;

    /**
     * @var int|null
     */
    public ?int $parentID = null;

    /**
     * @var string|null
     */
    public ?string $createdAt = null;

    /**
     * @var string|null
     */
    public ?string $modifiedAt = null;

    /**
     * Initialize
     *
     * @return void
     */
    public function initialize()
    {
        $this->setSource('blog_category');
        
        $this->hasOne('parentID', BlogCategory::class, 'id', [
            'alias'    => 'parentCategory',
            'reusable' => true,
        ]);

        $this->hasMany('id', BlogCategories::class, 'categoryID', [
            'alias'    => 'blogs',
            'reusable' => true,
        ]);
    }
}
