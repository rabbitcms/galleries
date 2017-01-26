<?php
declare(strict_types=1);

namespace RabbitCMS\Galleries\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Item
 *
 * @property integer $id
 * @property integer $gallery_id
 * @property string $path
 * @property integer $weight
 */
class Item extends Model
{
    use SoftDeletes;

    protected $table = 'galleries_items';

    protected $fillable = [
        'path',
        'weight'
    ];
}
