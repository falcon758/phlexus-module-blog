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
    public ?int $id = null;

    /**
     * @var int|null
     */
    public ?int $active = null;

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
