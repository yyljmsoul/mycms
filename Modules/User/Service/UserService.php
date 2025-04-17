<?php


namespace Modules\User\Service;


use App\Service\MyService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use Modules\User\Models\UserAddress;
use Modules\User\Models\UserBalance;
use Modules\User\Models\UserPoint;
use Modules\User\Models\UserRank;

class UserService extends MyService
{
    /**
     * 会员余额变动
     * @param float $balance
     * @param int $id
     * @param $desc
     * @return bool
     */
    public function balance(float $balance, int $id, $desc = ''): bool
    {
        DB::beginTransaction();
        try {
            $user = $this->user($id);
            $log = (new UserBalance())->store([
                'user_id' => $id,
                'before' => $user['balance'],
                'balance' => $balance,
                'after' => ($balance + $user['balance']),
                'description' => $desc,
            ]);

            $user->balance = ($balance + $user['balance']);
            $result = $user->save();

            if ($result !== false && $log !== false) {
                Db::commit();
                return true;
            } else {
                Db::rollBack();
                return false;
            }

        } catch (\Exception $e) {
            Db::rollBack();
            return false;
        }

    }

    /**
     * 会员积分变动
     * @param float $point
     * @param int $id
     * @param $desc
     * @return bool
     */
    public function point(float $point, int $id, $desc = ''): bool
    {
        DB::beginTransaction();

        try {

            $user = $this->user($id);
            $log = (new UserPoint())->store([
                'user_id' => $id,
                'before' => $user['point'],
                'point' => $point,
                'after' => ($point + $user['point']),
                'description' => $desc,
            ]);

            $user->point = ($point + $user['point']);
            $result = $user->save();

            if ($result !== false && $log !== false) {
                Db::commit();
                return true;
            } else {
                Db::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            Db::rollBack();
            return false;
        }
    }

    /**
     * 获取单个用户
     * @param $param
     * @return mixed
     */
    public function user($param)
    {

        if (is_array($param)) {
            return User::where([$param])->first();
        }

        if (is_string($param) || strlen($param) === 11) {
            return User::where('name', $param)->first();
        }

        if (is_numeric($param)) {
            return User::find($param);
        }
    }

    /**
     * @param $user
     * @return mixed
     */
    public function userFields($user)
    {
        // 会员等级
        $user->rank_name = $user->rank > 0 ? UserRank::find($user->rank)->name : '';

        return $user;
    }

    /**
     * 生成会员
     * @param $name
     * @param $password
     * @param string $mobile
     * @param array $params
     * @return false|mixed
     */
    public function generateUser($name, $password, $mobile = '', $params = [])
    {
        $user = $this->user($name);

        if (!$user) {

            $data = [
                'name' => $name,
                'password' => Hash::make($password),
                'mobile' => $mobile ?: mb_substr($name, 0, 11),
            ];

            $user = new User();
            $user->store(empty($params) ? $data : array_merge($data, $params));

            return $user->id;

        }

        return false;
    }

    /**
     * 返回所有会员等级
     * @return mixed
     */
    public function ranks()
    {
        return UserRank::orderBy("number", "asc")->get();
    }

    /**
     * 返回所有会员收货地址
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function addresses($uid)
    {
        return UserAddress::with([
            'province:id,name,adcode',
            'city:id,name,adcode',
            'district:id,name,adcode'
        ])
            ->where('user_id', $uid)
            ->orderBy('is_default', 'desc')
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get();
    }

    /**
     * 返回所有会员收货地址详情
     * @return mixed
     */
    public function address($id, $uid)
    {
        return UserAddress::with(['province:id,name', 'city:id,name', 'district:id,name'])
            ->where([
                ['user_id', '=', $uid],
                ['id', '=', $id],
            ])->first();
    }

    /**
     * 新增会员收货地址
     * @return mixed
     */
    public function addressStore($data)
    {
        $id = UserAddress::insert($data);

        if ($data['is_default']) {

            $this->addressDefaultHandle($data['user_id'], $id);
        }

        return $id;
    }

    /**
     * 更新会员收货地址
     * @return mixed
     */
    public function addressUpdate($data, $id)
    {
        if ($data['is_default']) {

            $this->addressDefaultHandle($data['user_id'], $id);
        }

        return UserAddress::where([
            ['id', '=', $id],
            ['user_id', '=', $data['user_id']]
        ])->update($data);
    }

    /**
     * 处理默认收货地址
     * @param $userId
     * @param $defaultId
     * @return void
     */
    protected function addressDefaultHandle($userId, $defaultId)
    {
        if ($defaultId) {
            UserAddress::where([
                ['id', '<>', $defaultId],
                ['user_id', '=', $userId]
            ])->update(['is_default' => 0]);
        }
    }

    /**
     * 删除会员收货地址
     * @return mixed
     */
    public function addressDelete($userId, $id)
    {
        return UserAddress::where([
            ['id', '=', $id],
            ['user_id', '=', $userId]
        ])->delete();
    }


    /**
     * 获取用户默认收货地址
     * @param $userId
     * @return mixed
     */
    public function getUserDefaultAddress($userId)
    {
        return UserAddress::with([
            'province:id,name,adcode',
            'city:id,name,adcode',
            'district:id,name,adcode'
        ])->where([
            ['user_id', '=', $userId]
        ])->orderBy('is_default', 'desc')->first();
    }
}
