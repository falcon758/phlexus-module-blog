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
    public ?int $id;

    /**
     * @var string
     */
    public string $category;

    /**
     * @var int|null
     */
    public ?int $active;

    /**
     * @var int|null
     */
    public ?int $parentID;

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
