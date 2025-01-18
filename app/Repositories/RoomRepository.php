<?php

namespace App\Repositories;
use App\Traits\GlobalResponse;
use App\Models\Room;
use DB;

class RoomRepository extends BaseRepository
{
    protected $model;
    public function __construct(Room $model)
    {
        $this->model = $model;
        //$this->model = DB::table('services');
    }
/*
    public function all()
    {
        return $this->model->all();
    }

    public function getPaginate($n)
    {
        return $this->model->paginate($n);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $result = $this->find($id);
        if (!$result) {
            return false;
        }
        return $result->update($data);
    }

    public function delete(int $id)
    {
        $result = $this->find($id);
        if (!$result) {
            return false;
        }
        return $result->delete();
    } */
}
