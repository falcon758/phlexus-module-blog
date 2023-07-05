<?php
declare(strict_types=1);

namespace Phlexus\Modules\Blog\Models;

use Phlexus\Models\Model;
use Phlexus\Libraries\Media\Models\Media;
use Phalcon\Paginator\Adapter\QueryBuilder;
use Phalcon\Paginator\Repository;

/**
 * Class Blog
 *
 * @package Phlexus\Modules\Blog\Models
 */
class Blog extends Model
{
    public const DISABLED = 0;

    public const ENABLED = 1;

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string|null
     */
    public $url;

    /**
     * @var int
     */
    public $featuredImageID;

    /**
     * @var int|null
     */
    public $active;

    /**
     * @var string|null
     */
    public $createdAt;

    /**
     * @var string|null
     */
    public $modifiedAt;

    /**
     * Initialize
     *
     * @return void
     */
    public function initialize()
    {
        $this->setSource('blog');
        
        $this->hasOne('featuredImageID', Media::class, 'id', [
            'alias'    => 'featuredImage',
            'reusable' => true,
        ]);

        $this->hasMany('id', BlogCategories::class, 'blogID', [
            'alias'    => 'categories',
            'reusable' => true,
        ]);
    }

    /**
     * Get translations
     *
     * @param int $page
     *
     * @return Repository|null
     */
    public static function getBlogs(int $page = 1): ?Repository
    {
        $p_model = self::class;

        $query = self::query()
            ->createBuilder()
            ->columns("
                $p_model.id AS blogID,
                GROUP_CONCAT(CAT.id, ',') AS categoryID,
                GROUP_CONCAT(CAT.category, ',') AS categoryName,
                $p_model.title AS blogTitle,
                $p_model.description AS blogDescription,
                $p_model.url AS blogUrl,
                IMG.mediaName
            ")
            
            ->innerJoin(BlogCategories::class, "$p_model.id = BCAT.blogID", 'BCAT')
            ->innerJoin(BlogCategory::class, 'BCAT.categoryID = CAT.id', 'CAT')
            ->innerJoin(Media::class, "$p_model.featuredImageID = IMG.id", 'IMG')
            ->orderBy("$p_model.id DESC")
            ->groupBy("$p_model.id");

        return (
            new QueryBuilder(
                [
                    'builder' => $query,
                    'limit'   => self::PAGE_LIMIT,
                    'page'    => $page,
                ]
            )
        )->paginate();
    }
}
