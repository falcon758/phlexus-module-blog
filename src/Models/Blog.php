<?php
declare(strict_types=1);

namespace Phlexus\Modules\Blog\Models;

use Phlexus\Models\Model;
use Phlexus\Libraries\Media\Models\Media;
use Phalcon\Paginator\Adapter\QueryBuilder;
use Phalcon\Paginator\Repository;
use Phalcon\Mvc\Model\Row;

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
     * @var int|null
     */
    public ?int $id;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var string|null
     */
    public ?string $url;

    /**
     * @var int|null
     */
    public ?int $featuredImageID;

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
     * Get blogs
     *
     * @param int $page
     * @param int $categoryID
     *
     * @return Repository|null
     */
    public static function getBlogs(int $page = 1, int $categoryID = 0): ?Repository
    {
        $p_model = self::class;

        $query = self::query()
            ->createBuilder()
            ->columns("
                $p_model.id AS blogID,
                GROUP_CONCAT(CAT.id, ',') AS categoryID,
                GROUP_CONCAT(CAT.category, ',') AS categoryName,
                $p_model.title AS title,
                $p_model.description AS description,
                $p_model.url AS url,
                DATE_FORMAT($p_model.createdAt, '%Y-%m-%d') AS createdAt,
                DATE_FORMAT($p_model.modifiedAt, '%Y-%m-%d') AS modifiedAt,
                IMG.mediaName
            ")
            ->leftJoin(BlogCategories::class, "$p_model.id = BCAT.blogID", 'BCAT')
            ->leftJoin(BlogCategory::class, 'BCAT.categoryID = CAT.id', 'CAT')
            ->leftJoin(Media::class, "$p_model.featuredImageID = IMG.id", 'IMG')
            ->orderBy("$p_model.id DESC")
            ->groupBy("$p_model.id");

        if ($categoryID > 0) {
            $query->where('CAT.id = :categoryID:', ['categoryID' => $categoryID]);
        }

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

    /**
     * Get blog
     *
     * @param int $blogID
     *
     * @return Row|null
     */
    public static function getBlog(int $blogID): ?Row
    {
        $p_model = self::class;

        return self::query()
        ->columns("
            $p_model.id AS blogID,
            GROUP_CONCAT(CAT.id, ',') AS categoryID,
            GROUP_CONCAT(CAT.category, ',') AS categoryName,
            $p_model.title AS title,
            $p_model.description AS description,
            $p_model.url AS url,
            DATE_FORMAT($p_model.createdAt, '%Y-%m-%d') AS createdAt,
            DATE_FORMAT($p_model.modifiedAt, '%Y-%m-%d') AS modifiedAt,
            IMG.mediaName
        ")
        ->leftJoin(BlogCategories::class, "$p_model.id = BCAT.blogID", 'BCAT')
        ->leftJoin(BlogCategory::class, 'BCAT.categoryID = CAT.id', 'CAT')
        ->leftJoin(Media::class, "$p_model.featuredImageID = IMG.id", 'IMG')
        ->where(
            "$p_model.id = :ID: AND $p_model.active = :active:",
            [
                'ID'     => $blogID,
                'active' => self::ENABLED,
            ]
        )
        ->groupBy("$p_model.id")
        ->execute()
        ->getFirst();
    }
}
