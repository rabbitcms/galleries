<?php
declare(strict_types=1);

namespace RabbitCMS\Galleries\Http\Requests;

use RabbitCMS\Carrot\Http\Request;

/**
 * Class GalleryCreateRequest
 */
class GalleryCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'caption' => 'required',
            'active' => 'required'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'caption' => 'Заголовок',
            'active' => 'Статус'
        ];
    }
}
