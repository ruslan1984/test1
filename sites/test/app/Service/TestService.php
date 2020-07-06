<?php

namespace Service;

use Model\Test;

class TestService

{
    private $testModel;

    function __construct()
    {
        $this->testModel = new Test();
    }
    public function pageCount(): int
    {
        $rows = $this->testModel->length();
        return (int) (($rows - 1) / 3) + 1;
    }
    public function data(array $request)
    {
        $page = 1;
        if (!empty($request['page'])) {
            $page = $request['page'];
        }
        $sortName = "created_at";
        $sortOrder = "DESC";
        if (!empty($request['sort_name'])) {
            $sortName = $request['sort_name'];
        }
        if (!empty($request['sort_order'])) {
            $sortOrder = $request['sort_order'];
        }
        $limit = 3;
        $result = $this->testModel->data($page, $limit, $sortName, $sortOrder);
        if (!empty($result)) {
            foreach ($result as &$item) {
                $status = json_decode($item->status, true);
                $item->taskReady = isset($status['ready']);
                $item->status = implode(', ', $status);
                
            }
        }
        return $result;
    }
    public function update(array $request)
    {
        $editTask = false;
        $status = $this->testModel->getStatus($request['id']);
        if ((isset($request['id'])) && (isset($request['task']))) {
            $existTask = $this->testModel->getTask($request['id'], $request['task']);
            if (!$existTask) {
                $this->testModel->updateTask($request['id'], $request['task']);
                $status['edited'] = 'Редактировано администратором';
            }        
        }
        if ((isset($request['id'])) && (isset($request['taskReady']))) {
            unset($status['new']);
            if ($request['taskReady']) {
                $status['ready'] = 'Выполнено';
                unset($status['not_ready']);
            } else {
                $status['not_ready'] = 'Не выполнено';
                unset($status['ready']);
            }
            $this->testModel->updateStatus($request['id'], $status);
        }
        return 1;
    }
    public function insert(array $request):bool
    {
        $data = $request;
        $data['status'] = json_encode(['new' => 'Новыя задача']);
        return $this->testModel->insert($data);
    }
}
