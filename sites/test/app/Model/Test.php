<?php

namespace Model;

use \Illuminate\Database\Capsule\Manager as Capsule;


class Test extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function data($page = 1, $limit = 3, $sortName = 'created_at', $sortOrder = "desc")
    {
        $page = $page ?? 1;
        $offset = ($page - 1) * $limit;
        return Capsule::table('data')->offset($offset)->limit($limit)->orderBy($sortName, $sortOrder)->get()->toArray();
    }
    public function insert(array $data)
    {
        return Capsule::table('data')->insert($data);
    }
    public function updateTask(int $id, string $task)
    {
        return Capsule::table('data')->where(['id' => $id])->update(['task' => $task]);
    }

    public function update(array $requst)
    {
        $id = $requst['id'];
        unset($requst['id']);
        return Capsule::table('data')->where(['id' => $id])->update($requst);
    }
    public function length()
    {
        return Capsule::table('data')->count();
    }
    public function getStatus(int $id)//: array
    {
        $result = Capsule::table('data')->where(['id' => $id])->select('status')->get()->toArray();
        $status = $result[0]->status;
        return json_decode($status, true);
    }
    public function getTask(int $id, string $task): bool
    {
        $result = Capsule::table('data')->where(['id' => $id, 'task' => $task])->select('id')->get()->toArray();
        if (empty($result)) {
            return false;
        }
        return true;
    }
    public function updateStatus(int $id, array $status)
    {
        $st = json_encode($status);
        return Capsule::table('data')->where(['id' => $id])->update(['status'=>$st]);
    }
}
