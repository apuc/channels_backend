<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.10.18
 * Time: 17:11
 */

namespace App\Services\Files;


use App\Http\Requests\Files\AvatarRequest;
use App\Models\Avatar;
use App\Repositories\Files\AvatarRepository;
use App\Traits\FilePath;
use File;
use Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvatarService
{
    use FilePath;

    protected $repository;

    public function __construct(AvatarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function upload(UploadedFile $file, string $type)
    {

        $avatar = \Image::make($file->getPathname());
        $hash = md5($file->getClientOriginalName() . time());
        $folder = '/img/' . $type . '/' . $hash[0] . '/' . $hash[0] . $hash[1] . '/';
        $path = storage_path('app/public' . $folder);
        $ext = $file->getClientOriginalExtension();

        $request = $this->createRequest([
            'origin' => $folder . $hash . '.' . $ext,
            'average' => $folder . $hash . '_' . Avatar::SIZE_AVERAGE . '.' . $ext,
            'small' => $folder . $hash . '_' . Avatar::SIZE_SMALL . '.' . $ext,
            'status' => Avatar::STATUS_ACTIVE,
        ]);

        $this->makeFolder($path, 0775);

        $avatar->save($path . $hash . '.' . $ext);
        $avatar->widen(Avatar::SIZE_AVERAGE)->save($path . $hash . '_' . Avatar::SIZE_AVERAGE . '.' . $ext);
        $avatar->fit(Avatar::SIZE_SMALL)->save($path . $hash . '_' . Avatar::SIZE_SMALL . '.' . $ext);

        return $request;

    }

    public function save(AvatarRequest $request)
    {
        return $this->repository->create($request);
    }

    /**
     * @param $data
     * @return AvatarRequest
     */
    public function createRequest($data)
    {
        $request = new AvatarRequest();
        $request->origin = $data['origin'];
        $request->average = $data['average'];
        $request->small = $data['small'];
        $request->status = $data['status'];

        return $request;
    }

    /**
     * @param Avatar $avatar
     */
    public function destroy(Avatar $avatar)
    {
        $this->deleteFile([
            storage_path('app/public' . $avatar->origin),
            storage_path('app/public' . $avatar->average),
            storage_path('app/public' . $avatar->small),
        ]);
        $this->repository->destroy($avatar);
    }

}