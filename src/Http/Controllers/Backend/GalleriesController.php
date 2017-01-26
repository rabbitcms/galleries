<?php
declare(strict_types=1);

namespace RabbitCMS\Galleries\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RabbitCMS\Backend\Annotation\Permissions;
use RabbitCMS\Backend\Support\Backend;
use RabbitCMS\Galleries\DataProviders\GalleriesDataProvider;
use RabbitCMS\Galleries\Entities\Gallery as GalleryEntity;
use RabbitCMS\Galleries\Entities\Item as GalleryItemEntity;
use RabbitCMS\Galleries\Http\Requests\GalleryCreateRequest;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class GalleriesController
 * @Permissions("galleries.galleries.read")
 */
class GalleriesController extends Controller
{
    /**
     * @param Backend $backend
     */
    public function init(Backend $backend)
    {
        $parent = config('module.galleries.backend_menu');

        $backend->setActiveMenu($parent === null ? 'galleries' : $parent . '.galleries');
    }

    /**
     * @return View
     */
    public function getIndex()
    {
        return $this->view('backend.galleries.index');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function postIndex(Request $request)
    {
        return (new GalleriesDataProvider)->response($request);
    }

    /**
     * @return View
     *
     * @Permissions("galleries.galleries.write")
     */
    public function getCreate()
    {
        return $this->view('backend.galleries.create');
    }

    /**
     * @param GalleryCreateRequest $request
     *
     * @return JsonResponse
     * @throws MassAssignmentException
     * @throws HttpResponseException
     *
     * @Permissions("galleries.galleries.write")
     */
    public function postCreate(GalleryCreateRequest $request)
    {
        $model = new GalleryEntity;

        $data = $request->only('caption', 'slug', 'active');
        $data['slug'] = $data['slug'] === '' ? Str::slug($data['caption']) : $data['slug'];

        $model->fill($data)
            ->save();

        return \Response::json($model->toArray());
    }

    /**
     * @param $id
     *
     * @return View
     * @throws ModelNotFoundException
     */
    public function getEdit($id)
    {
        /* @var GalleryEntity $model */
        $model = GalleryEntity::query()
            ->findOrFail($id);

        $files = $model->items()
            ->getQuery()
            ->orderBy('weight', 'asc')
            ->get();

        return $this->view('backend.galleries.form', compact('model', 'files'));
    }

    /**
     * @param $id
     * @param Request $request
     *
     * @throws MassAssignmentException
     * @throws ModelNotFoundException
     * @throws HttpResponseException
     *
     * @Permissions("galleries.galleries.write")
     */
    public function postEdit($id, Request $request)
    {
        $model = GalleryEntity::query()
            ->findOrFail($id);

        $data = $request->only('caption', 'slug', 'active');
        $data['slug'] = $data['slug'] === '' ? Str::slug($data['caption']) : $data['slug'];

        $model->fill($data)
            ->save();

        foreach ((array)$request->input('weight', []) as $index => $item_id) {
            GalleryItemEntity::query()
                ->where('id', '=', $item_id)
                ->update(['weight' => $index]);
        }

        $this->success('Збережено.');
    }

    /**
     * @param $id
     * @param Request $request
     *
     * @return JsonResponse|false
     * @throws FileException
     * @throws ModelNotFoundException
     */
    public function postUploadFile($id, Request $request)
    {
        /* @var UploadedFile[] $files */
        $files = $request->file('files', []);
        $result = [];

        if (count($files)) {
            /* @var GalleryEntity $gallery */
            $gallery = GalleryEntity::query()
                ->findOrFail($id);

            foreach ($files as $file) {
                $caption = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                $upload_path = '/files/galleries/' . $id;
                if (file_exists(public_path($upload_path . '/' . $caption))) {
                    $caption = basename($caption, '.' . $extension) . '_' . time() . '.' . $extension;
                }
                $file->move(public_path($upload_path), $caption);

                /* @var GalleryItemEntity $tmp_gallery_item */
                $tmp_gallery_item = GalleryItemEntity::query()
                    ->where('gallery_id', '=', $id)
                    ->orderBy('weight', 'desc')
                    ->first(['weight']);

                $weight = $tmp_gallery_item ? $tmp_gallery_item->weight + 1 : 0;

                $data = [
                    'weight' => $weight,
                    'path' => $upload_path . '/' . $caption
                ];

                /* @var GalleryItemEntity $gallery_item */
                $gallery_item = $gallery->items()->create($data);

                $result[] = [
                    'id' => $gallery_item->id,
                    'weight' => $gallery_item->weight,
                    'path' => $gallery_item->path,
                    'caption' => basename($gallery_item->path),
                    'delete' => relative_route('backend.galleries.galleries.file.delete', ['id' => $gallery_item->id])
                ];
            }

            return \Response::json(['files' => $result], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return false;
    }

    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function postDeleteFile($id)
    {
        GalleryItemEntity::query()
            ->findOrFail($id)
            ->delete();
    }
}
