<?php
declare(strict_types=1);

namespace RabbitCMS\Galleries\DataProviders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use RabbitCMS\Carrot\Support\Grid2 as BaseDataProvider;
use RabbitCMS\Galleries\Entities\Gallery as GalleryEntity;

/**
 * Class GalleriesDataProvider
 */
class GalleriesDataProvider extends BaseDataProvider
{
    public static $status = [
        0 => 'Приховано',
        1 => 'Опубліковано'
    ];

    /**
     * @return Eloquent
     */
    public function getModel(): Eloquent
    {
        return new GalleryEntity;
    }

    protected function filters(Builder $query, array $filters): Builder
    {
        if (array_key_exists('id', $filters) && $filters['id'] !== '') {
            $query->where('id', '=', $filters['id']);
        }
        if (array_key_exists('caption', $filters) && $filters['caption'] !== '') {
            $query->where('caption', 'like', $filters['caption']);
        }
        if (array_key_exists('active', $filters) && $filters['active'] !== '') {
            $query->where('active', '=', $filters['active']);
        }

        return $query;
    }

    /**
     * @param Eloquent $row
     *
     * @return array
     */
    protected function prepareRow(Eloquent $row): array
    {
        /* @var GalleryEntity $row */
        $result = [
            'id' => $row->id,
            'caption' => $row->caption,
            'status' => self::$status[(int)$row->active] ?? $row->active,
            'actions' => [
                'edit' => relative_route('backend.galleries.galleries.edit', ['id' => $row->id]),
                'delete' => relative_route('backend.galleries.galleries.delete', ['id' => $row->id])
            ]
        ];

        return $result;
    }
}
