<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 25.09.18
 * Time: 14:51
 */

namespace App\Services\Channels;


use App\Http\Requests\Api\v1\Auth\RegistrationRequest;
use App\Http\Requests\ChannelRequest;
use App\Models\Channels\Channel;
use App\Notifications\InviteToChannelNotification;
use App\Repositories\Channels\ChannelRepository;
use App\Repositories\Users\UserRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Channels\AddIntegrationRequest;
use Faker\Factory;
use App\Http\Requests\DialogRequest;

class ChannelService
{
    /**
     * @var ChannelRepository
     */
    protected $repository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ChannelService constructor.
     * @param ChannelRepository $repository
     * @param UserRepository $user
     */
    public function __construct(ChannelRepository $repository,UserRepository $user)
    {
        $this->repository = $repository;
        $this->userRepository = $user;
    }

    /**
     * Создание канала
     * @param ChannelRequest $request
     * @return Channel
     * @throws \Throwable
     */
    public function create(ChannelRequest $request): Channel
    {
        return \DB::transaction(function () use ($request) {
            $channel = $this->repository->create($request);

            $channel->users()->sync($request->get('user_ids'));

            return $channel;
        });
    }

    /**
     * Создание диалога
     *
     * @param DialogRequest $request
     * @return mixed
     * @throws \Throwable
     */
    public function createDialog(DialogRequest $request)
    {
        return \DB::transaction(function () use ($request) {
            $channel = $this->repository->createDialog($request->owner_id,$request->to_id);

            $channel->users()->sync([$request->owner_id,$request->to_id]);

            return $channel;
        });
    }

    /**
     * Добавить юзера в канал
     * @param Request $request
     * @return Channel|null
     */
    public function addUser(Request $request)
    {
        $channel = $this->repository->findById($request->channel_id);

        if(!$channel->users()->where('users.user_id',$request->get('user_id'))->exists()){
            $channel->users()->attach($request->get('user_id'));
        }

        return $channel;
    }

    /**
     * Удалить юзера из канала
     * @param Request $request
     * @return Channel|null
     */
    public function deleteUser(Request $request)
    {
        $channel = $this->repository->findById($request->channel_id);
        $channel->users()->detach($request->user_id);

        return $channel;
    }

    /**
     * Редактирование канала
     * @param ChannelRequest $request
     * @param Channel $channel
     * @return Channel
     * @throws \Throwable
     */
    public function update(ChannelRequest $request, Channel $channel): Channel
    {
        return \DB::transaction(function () use ($request, $channel) {
            $this->repository->update($request, $channel);

            $channel->users()->sync($request->get('user_ids'));

            return $channel;
        });
    }

    /**
     * Удаление канала
     * @param Channel $channel
     * @return bool
     * @throws \Exception
     */
    public function destroy(Channel $channel)
    {
        return $this->repository->destroy($channel);
    }

    /**
     * Добавление интеграции в канал
     * @param AddIntegrationRequest $request
     * @param $id
     */
    public function addIntegration(AddIntegrationRequest $request,$id)
    {
        $channel = $this->repository->findById($id);
        $channel->integrations()->attach([$request->integration_id =>['data'=>json_encode($request->data)]]);
    }

    /**
     * Приглашение в канал по email
     * @param string $email
     * @param int $channel_id
     * @return \App\Models\User|\Illuminate\Database\Eloquent\Builder
     */
    public function addUserByEmail(string $email,int $channel_id)
    {

        $user = $this->userRepository->findByEmailOrUsername($email);

        if($user){
            $this->addUser(new Request([
                'channel_id'=>$channel_id,
                'user_id'=>$user->user_id,
            ]));

        }else{
            $password = Factory::create()->password;

            $user = $this->userRepository->create(new RegistrationRequest([
                  'email'=>$email,
                  'login'=>$email,
                  'username'=>$email,
                  'password'=>$password,
            ]));

            $user->notify(new InviteToChannelNotification($this->repository->findById($channel_id),$password));
        }

        return $user;
    }
}
