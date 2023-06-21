<?php
declare(strict_types=1);

namespace Phlexus\Modules\Blog\Models;

use Phlexus\Models\Model;
use Phlexus\Libraries\Media\Models\Media;
use Phalcon\Paginator\Adapter\QueryBuilder;
use Phalcon\Mvc\Model\Resultset\Simple;

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
     * @return Simple|null
     */
    public static function getBlogs(int $page = 1): ?Simple
    {
        $p_model = self::class;

        $query = self::query()
            ->createBuilder()
            ->columns("
                $p_model.id AS blogID,
                CAT.id AS categoryID,

            ")
            
            ->innerJoin(BlogCategories::class, "$p_model.id = BCAT.blogID", 'BCAT')
            ->innerJoin(BlogCategory::class, 'BCAT.categoryID = CAT.id', 'CAT')
            ->orderBy("$p_model.id DESC");

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
