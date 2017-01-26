<?php
declare(strict_types=1);

namespace RabbitCMS\Galleries\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Gallery
 *
 * @property integer $id
 * @property string $caption
 * @property string $slug
 * @property boolean $active
 * @property-read Item[] $items
 */
class Gallery extends Model
{
    use SoftDeletes;

    protected $table = 'galleries';

    protected $fillable = [
        'caption',
        'slug',
        'active'
    ];

    /**
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
