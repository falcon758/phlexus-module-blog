<?php
declare(strict_types=1);

namespace Phlexus\Modules\Blog\Models;

use Phlexus\Models\Model;

/**
 * Class UserBlogs
 *
 * @package Phlexus\Modules\Blog\Models
 */
class UserBlogs extends Model
{
    public const DISABLED = 0;

    public const ENABLED = 1;

    /**
     * @var int|null
     */
    public $id;

    /**
     * @var int|null
     */
    public $active;

    /**
     * @var int
     */
    public int $userID;

    /**
     * @var int
     */
    public int $blogID;

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
        $this->setSource('user_blogs');

        $this->hasOne('userID', User::class, 'id', [
            'alias'    => 'user',
            'reusable' => true,
        ]);

        $this->hasOne('blogID', Blog::class, 'id', [
            'alias'    => 'blog',
            'reusable' => true,
        ]);
    }
}
